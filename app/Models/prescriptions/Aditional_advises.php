<?php

namespace App\Models\prescriptions;

use Illuminate\Database\Eloquent\Model;

class Aditional_advises extends Model
{
    protected $table = 'additional_advises';
    protected $fillable = ['user_id','name', 'description'];
}
