<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookUserRole;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * @property BookService $service
 */
class CollaboratorController extends Controller
{
    public function __construct(BookService $service)
    {
        $this->service = $service;
    }
    public function dashboard(
    ): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $books = BookUserRole::class::where('user_id', auth()->user()->id)->get();
        return view('collaborator.dashboard', compact('books'));
    }

    /**
     * @param Book $book
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(Book $book)
    {
        $rootSections = $this->service->getRootSectionsForBook($book);
        $roles = Role::all();  // Fetch all roles for the role dropdown
        $sections = Section::all(); // Or fetch only the top-level sections if needed

        return view('book.edit', compact('book', 'roles', 'rootSections', 'sections'));
    }
}
