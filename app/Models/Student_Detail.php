<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student_Detail extends Model
{
    use SoftDeletes;
	
	protected $table = 'student_details';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at','date'];


	public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }

}
