<?php

namespace Modules\Bookings\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Entities\User;
use Modules\Teams\Entities\Team;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
    ];
    

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function hasConflict($teamId, Carbon $slotStart, Carbon $slotEnd): bool
{
    return self::where('team_id', $teamId)
        ->where(function ($query) use ($slotStart, $slotEnd) {
            $query->where('start_time', '<', $slotEnd)
                ->where('end_time', '>', $slotStart);
        })
        ->exists();
}
}
