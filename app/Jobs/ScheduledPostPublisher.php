<?php

namespace App\Jobs;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduledPostPublisher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }


    public function handle()
    {
        $duePosts = Post::where('status', 'scheduled')
            ->where('scheduled_time', '<=', Carbon::now())
            ->with('platforms')
            ->get();
    
        foreach ($duePosts as $post) {
            $allPublished = true; // track if all platforms succeed
    
            foreach ($post->platforms as $platform) {
                $rules = $this->platformRules[$platform->type] ?? null;
    
                $contentLength = strlen($post->content);
    
                if ($rules && $contentLength > $rules['max_length']) {
                    // Fail platform due to exceeding character limit
                    $post->platforms()->updateExistingPivot($platform->id, [
                        'platform_status' => 'failed',
                        //'platform_error' => 'Content exceeds max character limit'
                    ]);
                    $allPublished = false;
                    continue; // skip publishing for this platform
                }
    
                // Mock publishing success
                $post->platforms()->updateExistingPivot($platform->id, [
                    'platform_status' => 'published'
                ]);
            }
    
            if ($allPublished) {
                $post->update(['status' => 'published']);
            }
        }
    }
    
}
