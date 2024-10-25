<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'notes',
        'img',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
