<?php

Route::group([
    'middleware' => ['web', 'laracms.auth'],
    'namespace'  => 'Grundmanis\Laracms\Modules\TaskManager\Controllers',
    'prefix'     => 'laracms/task-manager/project'
], function () {
    Route::get('/', 'TaskProjectController@index')->name('laracms.task.project');
    Route::get('/create', 'TaskProjectController@create')->name('laracms.task.project.create');
    Route::post('/create', 'TaskProjectController@store');
    Route::get('/edit/{project}', 'TaskProjectController@edit')->name('laracms.task.project.edit');
    Route::post('/edit/{project}', 'TaskProjectController@update');
    Route::get('/destroy/{project}', 'TaskProjectController@destroy')->name('laracms.task.project.destroy');
});