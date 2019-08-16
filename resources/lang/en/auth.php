<?php
use Illuminate\Support\Facades\Lang;
return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => Lang::get('messages.Wrong password'),
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

];
