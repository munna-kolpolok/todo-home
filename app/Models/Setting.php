<?php
/**
 * Created by PhpStorm.
 * User: rubel.kolpolok
 * Date: 12/11/2018
 * Time: 11:47 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public $timestamps = false;

    protected $hidden = [];

    protected $guarded = [];
}