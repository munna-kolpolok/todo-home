<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sr_Setting_Translation extends Model
{
    use SoftDeletes;

    protected $table = 'sr_setting_translations';

    protected $hidden = [];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $fillable = [];

    public function language()
    {
        return $this->belongsTo('App\Models\Language', 'locale', 'code');
    }

}