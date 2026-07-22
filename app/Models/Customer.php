<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use BelongsToCompany; // Secures multi-tenant data isolation automatically!

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}