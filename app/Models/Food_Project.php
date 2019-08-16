<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food_Project extends Model
{
    use SoftDeletes;
    
    protected $table = 'food_projects';
    
    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    
    public function food_project_details()
    {
        return $this->hasMany(Food_Project_Detail::class, 'food_project_id');
    }

}
