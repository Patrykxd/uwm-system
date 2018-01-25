<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return redirect('/admin/login');
});

use App\Console\Commands\CronRobot;

Route::get('/admin/get', function () {

   dd('t');
});

Route::get('/admin/login', 'Admin\Login@index');
Route::get('/admin/create', 'Admin\Login@createUser');

Route::group(['prefix' => '/admin'], function () {

    Route::post('/auth', 'Admin\Login@auth');

    Route::get('/start', 'Admin\Start@index');
    Route::get('/logout', 'Admin\Login@logout');

    //nowe projekty
    Route::get('/scrapler/projects', 'Admin\Scrapler\Scrapler@projects');
    Route::get('/scrapler/project/new', 'Admin\Scrapler\Scrapler@newProject');
    Route::post('/scrapler/project/add', 'Admin\Scrapler\Scrapler@addProject');

    //nowy project z pliku xml
    Route::get('/scrapler/project/add-xml', 'Admin\Scrapler\Scrapler@addProjectXML');
    Route::post('/scrapler/project/new-xml', 'Admin\Scrapler\Scrapler@newProjectXml');

    //linki uzytkownika z projektu id = x
    Route::get('/scrapler/project/id/{id}', 'Admin\Scrapler\Scrapler@links')->middleware('project');

    //edycja projektu id = x
    Route::get('/scrapler/project/edit/{id}', 'Admin\Scrapler\Scrapler@editProject')->middleware('project');
    Route::post('/scrapler/project/edit-save/{id}', 'Admin\Scrapler\Scrapler@saveProject')->middleware('project');

    //dodanie nowego linku do projektu id = x
    Route::get('/scrapler/project/add-link/{id}', 'Admin\Scrapler\Scrapler@addLink')->middleware('project');
    Route::post('/scrapler/link/add-link/{id}', 'Admin\Scrapler\Scrapler@newLink')->middleware('project');

    //kasowanie projektu id = x
    Route::get('/scrapler/project/delete/{id}', 'Admin\Scrapler\Scrapler@deleteProject')->middleware('project');

    //edycja linków links_id = x
    Route::get('/scrapler/link/edit-link/{id}', 'Admin\Scrapler\Scrapler@editLink')->middleware('link');
    Route::post('/scrapler/link/save-link/{id}', 'Admin\Scrapler\Scrapler@saveLink')->middleware('link');

    //kasowanie linku links_id = x
    Route::get('/scrapler/link/delete/{id}', 'Admin\Scrapler\Scrapler@deleteLink')->middleware('link');
});

