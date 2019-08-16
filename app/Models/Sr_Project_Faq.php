<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;


class Sr_Project_Faq extends Model
{
    use SoftDeletes;
    use Translatable;

	protected $table = 'sr_project_faqs';

	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public $translationModel = 'App\Models\Sr_Project_Faq_Translation';
    public $translationForeignKey = 'sr_project_faq_id';
    public $translatedAttributes = ['question','answer'];

	public function sr_project_translation()
	{
		return $this->hasOne('App\Models\Sr_Project_Translation', 'sr_project_id', 'sr_project_id')->where('locale', 'en');
	}


}
