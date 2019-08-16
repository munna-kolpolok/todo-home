<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Press extends Model
{
    use SoftDeletes;
	
	protected $table = 'presses';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function press_category()
    {
        return $this->belongsTo(Press_Category::class);
	}
}
