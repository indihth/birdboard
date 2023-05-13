<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];


    // Returns project path
    public function path()
    {
        return "/projects/{$this->id}";
    }
}
