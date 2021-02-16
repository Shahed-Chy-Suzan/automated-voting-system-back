<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'voter_name', 'age', 'nid', 'finger_print_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id', 'userId');
    }

}
