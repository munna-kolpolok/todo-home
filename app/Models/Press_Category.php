<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Press_Category extends Model
{
    use SoftDeletes;
	
	protected $table = 'press_categories';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function website()
    {
        return $this->belongsTo(Website::class,'website_id');
    }
}
