<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inbox_Chat extends Model
{
    use SoftDeletes;
	
	protected $table = 'inbox_chats';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];


	public function inbox()
    {
        return $this->belongsTo('App\Models\Inbox');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function agent()
    {
        return $this->belongsTo('App\Models\User');
    }

}
