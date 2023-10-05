<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed $id
 * @property mixed $content
 * @property mixed $title
 * @property mixed $book_id
 */
class Section extends Model
{
    protected $fillable = ['title', 'content', 'book_id'];

    public function book(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function children() {
        return $this->hasManyThrough(
            self::class,
            SectionClosure::class,
            'ancestor',
            'id',
            'id',
            'descendant'
        )->where('depth', 1);
    }
    public function parentSectionId()
    {
        $ancestor = SectionClosure::where('descendant', $this->id)
            ->whereColumn('ancestor', '!=', 'descendant')
            ->first();

        return $ancestor ? $ancestor->ancestor : null;
    }

    public function getParentSectionAttribute()
    {
        return Section::find($this->parentSectionId());
    }
}
