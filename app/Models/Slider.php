<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
	
	protected $table = 'sliders';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
