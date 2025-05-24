<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ScheduledPostPublisher;

class ProcessScheduledPosts extends Command
{
    protected $signature = 'posts:process-scheduled';
    protected $description = 'Dispatch job to publish scheduled posts';

    public function handle()
    {
        ScheduledPostPublisher::dispatch();

        $this->info('ScheduledPostPublisher job dispatched.');
    }
}
