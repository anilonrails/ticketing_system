<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const ROLES = [
        'Admin'=>'Admin',
        'Agent'=>'Agent'
    ];


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
