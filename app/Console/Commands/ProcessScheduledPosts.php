<?php
namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use App\Jobs\ScheduledPostPublisher;

class ProcessScheduledPosts extends Command
{
    protected $signature = 'posts:process-scheduled';
    protected $description = 'Dispatch job to publish scheduled posts';

    public function handle()
    {
    
        $duePosts = Post::where('status', 'scheduled')
        ->where('scheduled_time', '<=', now())
        ->with('platforms')
        ->get();

    foreach ($duePosts as $post) {
            \Log::info("Running PublishSinglePost for post ID: {$post->id}");

        ScheduledPostPublisher::dispatch($post);
    }

    $this->info('Scheduled posts dispatched.');
    
    }
}
