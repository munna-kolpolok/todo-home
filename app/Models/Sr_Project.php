<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App;
use \Dimsav\Translatable\Translatable;


class Sr_Project extends Model
{
    use SoftDeletes;
    use Translatable;
	
	protected $table = 'sr_projects';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public $translationModel = 'App\Models\Sr_Project_Translation';
    public $translationForeignKey = 'sr_project_id';
    public $translatedAttributes = ['name','description','title','subtitle','video'];

    public function objectives()
    {
        return $this->hasMany('App\Models\Sr_Project_Objective','sr_project_id');
    }
    public function stories()
    {
        return $this->hasMany('App\Models\Sr_Project_Story','sr_project_id');
    }
    public function sliders()
    {
        return $this->hasMany('App\Models\Sr_Project_Slider','sr_project_id');
    }
    public function faqs()
    {
        return $this->hasMany('App\Models\Sr_Project_Faq','sr_project_id');
    }
    public function translations()
    {
        return $this->hasMany('App\Models\Sr_Project_Translation','sr_project_id');
    }
    public function translation()
    {
        return $this->hasOne('App\Models\Sr_Project_Translation','sr_project_id')->where('locale','en');
    }

    

}
