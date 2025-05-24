<?php
namespace App\Services;

use App\Models\Platform;
use Illuminate\Support\Facades\Auth;

class PlatformService
{
    public function listAll($request)
    {
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);
        $query = Platform::query();
        return $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }

    public function getUserActivePlatforms()
    {
        return Auth::user()->platforms()->get();
    }

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

    public function getUserPostsByPlatform($platform, $request)
    {
            if (!$platform) {
                return error('Platform not found', 404);
            }

            
        $user =  auth()->user();
        $perPage = $request->input(key: 'perPage');
        $search = $request->input('search');
        $sortKey = $request->input('sort', 'title');
        $sortOrder = $request->input('order', 'asc');

        $query = $platform->posts()
            ->where('user_id', $user->id)
            ->with('platforms');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%");
            });
        }

        $query->orderBy($sortKey, $sortOrder);
        $posts = $query->paginate($perPage);
      return $posts;
    }
}
