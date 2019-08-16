<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;


class Sr_Project_Story extends Model
{
    use SoftDeletes;
    use Translatable;
	
	protected $table = 'sr_project_stories';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public $translationModel = 'App\Models\Sr_Project_Story_Translation';
    public $translationForeignKey = 'sr_project_story_id';
    public $translatedAttributes = ['title','description'];

    public function project()
    {
        return $this->belongsTo(Sr_Project::class,'sr_project_id', 'id');
    }

    public function projectStoryTranslations()
    {
        return $this->hasMany(Sr_Project_Story_Translation::class, 'sr_project_story_id');
    }

    public function englishStory()
    {
        return $this->hasOne(Sr_Project_Story_Translation::class, 'sr_project_story_id')->where('locale','en');
    }

    public function projectStoryImages()
    {
        return $this->hasMany(Sr_Project_Story_Image::class, 'sr_project_story_id');
    }

    public function mainImage()
    {
        return $this->hasOne(Sr_Project_Story_Image::class, 'sr_project_story_id');
    }

}
