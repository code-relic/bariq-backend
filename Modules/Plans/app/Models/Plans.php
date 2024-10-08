<?php

namespace Modules\Plans\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plans extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'price'
    ];

    protected static function newFactory()
    {
        //return PlansFactory::new();
    }
}
