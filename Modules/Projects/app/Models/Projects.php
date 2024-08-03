<?php

namespace Modules\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Projects\Database\Factories\ProjectsFactory;

class Projects extends Model
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
}
