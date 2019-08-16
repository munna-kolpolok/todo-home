<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Slider_Translation extends Model
{
    use SoftDeletes;
	
	protected $table = 'sr_slider_translations';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	protected $fillable = ['title','sub_title','description'];

	public function project_language()
	{
		return $this->belongsTo('App\Models\Language','locale','code');
	}
}