<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'start',
        'target_hours',
        'separate_accounting',
    ];

    /**
     * get all users assigned to this account
     */
    public function users()
    {
        return $this->hasMany('App\Models\User','account_id','id');
    }

    /**
     * Scope a query to only include active accounts.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Scope a query to only include archived accounts.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->where('active', 0);
    }
}
