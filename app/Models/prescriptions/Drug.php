<?php

namespace App\Models\prescriptions;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $table = 'drugs';
    protected $fillable =['user_id', 'name', 'generic_name', 'brand_name'];

}
