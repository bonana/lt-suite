<?php

namespace Livetime\Models;

use \Illuminate\Database\Eloquent\Model as Model;

class Quote extends Model
{
    public function project()
    {
        return $this->belongsTo('Livetime\Models\Project');
    }
}