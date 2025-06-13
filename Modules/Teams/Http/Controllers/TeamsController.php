<?php

namespace Modules\Teams\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Teams\Http\Resources\TeamsResource;
use Modules\Teams\Services\TeamService;
use Modules\Teams\Http\Requests\TeamRequest;

class TeamsController extends Controller
{   public function __construct(private TeamService $teamService) {}

    public function index()
    {
        return response()->json([
            'message' => 'Teams retrieved successfully',
            'teams' => TeamsResource::collection($this->teamService->getAllTeams()),
        ], 200);
    }

    public function store(TeamRequest $request)
    {
        $team = $this->teamService->create($request->validated());
        if ($team instanceof \Illuminate\Http\JsonResponse) {
            return $team;
        }
        return response()->json([
            'message' => 'Team created successfully',
            'team' => TeamsResource::make($team),
        ], 201);
  
    }


}
