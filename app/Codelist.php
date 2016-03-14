<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codelist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number'];

    /**
     * Get the Codes for the Codelist.
     */
    public function codes()
    {
        return $this->hasMany('App\Code');
    }
}
