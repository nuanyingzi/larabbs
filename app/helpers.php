<?php

use Illuminate\Support\Facades\Route;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// 生成摘要
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    
    if (mb_strlen($excerpt) <= $length) {
        return $excerpt;
    }
    
    return rtrim(mb_substr($excerpt, 0, $length)) . '...';
}