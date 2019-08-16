<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign_Images extends Model
{
    use SoftDeletes;
	
	protected $table = 'campaign_images';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id');
	}
}
