<?php

namespace Modules\Bookings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Bookings\Entities\Booking;
use Modules\Bookings\Http\Requests\BookingRequest;
use Modules\Bookings\Http\Resources\BookingsResource;
use Modules\Bookings\Services\BookingService;

class BookingsController extends Controller
{
      public function __construct(private BookingService $bookingService) {}

      public function index()
        {
                $bookings = $this->bookingService->getAllBookings();
                if ($bookings instanceof \Illuminate\Http\JsonResponse) {
                        return $bookings;
                }

                return response()->json(['message' => 'Bookings retrieved successfully','bookings' => BookingsResource::collection($bookings)], 200);
        }

      public function store(BookingRequest $request)
        {
        
                $booking = $this->bookingService->create($request->validated());
                if ($booking instanceof \Illuminate\Http\JsonResponse) {
                    return $booking; 
                }

                return response()->json(
                    ['message' => 'Booking created successfully', 'booking' => BookingsResource::make($booking)],
                    201
                );
            
        }

        public function destroy($id)
        {
                $booking = Booking::find($id);
                if (!$booking) {
                   return response()->json(['message' => 'Booking not found'], 404);
                }
                 $booking->delete();
                return response()->json(['message' => 'Booking canceled successfully'], 200);
        }
}
