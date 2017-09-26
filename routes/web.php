<?php

Route::get('/', 'IndexController@index_get');
Route::get('/about', 'AboutController@about_get');
Route::get('/calculator/{dis?}/{time?}/{temp?}/{ph?}/{logGiardia?}/{calcMethod?}', 'CalcController@calculator_get');
Route::post('/calculator', 'CalcController@calculator_post');
