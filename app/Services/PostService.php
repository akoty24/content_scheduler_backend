<?php

namespace App\Services;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Traits\storeImage;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PostService
{
    use storeImage;

    public function getUserPosts($request)
    {

         $perPage = $request->input('per_page', 10);  
         $page = $request->input('page', 1); 
        $query = Post::with('platforms')->where('user_id', Auth::id());
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('scheduled_time', $request->date);
        }
        $posts = $query->orderBy('scheduled_time', 'desc')->paginate($perPage, ['*'], 'page', $page);
       $stats=[
        'scheduled' => Post::where('user_id', Auth::id())->where('status', PostStatus::SCHEDULED)->count(),
        'published' => Post::where('user_id', Auth::id())->where('status', PostStatus::PUBLISHED)->count(),
        'draft' => Post::where('user_id', Auth::id())->where('status', PostStatus::DRAFT)->count(),
       ];
         return [
            'posts' => $posts,
            'stats' => $stats,
            
            ];  
    }
    public function create(array $data, $user)
    {
        return DB::transaction(function () use ($data, $user) {

            if (isset($data['image_url']) && $data['image_url'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image_url'] = $this->storeImage($data['image_url'], 'images/posts');
            }
             $status = 'draft';
          if (!empty($data['scheduled_time']) && Carbon::parse($data['scheduled_time'])->isFuture()) {
            $scheduledDate = Carbon::parse($data['scheduled_time'])->toDateString();
            $status = 'scheduled';
            $scheduledCount = $user->posts()
                ->whereDate('scheduled_time', $scheduledDate)
                ->count();

            if ($scheduledCount >= 10) {
                throw ValidationException::withMessages([
                    'scheduled_time' => 'You can only schedule up to 10 posts per day.',
                ]);
            }
        }
        

       
   
        $post = $user->posts()->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image_url' => $data['image_url'] ?? null,
            'scheduled_time' => $data['scheduled_time'] ?? null,
            'status' => $status,
        ]);


            $post->platforms()->attach(array_fill_keys($data['platform_ids'], ['platform_status' => 'pending']));

            return $post;
        });
    }


    public function update(Post $post, array $data)
{
    return DB::transaction(function () use ($post, $data) {

        if (isset($data['image_url']) && $data['image_url'] instanceof \Illuminate\Http\UploadedFile) {
            if ($post->image_url) {
                $oldPath = public_path($post->image_url);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $data['image_url'] = $this->storeImage($data['image_url'], 'images/posts');
        }

        $post->update([
            'title' => $data['title'] ?? $post->title,
            'content' => $data['content'] ?? $post->content,
            'image_url' => $data['image_url'] ?? $post->image_url,
            'scheduled_time' => $data['scheduled_time'] ?? $post->scheduled_time,
            'status' => $data['status'] ?? $post->status,
        ]);

        $post->refresh();

        if (!empty($data['platform_ids']) && is_array($data['platform_ids'])) {
            $syncData = [];
            foreach ($data['platform_ids'] as $platformId) {
                $syncData[$platformId] = ['platform_status' => 'pending'];
            }
            $post->platforms()->sync($syncData);
        }

        return $post;
    });
}

    

}