<?php

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

use App\user_todolist;
use Illuminate\Http\Request;

Route::get('/', 'Main@index');

Route::get('getData', function () {
  $todolist = user_todolist::all();
  return response()->json($todolist);
});

Route::post('/', 'Main@store');

Route::get('/changeTaskStatus/{id}/{status}/{type}', function (Request $request, $id, $status, $type) {

  if ($type == 'doing' || $type == 'done') {
    $status += 1;
  } if ($type == 'todo') {
    $status -= 1;
  } if ($type == 'done to doing') {
    $status -= 1;
  }

  user_todolist::where('id', $id)
  ->update([
    'status' => $status
  ]);
  
  return $status;
});

Route::get('/deleteTask/{id}', function (Request $request, $id) {
  user_todolist::where('id', $id)->delete();
  return $id;
});