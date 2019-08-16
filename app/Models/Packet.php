<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packet extends Model
{
    use SoftDeletes;
	
	protected $table = 'packets';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function meal()
    {
        return $this->belongsTo('App\Models\Meal');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
