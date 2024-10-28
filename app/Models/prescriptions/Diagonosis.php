<?php

namespace App\Models\prescriptions;

use Illuminate\Database\Eloquent\Model;

class Diagonosis extends Model
{
    protected $fillable = [
        'name',
        'descriptions',
        'user_id',
    ];

    protected $table = 'diagonosis';


}
