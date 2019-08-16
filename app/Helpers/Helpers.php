<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

function make_slug($string, $symbol = '-')
{
    return preg_replace( '/\s+/u', $symbol, trim( strtolower( $string ) ) );
}

function baseRoute($route = null)
{
    $route = $route ? $route : request()->route() ? request()->route()->getName() : null;
    return $route;
    //return substr( $route, 0, strpos( $route, '.' ) );
}

function camelCaseToSlug($input = null, $symbol = '-')
{
    $input = is_null( $input ) ? baseRoute() : $input;
    return strtolower( preg_replace( '/(?<!^)[A-Z]/', $symbol . '$0', $input ) );
}

function getModelName()
{
    $controller = class_basename( request()->route()->getAction()['controller'] );
    $controller = explode( '@', $controller )[0];

    $modelName = str_replace( "Controller", "", $controller );

    $path = strtolower( $modelName );

    if (strlen( preg_replace( '![^A-Z]+!', '', $controller ) ) > 2) {
        $path = $modelName;
    }

    $lastCaracter = substr( $path, -1 );

    if ($lastCaracter != 's') {
        $path = $path . 's';
    }

    return "App\\" . ucfirst( str_singular( $path ) );
}

function remove_slug($title, $symbol = '-')
{
    return str_replace( $symbol, ' ', $title );
}

