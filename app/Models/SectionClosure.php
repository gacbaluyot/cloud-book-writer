<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $ancestor
 * @property int|mixed $depth
 * @property mixed $descendant
 */
class SectionClosure extends Model
{
    protected $table = 'section_closure';

    public $timestamps = false;

    protected $fillable = ['ancestor', 'descendant', 'depth'];

    public function ancestorSection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Section::class, 'ancestor');
    }

    public function descendantSection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Section::class, 'descendant');
    }
}
