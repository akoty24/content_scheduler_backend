<?php

namespace Modules\Availability\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Availability\Entities\TeamAvailability;
use Modules\Availability\Http\Requests\AvailabilityRequest;
use Modules\Availability\Http\Resources\AvailabilityResource;
use Modules\Availability\Services\AvailabilityService;
use Modules\Bookings\Entities\Booking;
use Modules\Bookings\Http\Resources\BookingsResource;
use Modules\Teams\Entities\Team;
use Carbon\CarbonPeriod;
class AvailabilityController extends Controller
{
        public function __construct(private AvailabilityService $availabilityService) {}

   public function store( AvailabilityRequest $request, $id)
        {    
            $team = Team::where('tenant_id', auth()->user()->tenant_id)->find($id);
            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            $validated = $request->validated();

            $availabilities = $this->availabilityService->storeTeamAvailability($team, $validated['availabilities']);

            return response()->json([
                'message' => 'Availability set successfully',
                'availabilities' => AvailabilityResource::collection($availabilities),
            ], 200);
        }
        
        public function generateSlots(Request $request, $teamId)
        {
            $request->validate([
                'from' => 'required|date',
                'to' => 'required|date|after_or_equal:from',
            ]);

            $team = Team::where('tenant_id', auth()->user()->tenant_id)->find($teamId);

            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            $data = $this->availabilityService->generateSlots( $request, $teamId);

            return response()->json([
                'message' => 'Available slots generated successfully',
                'data' => $data
            ]);
        }
}
