<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Video_Category extends Model
{
    use SoftDeletes;
	
	protected $table = 'video_categories';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function videos()
    {
        return $this->hasMany(Video::class, 'video_category_id');
	}

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
	}

}
