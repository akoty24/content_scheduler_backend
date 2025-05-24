<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformResource;
use App\Http\Resources\PostResource;
use App\Models\Platform;
use App\Services\PlatformService;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function __construct(private PlatformService $platformService)
    {
    }

    public function index(Request $request)
    {
        $platforms = $this->platformService->listAll($request);
        $data=[
            'platforms' => PlatformResource::collection($platforms),
            'pagination' => [
                'current_page' => $platforms->currentPage(),
                'last_page' => $platforms->lastPage(),
                'per_page' => $platforms->perPage(),
                'total' => $platforms->total(),
            ]
        ];
        return success(
            $data, 'Platforms retrieved successfully');
    }

    public function show(Platform $platform)
    {
        
        return success([
            'platform' => new PlatformResource($platform),
        ], 'Platform retrieved successfully');
    }

    public function userPlatforms()
    {
        $platforms = $this->platformService->getUserActivePlatforms();
        return success([
            'platforms' => PlatformResource::collection($platforms),
        ], 'User platforms retrieved successfully');
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'platform_id' => 'required|exists:platforms,id',
        ]);


        $activated = $this->platformService->toggleUserPlatform($request->platform_id);

        return success(['activated' => $activated]);
    }

public function userPosts(Platform $platform, Request $request)
{
    $user = $request->user() ?? auth()->user();
    $perPage = $request->input(key: 'perPage');
    $search = $request->input('search');
    $sortKey = $request->input('sort', 'title');
    $sortOrder = $request->input('order', 'asc');

    $query = $platform->posts()
        ->where('user_id', $user->id)
        ->with('platforms');

    // فلترة حسب البحث
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('content', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%");
        });
    }

    // الترتيب
    $query->orderBy($sortKey, $sortOrder);
    // pagination
    $posts = $query->paginate($perPage);

    return success([
        'posts' => PostResource::collection($posts),
        'pagination' => [
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
        ]
    ], 'Posts retrieved successfully'); 
  
}

    
}
