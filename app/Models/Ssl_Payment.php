<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ssl_Payment extends Model
{
    use SoftDeletes;
	
	protected $table = 'ssl_payments';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

}
