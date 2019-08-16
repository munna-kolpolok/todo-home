<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_Image extends Model
{
    use SoftDeletes;
	
	protected $table = 'project_images';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
