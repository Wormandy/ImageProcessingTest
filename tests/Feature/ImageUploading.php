<?php

namespace Tests\Feature;

use App\FileProcessor\FakeFileNameGenerator;
use App\FileProcessor\FileNameGenerator;
use App\Jobs\ConvertImageJob;
use App\Jobs\SliceImageJob;
use App\Jobs\ThumbImageJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploading extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $fakeFileNameGenerator = new FakeFileNameGenerator();
        $this->app->instance(FileNameGenerator::class, $fakeFileNameGenerator);

        Storage::fake('local');
    }

    /** @test     */
    public function userCanUploadImageFile()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson('/', [
            'image' => $file = UploadedFile::fake()->image('testImage1.png', 410, 312)
        ]);
        Storage::disk('local')->assertExists('uploads/'.$file->getClientOriginalName());

        $response->assertStatus(200);
    }

    /** @test */
    public function onceFileUploadedANewJobToSliceCreated()
    {
        Queue::fake();

        $response = $this->postJson('/', [
            'image' => $file = UploadedFile::fake()->image('testImage1.png', 410, 312)
        ]);

        Queue::assertPushedOn('slice', SliceImageJob::class);
    }

    /** @test */
    public function oncePDFuploadedConvertJobRun()
    {
        $this->withoutExceptionHandling();
        Queue::fake();

        $response = $this->postJson('/', [
            'image' => $file = UploadedFile::fake()->create('testPdf.pdf', 20, 'application/pdf')
        ]);

        Queue::assertPushedOn('convert', ConvertImageJob::class);
    }

    /** @test */
    public function uploadedFileGetSliced()
    {
        $this->withoutExceptionHandling();

        Queue::fake();

        SliceImageJob::dispatchNow(base_path('tests/assets/testImage1.png'));

        Queue::assertPushedOn('thumb', ThumbImageJob::class);
    }

}
