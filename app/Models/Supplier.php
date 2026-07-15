<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use BelongsToCompany; // Instantly secures all supplier queries to the active tenant!

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}