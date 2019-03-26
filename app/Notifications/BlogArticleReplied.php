<?php

namespace App\Notifications;

use App\Models\BlogReply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BlogArticleReplied extends Notification
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(BlogReply $reply)
    {
        // 注入回复实体，方便 toDatabase 方法中的使用
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // 开启通知的频道
        // return ['mail'];
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $article = $this->reply->article;
        $link =  $article->link(['#reply' . $this->reply->id]);

        // 存入数据库里的数据
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'article_link' => $link,
            'article_id' => $article->id,
            'article_title' => $article->title,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
