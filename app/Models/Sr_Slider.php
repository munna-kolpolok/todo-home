<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;


class Sr_Slider extends Model
{
    use SoftDeletes;
    use Translatable;

    protected $table = 'sr_sliders';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public $translationModel = 'App\Models\Sr_Slider_Translation';
    public $translationForeignKey = 'sr_slider_id';
    public $translatedAttributes = ['title','sub_title','description_up','description_down'];

    public function translation()
    {
        return $this->hasOne('App\Models\Sr_Slider_Translation', 'sr_slider_id')->where('locale', 'en');
    }

    public function sr_project_translation()
    {
        return $this->hasOne('App\Models\Sr_Project_Translation', 'sr_project_id', 'sr_project_id')->where('locale', 'en');
    }

}
