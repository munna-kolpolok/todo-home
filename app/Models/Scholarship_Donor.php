<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship_Donor extends Model
{
    use SoftDeletes;
	
	protected $table = 'scholarship_donors';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
