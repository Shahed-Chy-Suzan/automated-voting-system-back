<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'position_id', 'age', 'team'
    ];
}
