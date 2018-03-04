<?php

Route::group([
    'middleware' => ['web', 'laracms.auth'],
    'namespace'  => 'Grundmanis\Laracms\Modules\TaskManager\Controllers',
    'prefix'     => 'laracms/task-manager'
], function () {
    Route::get('/', 'TaskManagerController@index')->name('laracms.tasks');
    Route::get('/create', 'TaskManagerController@create')->name('laracms.tasks.create');
    Route::post('/create', 'TaskManagerController@store');

    Route::get('/edit/{task}', 'TaskManagerController@edit')->name('laracms.tasks.edit');
    Route::post('/edit/{task}', 'TaskManagerController@update');

    Route::get('/destroy/{task}', 'TaskManagerController@destroy')->name('laracms.tasks.destroy');

    Route::get('/projects', 'TaskManagerProjectController@index')->name('laracms.tasks.projects');
    Route::get('/projects/create', 'TaskManagerProjectController@create')->name('laracms.tasks.projects.create');
    Route::post('/projects/create', 'TaskManagerProjectController@store');

    Route::get('/projects/edit/{project}', 'TaskManagerProjectController@edit')->name('laracms.tasks.projects.edit');
    Route::post('/projects/edit/{project}', 'TaskManagerProjectController@update');

    Route::get('/projects/destroy/{project}', 'TaskManagerProjectController@destroy')->name('laracms.tasks.projects.destroy');
});