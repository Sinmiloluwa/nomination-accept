<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    use HasFactory;
    protected $fillable = ['fullname','email','years_of_experience','image','country_of_origin','country_of_residence','facebook','linkedin','instagram','category_id'];
}
