<?php

namespace Modules\Teams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Teams\Database\Factories\TeamFactory;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'owner_id',
        'plans_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected static function newFactory(): TeamFactory
    {
        //return TeamFactory::new();
    }
}
