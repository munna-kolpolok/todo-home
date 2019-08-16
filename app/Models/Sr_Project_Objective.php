<?php

namespace App\Models;

use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Dimsav\Translatable\Translatable;


class Sr_Project_Objective extends Model
{
    use SoftDeletes;
    use Translatable;

    protected $table = 'sr_project_objectives';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public $translationModel = 'App\Models\Sr_Project_Objective_Translation';
    public $translationForeignKey = 'sr_project_objective_id';
    public $translatedAttributes = ['objective'];


    public function sr_project_translation()
    {
        return $this->hasOne('App\Models\Sr_Project_Translation', 'sr_project_id', 'sr_project_id')->where('locale', 'en');
    }

}
