<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookService
{
    /**
     * Create a new book and associate it with a user (author).
     *
     * @param User $user The author of the book.
     * @param string $title Title of the book.
     * @param string|null $description (Optional) Description of the book.
     *
     * @return Book Returns the created book.
     */
    public function createBook(User $user, string $title, string $description = null): Book
    {
        $book = new Book();
        $book->title = $title;
        $book->author_id = $user->id;
        $book->description = $description;
        $book->save();

        return $book;
    }

    /**
     * Retrieve the root sections of a given book.
     *
     * The root sections are the top-most sections that do not have a parent.
     *
     * @param Book $book The book for which the root sections are being fetched.
     *
     * @return \Illuminate\Database\Eloquent\Collection Returns a collection of root sections for the given book.
     */
    public function getRootSectionsForBook(Book $book): Collection
    {
        return Section::where('book_id', $book->id)
            ->whereNotIn('id', function ($query) {
                $query->select('descendant')
                    ->from('section_closure')
                    ->where('depth', '>', 0);
            })->get();

    }

    /**
     * Update the details of a given book.
     *
     * @param array $data An associative array containing the book details to update.
     * @param Book $book The book to be updated.
     *
     * @return Book Returns the updated book.
     */
    public function updateBook(array $data, Book $book): Book
    {
        $validatedData = collect($data)->only(['title', 'description'])->toArray();
        $book->update($validatedData);
        return $book;
    }
}

