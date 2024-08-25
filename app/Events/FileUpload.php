<?php

namespace App\Events;

use App\Models\Teacher;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;





class FileUpload implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $title;
    public $teacherName;
    public $file_url;

    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
       $teacher = Teacher::find($data['teacher_id']);
        $this->teacherName=$teacher->first_name.' '.$teacher->last_name;
        $this->title = $data['title'];
       // $this->file_url= $data['file_url'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['file-upload'];
    }
}
