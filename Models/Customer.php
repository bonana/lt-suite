<?php

namespace Livetime\Models;

use \Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function contacts()
    {
        return $this->hasMany('Livetime\Models\CustomerContact');
    }

    public function projects()
    {
        return $this->hasMany('Livetime\Models\Project');
    }
}