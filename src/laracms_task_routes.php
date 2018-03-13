<?php

Route::group([
    'middleware' => ['web', 'laracms.auth'],
    'namespace'  => 'Grundmanis\Laracms\Modules\TaskManager\Controllers',
    'prefix'     => 'laracms/task-manager'
], function () {
    Route::get('/', 'TaskController@index')->name('laracms.task');
    Route::get('/{task}', 'TaskController@show')->name('laracms.task.show');
    Route::get('/create', 'TaskController@create')->name('laracms.task.create');
    Route::post('/create', 'TaskController@store');
    Route::get('/edit/{task}', 'TaskController@edit')->name('laracms.task.edit');
    Route::post('/edit/{task}', 'TaskController@update');
    Route::get('/destroy/{task}', 'TaskController@destroy')->name('laracms.task.destroy');

});