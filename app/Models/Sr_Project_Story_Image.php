<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Project_Story_Image extends Model
{
    use SoftDeletes;
	
	protected $table = 'sr_project_story_images';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}