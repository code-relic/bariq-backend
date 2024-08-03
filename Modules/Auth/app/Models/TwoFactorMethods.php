<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Database\Factories\TwoFactorMethodsFactory;

class TwoFactorMethods extends Model
{
    use HasFactory;
    protected $table="2fa_methods";
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["name"];

    
}
