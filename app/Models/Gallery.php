<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;
	
	protected $table = 'galleries';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	 public function gallery_category()
    {
        return $this->belongsTo(Gallery_Category::class);
	}
}
