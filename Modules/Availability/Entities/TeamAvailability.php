<?php

namespace Modules\Availability\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Teams\Entities\Team;

class TeamAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }
}
