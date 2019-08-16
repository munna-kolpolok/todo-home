<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paypal_Payment extends Model
{
    use SoftDeletes;
	
	protected $table = 'paypal_payments';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function sr_project()
    {
        return $this->belongsTo('App\Models\Sr_Project');
    }

    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


}
