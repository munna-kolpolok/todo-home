<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation_Package extends Model
{
    use SoftDeletes;
	
	protected $table = 'donation_packages';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

}
