<?php

namespace Modules\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Models\User;


class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teams_id',
    ];

    public function team()
    {
        return $this->belongsTo('Modules\Team\Entities\Team');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_has_users');
    }
}
