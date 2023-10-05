<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookUserRole extends Model
{
    protected $table = 'book_user_role';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
