<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;
	
	protected $table = 'works';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
