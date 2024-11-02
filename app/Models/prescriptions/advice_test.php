<?php

namespace App\Models\prescriptions;

use Illuminate\Database\Eloquent\Model;

class advice_test extends Model
{
    protected $table ='advice_tests';
    protected $fillable = ['name', 'user_id', 'details'];
}
