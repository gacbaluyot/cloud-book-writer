<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Models\Book;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        return view('book.create');
    }

    public function store(CreateBookRequest $request)
    {
        $this->service->createBook(auth()->user(), $request->getTitle(), $request->getDescription());
        return redirect()->route('author.dashboard')->with('success', 'Book is Created Successfully');
    }

    public function show(Book $book): \Illuminate\Contracts\View\View
    {
        $rootSections = $this->service->getRootSectionsForBook($book);
        return view('book.show', compact('book', 'rootSections'));
    }

    public function edit(Book $book)
    {
        $collaboratorRole = Role::where('slug', 'collaborator')->first();
        $collaborators = User::where('role_id', $collaboratorRole->id)->get();
        $rootSections = $this->service->getRootSectionsForBook($book);
        $roles = Role::all();  // Fetch all roles for the role dropdown
        $sections = Section::all(); // Or fetch only the top-level sections if needed

        return view('book.edit', compact('book', 'collaborators', 'roles', 'rootSections', 'sections'));
    }

    public function update(Request $request, Book $book): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->service->updateBook($request->all(), $book);
            return redirect()->route('author.dashboard')->with('success', 'Book updated successfully');
        } catch (\Exception $exception) {
            logger($exception);
            return redirect()->route('author.dashboard')->with('error', 'Book update fail');
        }
    }

    public function assignRoleToUser(Request $request, Book $book)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::where('id', $request->user_id)->first();
        // Check if user is already assigned this role for the book
        $alreadyAssigned = $book->usersWithRoles()
            ->wherePivot('user_id', $request->user_id)
            ->wherePivot('role_id', $user->role_id)
            ->exists();

        if ($alreadyAssigned) {
            return redirect()->back()->with('error', 'This user already has the specified role for this book.');
        }

        // Attach the user to the book with the specified role
        $book->usersWithRoles()->attach($request->user_id, ['role_id' => $user->role_id]);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }

    /**
     * Remove the specified collaborator from the book.
     *
     * @param int $bookId
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeCollaborator($bookId, $userId)
    {
        // Find the book by its ID
        $book = Book::findOrFail($bookId);

        // Detach the collaborator (user) from this book
        $book->collaborators()->detach($userId);

        return redirect()->back()->with('success', 'Collaborator removed successfully.');
    }


}
