<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery_Category extends Model
{
    use SoftDeletes;
	
	protected $table = 'gallery_categories';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function galleries()
    {
        return $this->hasMany(Gallery::class,'gallery_category_id');
	}

    public function website()
    {
        return $this->belongsTo(Website::class,'website_id');
	}
}
