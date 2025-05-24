<?php
namespace App\Services;

use App\Models\Platform;
use Illuminate\Support\Facades\Auth;

class PlatformService
{
    // List all available platforms
    public function listAll($request)
    {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);
        $query = Platform::query();
        return $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }

    // Get active platforms for the logged-in user
    public function getUserActivePlatforms()
    {
        return Auth::user()->platforms()->get();
    }

    // Toggle platform active status for the user
    public function toggleUserPlatform(int $platformId): bool
    {
        $user = Auth::user();

        if ($user->platforms()->where('platform_id', $platformId)->exists()) {
            $user->platforms()->detach($platformId);
            return false;
        } else {
            $user->platforms()->attach($platformId);
            return true;
        }
    }
}
