<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Project_Slider extends Model
{
    use SoftDeletes;

    protected $table = 'sr_project_sliders';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function translation()
    {
        return $this->hasOne('App\Models\Sr_Project_Translation','sr_project_id','sr_project_id')->where('locale','en');
    }
}