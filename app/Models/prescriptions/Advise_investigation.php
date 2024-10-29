<?php

namespace App\Models\prescriptions;

use Illuminate\Database\Eloquent\Model;

class Advise_investigation extends Model
{
    protected $table = 'advice_investigations';
    protected $fillable = ['name', 'user_id', 'description'];
}
