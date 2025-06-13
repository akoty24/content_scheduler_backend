<?php

namespace Modules\Tenants\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Tenants\Http\Resources\TenantsResource;

class TenantsController extends Controller
{
  
    public function currentTenant()
    {
        $tenant = auth()->user()->tenant;

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        return response()->json([
            'message' => 'Tenant retrieved successfully',
            'tenant' =>  TenantsResource::make($tenant),
        ], 200);
    }
}
