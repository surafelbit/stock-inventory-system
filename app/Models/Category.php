<?php

namespace App\Models;

use App\Traits\BelongsToCompany; // Import the trait we built yesterday
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use BelongsToCompany; // Apply the trait!

    protected $fillable = ['name', 'description'];
}