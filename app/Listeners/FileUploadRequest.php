<?php

namespace App\Listeners;

use App\Events\NewFileUploadRequest;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FileUploadRequest
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewFileUploadRequest $event): void
    {
        $admin=User::where('');
    }
}
