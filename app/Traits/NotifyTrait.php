<?php

namespace App\Traits;

use App\Models\Notification;
use Illuminate\Support\Str;

trait NotifyTrait
{
    public function addnotify($notify_user, $type, $message, $url, $notifier)
    {
        $data = [
            'uuid' => Str::uuid(),
            'type' => $type,
            'target_url' => $url,
            'notify_user_id' => $notify_user,
            'message' => $message,
            'notifier_id' => $notifier ?? null,
        ];
        Notification::create($data);
    }
}
