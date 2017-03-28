<?php

namespace Livetime\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Theme extends Model
{
    public function projects()
    {
        return $this->hasMany('Livetime\Models\Project');
    }
}