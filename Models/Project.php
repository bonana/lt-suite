<?php

namespace Livetime\Models;

use \Illuminate\Database\Eloquent\Model as Model;

class Project extends Model
{
    public function customer()
    {
        return $this->belongsTo('Livetime\Models\Customer');
    }

    public function products()
    {
        return $this->hasMany('Livetime\Models\ProjectProduct');
    }

    public function quotes()
    {
        return $this->hasMany('Livetime\Models\Quote');
    }

    public function invoices()
    {
        return $this->hasMany('Livetime\Models\Invoice');
    }

    public function theme()
    {
        return $this->belongsTo('Livetime\Models\Theme');
    }

    public function signatures()
    {
        return $this->hasMany('Livetime\Models\Signature');
    }

    public function status()
    {
        return $this->belongsTo('Livetime\Models\Status');
    }
}