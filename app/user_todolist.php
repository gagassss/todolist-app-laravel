<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_todolist extends Model
{
  protected $fillable = ['title', 'description', 'status', 'id'];
}
