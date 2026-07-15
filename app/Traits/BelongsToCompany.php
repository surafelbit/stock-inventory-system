<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToCompany
{
    /**
     * The "booted" method of the trait.
     * Laravel automatically executes this when any Model using this trait is loaded.
     */
    protected static function booted(): void
    {
        // 1. Automatically filter all SELECT, UPDATE, and DELETE queries by the logged-in user's company
        if (Auth::check()) {
            static::addGlobalScope('company', function (Builder $builder) {
                $builder->where('company_id', Auth::user()->company_id);
            });
        }

        // 2. Automatically assign 'company_id' when a new record is being created
        static::creating(function ($model) {
            if (Auth::check() && empty($model->company_id)) {
                $model->company_id = Auth::user()->company_id;
            }
        });
    }

    /**
     * Relationship back to the Company.
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }
}