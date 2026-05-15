<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
        if (empty($reply->content)) {
            return false;
        }
    }

    public function updating(Reply $reply)
    {
        //
    }

    /**
     * 回复创建后，增加话题回复数
     */
    public function created(Reply $reply)
    {
        // 第一种 直接增加回复数
        // $reply->topic->increment('reply_count');

        // 第二种 重新查询回复数
        $reply->topic->reply_count = $reply->topic->replies()->count();
        $reply->topic->save();

        // 发送通知
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    /**
     * 回复删除后，减少话题回复数
     */
    public function deleted(Reply $reply)
    {
        $reply->topic->reply_count = $reply->topic->replies()->count();
        $reply->topic->save();
    }
}