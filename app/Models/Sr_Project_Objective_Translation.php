<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Project_Objective_Translation extends Model
{
    use SoftDeletes;

    protected $table = 'sr_project_objective_translations';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function project_language()
    {
        return $this->belongsTo('App\Models\Language', 'locale', 'code');
    }

    public function sr_project_objective()
    {
        return $this->belongsTo('App\Models\Sr_Project_Objective');
    }

}