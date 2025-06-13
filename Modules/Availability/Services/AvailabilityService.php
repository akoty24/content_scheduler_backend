<?php

namespace Modules\Availability\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Modules\Availability\Entities\TeamAvailability;
use Modules\Bookings\Entities\Booking;
use Modules\Teams\Entities\Team;
use Illuminate\Http\Request;


class AvailabilityService
{
    // service method to store team availability
  public function storeTeamAvailability(Team $team, array $availabilities)
    {
        DB::transaction(function () use ($team, $availabilities) {
            TeamAvailability::where('team_id', $team->id)->delete();

            foreach ($availabilities as $availability) {
                TeamAvailability::create([
                    'team_id' => $team->id,
                    'day_of_week' => $availability['day_of_week'],
                    'start_time' => $availability['start_time'],
                    'end_time' => $availability['end_time'],
                ]);
            }
        });

        return TeamAvailability::where('team_id', $team->id)->get();
    }
  // service method to generate available slots based on team availability and bookings
public function generateSlots(Request $request, $teamId)
{
    $request->validate([
        'from' => 'required|date',
        'to' => 'required|date|after_or_equal:from',
    ]);

    $from = Carbon::parse($request->from)->startOfDay();
$to = Carbon::parse($request->to)->startOfDay()->subSecond();
    $team = Team::where('tenant_id', auth()->user()->tenant_id)->find($teamId);
    
    if (!$team) {
        return response()->json(['message' => 'Team not found'], 404);
    }

    $availabilities = TeamAvailability::where('team_id', $team->id)->get();

    if ($availabilities->isEmpty()) {
        return response()->json(['message' => 'No availability set for this team'], 404);
    }

    $slots = [];
    $conflictedSlots = [];

    foreach (CarbonPeriod::create($from, $to) as $date) {
        $dayOfWeek = $date->format('l');

        $dayAvailability = $availabilities->where('day_of_week', $dayOfWeek);

        foreach ($dayAvailability as $availability) {
            $start = Carbon::parse($date->toDateString() . ' ' . $availability->start_time);
            $end = Carbon::parse($date->toDateString() . ' ' . $availability->end_time);

            while ($start->lt($end)) {
                $slotStart = $start->copy();
                $slotEnd = $start->copy()->addHour();

                if ($slotEnd->gt($end)) {
                    break;
                }

                $conflict = Booking::hasConflict($teamId, $slotStart, $slotEnd);
                // Check for booking conflicts
                $slot = [
                    'date' => $date->toDateString(),
                    'start_time' => $slotStart->format('H:i'),
                    'end_time' => $slotEnd->format('H:i'),
                ];

               if (!$conflict) {
                $slots[] = [
                    'date' => $date->toDateString(),
                    'start_time' => $slotStart->format('H:i'),
                    'end_time' => $slotEnd->format('H:i'),
                ];
            } else {
                $conflictedSlots[] = [
                    'date' => $date->toDateString(),
                    'start_time' => $slotStart->format('H:i'),
                    'end_time' => $slotEnd->format('H:i'),
                ];
            }

                $start->addHour();
            }
        }
    }

    $data = [
        'slots' => $slots,
        'conflictedSlots' => $conflictedSlots,
    ];
    return $data;
}

}
