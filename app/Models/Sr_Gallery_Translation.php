<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Gallery_Translation extends Model
{
    use SoftDeletes;
	
	protected $table = 'sr_gallery_translations';
	
	protected $hidden = [];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

    public function galleryLanguage()
    {
        return $this->belongsTo(Language::class,'locale','code');
    }
}