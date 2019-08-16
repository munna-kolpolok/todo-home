<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship extends Model
{
    use SoftDeletes;
	
	protected $table = 'scholarships';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

    public function donor()
    {
        return $this->belongsTo('App\Models\Donor');
    }

}
