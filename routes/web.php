<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Skillcraft\Announcement\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'announcements', 'as' => 'announcement.'], function () {
            Route::resource('', 'AnnouncementController')->parameters(['' => 'announcement']);
        });
    });
});
