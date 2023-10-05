<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;

class AuthorController extends Controller
{
    public function dashboard(
    ): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $books = Book::where('author_id', auth()->user()->id)->get();
        return view('author.dashboard', compact('books'));
    }
}
