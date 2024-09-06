<?php

namespace Modules\Projects\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Models\Project;
use Modules\Teams\Models\Team;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Lists extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'lists';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'projects_id',
        'projects_teams_id',
        'views_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'projects_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'projects_teams_id');
    }

    // public function view()
    // {
    //     return $this->belongsTo(View::class, 'views_id');
    // }
}
