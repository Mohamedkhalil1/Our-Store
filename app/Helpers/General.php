<?php

use App\Models\Language;
use Illuminate\Support\Facades\Config;

define('PAGINATION_COUNT',15);
define('TYPE','parent');
define('SUTYPE','child');

function get_languages(){

    return Language::active()->selection()->get();
}

function get_default_lang(){
    return Config::get('app.locale');
}

function uploadImage($folder,$image){
    $image->store('/',$folder);
    $filename= $image->hashName();
    $path = 'images/'.$folder.'/'.$filename;
    return $path;
}

function getFolder(){
    $folder = app()->getLocale() === 'ar' ? 'css-rtl' : 'css';
    return $folder;
}