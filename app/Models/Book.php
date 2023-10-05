<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed|string $title
 * @property mixed $author_id
 * @property mixed $sections
 * @property mixed|string|null $description
 * @property mixed $id
 */
class Book extends Model
{
    protected $fillable = ['title', 'description'];  // Add other fields as necessary

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_user_role')->withPivot('role_id')->withTimestamps();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'book_user_role')->withPivot('user_id')->withTimestamps();
    }

    public function sections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function usersWithRoles()
    {
        return $this->belongsToMany(User::class, 'book_user_role')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    // Convenient method to get users with a specific role
    public function getUsersByRole($roleName)
    {
        return $this->usersWithRoles()->wherePivot('role_id', function ($query) use ($roleName) {
            $query->from('roles')->where('name', $roleName)->select('id');
        })->get();
    }

    public function collaborators()
    {

        return $this->belongsToMany(User::class, 'book_user_role', 'book_id', 'user_id')
            ->wherePivot('role_id', function ($query) {
                $query->select('id')
                    ->from((new Role())->getTable())
                    ->where('slug', 'collaborator')
                    ->limit(1);
            })
            ->withTimestamps();
    }
}
