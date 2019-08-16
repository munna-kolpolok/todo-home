<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;


class Sr_Setting extends Model
{
    use SoftDeletes;
    use Translatable;
	
	protected $table = 'sr_settings';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public $translationModel = 'App\Models\Sr_Setting_Translation';
    public $translationForeignKey = 'sr_setting_id';
    public $translatedAttributes = ['whome_donate','why_donate','how_donate','intro_title','intro_description','home_project_short_desc','home_video_title','home_video_subtitle','home_work_short_desc','work_food_desc','work_edu_desc','work_shelter_desc',
    	'work_medical_desc','work_clothing_desc','work_training_desc',
    	'home_volunteer_message','about_title','about_subtitle',
    	'about_description','about_who_we_are','about_what_we_do','mission_title','mission_subtitle_up','mission_subtitle_down','mission_description','mission_heading_1','mission_heading_1_desc','mission_heading_2','mission_heading_2_desc','vision_video_title','vision_video_subtitle_up','vision_video_subtitle_down','vision_title','vision_subtitle','vision_description','contact_address','receipt_body'
	];

}
