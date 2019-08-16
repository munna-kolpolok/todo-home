<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
	
	protected $table = 'projects';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function project_type()
    {
        return $this->belongsTo('App\Models\Project_Type');
    }

    public function parent_project()
    {
        return $this->belongsTo(Project::class, 'parent');
    }

    public function images()
    {
        return $this->hasMany(Project_Image::class,'project_id');
    }

}
