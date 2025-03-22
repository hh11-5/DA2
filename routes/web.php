<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dangky', function () {
    return view('dangky');
});


Route::get('/dangnhap', function () {
    return view('dangnhap');
});
