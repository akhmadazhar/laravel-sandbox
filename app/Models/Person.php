<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $table = 'persons';
    protected $fillable = [
        'name',
        'email'
    ];

    public function education()
    {
        return $this->hasMany(Education::class);
    }
}
