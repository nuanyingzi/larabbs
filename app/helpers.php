<?php

use Illuminate\Support\Facades\Route;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

// 导航栏 active 类判断
function active_class($condition, $class = 'active')
{
    return $condition ? $class : '';
}

// 判断 URL 查询参数
function if_query($key, $value = null)
{
    $query = request()->query($key);
    
    if (is_null($value)) {
        return !is_null($query);
    }
    
    return $query == $value;
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