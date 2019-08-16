<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Gallery_Image extends Model
{
    use SoftDeletes;
	
	protected $table = 'sr_gallery_images';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}