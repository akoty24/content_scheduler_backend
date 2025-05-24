<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\Platform;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return error('Unauthorized', 401);
        } 
        $user->load(['posts', 'platforms']);
            $stats = [
                'scheduled' => Post::where('user_id', $user->id)->where('status', 'scheduled')->count(),
                'published' => Post::where('user_id', $user->id)->where('status', 'published')->count(),
                'draft' => Post::where('user_id', $user->id)->where('status', 'draft')->count(),
            ];
                $platforms = Platform::all();      
                $recentPosts = Post::where('user_id', $user->id)->latest()->take(5)->get();
        return success([
            'user' => new UsersResource($user),
            'stats' => $stats,
            'platforms' => $platforms,
            'recentPosts' => $recentPosts,
        ]);
    }
}
