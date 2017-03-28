<?php

namespace Livetime\Models;

use \Illuminate\Database\Eloquent\Model as Model;

class Status extends Model
{
    protected $table = 'status';

    public function projects()
    {
        return $this->hasMany('Livetime\Models\Project');
    }
}