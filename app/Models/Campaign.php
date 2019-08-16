<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;
	
	protected $table = 'campaigns';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function website()
    {
        return $this->belongsTo(Website::class,'website_id');
	}

    public function images()
    {
        return $this->hasMany(Campaign_Images::class,'campaign_id');
	}
}
