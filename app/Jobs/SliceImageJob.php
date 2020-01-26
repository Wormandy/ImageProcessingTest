<?php

namespace App\Jobs;

use App\FileProcessor\ImageSlicer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SliceImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imageSlicer = new ImageSlicer($this->filename);
        $images = $imageSlicer->slice();
        foreach ($images as $image){
            ThumbImageJob::dispatch($image)->onQueue('thumb');
        }
    }
}
