<?php

namespace Modules\Projects\Models;

use Modules\Teams\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Tasks extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'tasks';

    protected $primaryKey = 'id';

    public $incrementing = false; // Since ULIDs are non-incrementing

    protected $keyType = 'string'; // ULIDs are stored as strings

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'projects_id',
        'projects_teams_id',
        'assets',
        'docs',
        'lists_id',
    ];

    protected $casts = [
        'assets' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
    public function projects()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }

    public function projectsTeams()
    {
        return $this->belongsTo(Team::class, 'projects_teams_id');
    }

    // public function lists()
    // {
    //     return $this->belongsTo(Lists::class, 'lists_id');
    // }
}
