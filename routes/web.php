<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function(){
  Route::get('/login','MainController@login')->name('login');
  Route::get('/login?redirect={redirect}','MainController@login')->name('login.redirect');
  Route::post('/login','MainController@loginProcess')->name('login.process');
});

Route::middleware('auth')->group(function(){
  Route::get('/logout','MainController@logout')->name('logout');

  Route::middleware('role:admin')->group(function(){
    Route::prefix('admin')->group(function(){
      Route::get('/','MainController@adminDashboard')->name('admin.dashboard');

      Route::prefix('group')->group(function(){
        Route::get('/','GroupController@index')->name('admin.group.index');
        Route::get('/create','GroupController@create')->name('admin.group.create');
        Route::post('/create','GroupController@store')->name('admin.group.store');
        Route::get('/{uuid}/edit','GroupController@edit')->name('admin.group.edit');
        Route::post('/{uuid}/edit','GroupController@update')->name('admin.group.update');
        Route::get('/{uuid}/delete','GroupController@destroy')->name('admin.group.destroy');
      });

      Route::prefix('user')->group(function(){
        Route::get('/','UserController@index')->name('admin.user.index');
        Route::get('/create','UserController@create')->name('admin.user.create');
        Route::post('/create','UserController@store')->name('admin.user.store');
        Route::post('/import','UserController@import')->name('admin.user.import');
        Route::get('/{uuid}/edit','UserController@edit')->name('admin.user.edit');
        Route::post('/{uuid}/edit','UserController@update')->name('admin.user.update');
        Route::get('/{uuid}/delete','UserController@destroy')->name('admin.user.destroy');
      });

      Route::prefix('subject')->group(function(){
        Route::get('/','SubjectController@index')->name('admin.subject.index');
        Route::get('/create','SubjectController@create')->name('admin.subject.create');
        Route::post('/create','SubjectController@store')->name('admin.subject.store');
        Route::get('/{uuid}','SubjectController@show')->name('admin.subject.show');
        Route::get('/{uuid}/edit','SubjectController@edit')->name('admin.subject.edit');
        Route::post('/{uuid}/edit','SubjectController@update')->name('admin.subject.update');
        Route::get('/{uuid}/delete','SubjectController@destroy')->name('admin.subject.destroy');

        Route::prefix('{subject_uuid}/candidate')->group(function(){
          Route::get('/','CandidateController@index')->name('admin.candidate.index');
          Route::get('/create','CandidateController@create')->name('admin.candidate.create');
          Route::post('/create','CandidateController@store')->name('admin.candidate.store');
          Route::get('/{uuid}/edit','CandidateController@edit')->name('admin.candidate.edit');
          Route::post('/{uuid}/edit','CandidateController@update')->name('admin.candidate.update');
          Route::get('/{uuid}/delete','CandidateController@destroy')->name('admin.candidate.destroy');
        });
      });
    });
  });

  Route::middleware('role:guest')->group(function(){
    Route::get('/','VoteController@index')->name('vote.index');
    Route::get('/vote/{uuid}','VoteController@voting')->name('vote.voting');
    Route::post('/vote/{uuid}','VoteController@votingSubmit')->name('vote.voting.submit');
  });
});
