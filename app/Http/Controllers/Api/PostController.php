<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

public function index(Request $request) {
    $data = $this->postService->getUserPosts($request);

    return response()->json([
        'message' => 'Posts retrieved successfully',
        'data' => [
            'posts' => PostResource::collection($data['posts']),
            'stats' => $data['stats'],
            'pagination' => [
                'current_page' => $data['posts']->currentPage(),
                'last_page' => $data['posts']->lastPage(),
                'per_page' => $data['posts']->perPage(),
                'total' => $data['posts']->total(),
            ]
        ]
    ]);
}


    public function store(PostRequest $request)
    {
            $post = $this->postService->create($request->validated(), Auth::user());
            if (!$post) {
                return error('Post creation failed', 422);
            }
            $post->load(['platforms']);
            return success(new PostResource($post), 'Post created successfully');
       
    }

    public function update(PostRequest $request,$id)
    {
        $post = Post::find($id);
      
        if (!$post) {
            return error('Post not found', 404);
        }
        if ($post->user_id !== Auth::id()) {
            return error('Unauthorized', 403);
        }
            $post = $this->postService->update($post, $request->validated());

            if (!$post) {
                return error('Post update failed', 422);
            }
            $post->load(['platforms']);
            return success(new PostResource($post), 'Post updated successfully');
       
        
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return error('Post not found', 404);
        }
        if ($post->user_id !== Auth::id()) {
            return error('Unauthorized', 403);
        }
        $post->delete();
        return success(null, 'Post deleted successfully');
    }

    
}
