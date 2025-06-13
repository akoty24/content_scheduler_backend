<?php

namespace Modules\Teams\Services;



class TeamService
{
    public function getAllTeams()
    {
        $teams = auth()->user()->tenant->teams()
            ->orderBy('name')
            ->get();
        return $teams;
         
    }

    public function create( array $data)
    {
        $team = auth()->user()->tenant->teams()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_by' => auth()->user()->id,
        ]);
        return $team;
       
    }


    public function setAvailability($teamId, $available)
    {
        $team = auth()->user()->tenant->teams()->find($teamId);
        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        $team->available = $available;
        $team->save();

        return $team;
    }

}