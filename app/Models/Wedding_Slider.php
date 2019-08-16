<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wedding_Slider extends Model
{
    use SoftDeletes;
	
	protected $table = 'wedding_sliders';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
