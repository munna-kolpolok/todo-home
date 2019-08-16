<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food_Project_Detail extends Model
{
    use SoftDeletes;
	
	protected $table = 'food_project_details';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function food_projects()
    {
        return $this->belongsTo('App\Models\Food_Project');
    }

    public function food_items()
    {
        return $this->belongsTo('App\Models\Food_Item');
    }

}
