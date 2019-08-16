<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food_Item extends Model
{
    use SoftDeletes;
	
	protected $table = 'food_items';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }
}
