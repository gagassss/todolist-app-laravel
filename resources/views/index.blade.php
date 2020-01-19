@extends('layout/main')
@section('title', 'My Todolist')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col s12">
        <p>My Todolist</p>
        <button data-target="modal1" class="btn modal-trigger blue darken-2">Add New</button>
      </div>

      <div class="col s4">
        <ul class="collection with-header">
          <li class="collection-header orange darken-2 white-text "><h4>To Do</h4></li>
          <div class="todo"></div>
        </ul>
      </div>

      <div class="col s4">
        <ul class="collection with-header">
          <li class="collection-header blue darken-2 white-text"><h4>Doing</h4></li>
          <div class="doing"></div>
        </ul>
      </div>

      <div class="col s4">
        <ul class="collection with-header">
          <li class="collection-header green darken-2 white-text"><h4>Done</h4></li>
          <div class="done"></div>
        </ul>
      </div>
    </div>
  </div>

<!-- Modal Structure -->
<div id="modal1" class="add-new modal">
  <div class="modal-content">
    <h4>Add New Todolist</h4>
    @csrf
    <div class="row">
      <div class="input-field col s6">
        <i class="material-icons prefix">create</i>
        <input id="title" name="title" type="text" class="validate title" autocomplete="off">
        <label for="title">Title</label>
        <span class="helper-text errorTitleField red-text  darken-2"></span>
      </div>
      <div class="input-field col s6">
        <i class="material-icons prefix">description</i>
        <input id="description" type="text" name="description" autocomplete="off" class="validate description">
        <label for="description">Description</label>
        <span class="helper-text red-text darken-2 errorDescField"></span>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn blue darken-2 submit-button">Add</button>
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">cancel</a>
  </div>
</div>

<!-- detail modal -->
<div id="detail" class="modal detail-modal">
  <div class="modal-content">
    <h4>Title : <span id="titleInModal"></span></h4>
    <p>Task Description : <span id="descInModal"></span></p>
    <p>Task Created At : <span id="createdAt"></span></p>
  </div>
  <div class="modal-footer ">
    <div class="buttonOnModalDetail"></div>
    <!-- <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a> -->
  </div>
</div>

@endsection