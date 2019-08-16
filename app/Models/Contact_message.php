<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact_message extends Model
{
    use SoftDeletes;
	
	protected $table = 'contact_messages';

	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }
}
