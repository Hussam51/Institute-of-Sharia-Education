<?php

namespace App\Notifications;

use App\Models\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUploadFileRequest extends Notification
{
    use Queueable;
   public $teacherName;
   public $title;
    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $teacher = Teacher::find($data['teacher_id']);
        $this->teacherName=$teacher->first_name.' '.$teacher->last_name;
        $this->title = $data['title'];
       // $this->file_url= $data['file_url'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        
        return ['database','broadcast'];

    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
    /*->subject("New File Upload Request #{$this->file->title}")
       // ->from("{{$this->order->address->email}}")
        ->line("a new File Uploaded  by.{{$this->file->title}}.' '.{{$this->file->title}}")
        ->action('view File', route('dashboard.libraries.show'))
        ->line('Thank you for using our application!')
        */;
        
    }



    public function toDatabase(object $notifiable)
    {
        return [
           // 'order_number'=>$this->file->title,
             'title'=>"{{$this->title}}",
            'teacherName'=>"{{$this->teacherName}}",
         //   'url'=> route('dashboard.libraries.index'),
        ];
    }





    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
