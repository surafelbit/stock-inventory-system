<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    // $fillable tells Laravel which columns are safe to write data into
    protected $fillable = ['name'];

    // One Company has many Users
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}