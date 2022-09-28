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
}