<?php

namespace Livetime\Models;

use \Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    public function customer()
    {
        return $this->belongsTo('Livetime\Models\Customer');
    }
}