<?php

namespace Modules\Bookings\Services;

use Modules\Bookings\Entities\Booking;


class BookingService
{
    public function getAllBookings()
    {
        $bookings = Booking::where('user_id', auth()->id())
        ->with('team')
        ->orderByDesc('date')
        ->get();

        return $bookings;
    }
 public function create(array $data)
{
    $teamId = $data['team_id'];
    $date = $data['date'];
    $start = $data['start_time'];
    $end = $data['end_time'];

    $userId = auth()->id();
    if (!$userId) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    $conflict = Booking::where('team_id', $teamId)
        ->where('date', $date)
        ->where(function ($query) use ($start, $end) {
            $query->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time', '>', $start);
            });
        })->exists();

    if ($conflict) {
        return response()->json(['message' => 'Booking conflict detected'], 409);
    }

    $data['user_id'] = $userId;

    return Booking::create($data);
}

}
