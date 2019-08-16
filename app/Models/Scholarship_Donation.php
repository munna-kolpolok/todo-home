<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship_Donation extends Model
{
    use SoftDeletes;
	
	protected $table = 'scholarship_donations';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function scholarship()
    {
        return $this->belongsTo('App\Models\Scholarship');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }
    

}
