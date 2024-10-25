<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalties extends Model
{
    protected $fillable = [
        'salesperson_id',
        'start_date',
        'end_date',
        'reason',
        'is_exist',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
