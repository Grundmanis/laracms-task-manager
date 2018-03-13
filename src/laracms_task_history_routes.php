<?php

Route::group([
    'middleware' => ['web', 'laracms.auth'],
    'namespace'  => 'Grundmanis\Laracms\Modules\TaskManager\Controllers',
    'prefix'     => 'laracms/task-manager'
], function () {
    Route::get('/work/{task}', 'TaskHistoryController@work')->name('laracms.task.work');
});