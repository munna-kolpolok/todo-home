<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inbox extends Model
{
    use SoftDeletes;
	
	protected $table = 'inboxes';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function sector()
    {
        return $this->belongsTo('App\Models\Sector');
    }
    public function packet()
    {
        return $this->belongsTo('App\Models\Packet');
    }
    public function payment_method()
    {
        return $this->belongsTo('App\Models\Payment_Method');
    }
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function inboxChat()
    {
        return $this->hasMany(Inbox_Chat::class, 'inbox_id');
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

}
