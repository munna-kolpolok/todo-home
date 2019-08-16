<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
	
	protected $table = 'orders';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function food_project()
    {
        return $this->belongsTo('App\Models\Food_Project');
    }
    public function food_item()
    {
        return $this->belongsTo('App\Models\Food_Item');
    }
    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }
}