<?php

namespace Modules\Payments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Payments\Database\Factories\PaymentsFactory;
use Modules\Plans\Models\Plans;
use Modules\Users\Models\User;
use Modules\Teams\Models\Team;

class Payments extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "amount",
        "status",
        "plans_id"
    ];

    // Define the relationship to the User model
    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    // Define the relationship to the Team model
    public function team()
    {
        return $this->belongsTo(Team::class, 'teams_id');
    }

    public function plan() {
        return $this->belongsTo(Plans::class, 'plans_id');

    }

    protected static function newFactory()
    {
        //return PaymentsFactory::new();
    }
}
