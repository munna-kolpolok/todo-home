<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use SoftDeletes;
	
	protected $table = 'sectors';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }
}
