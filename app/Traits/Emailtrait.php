<?php
namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait Emailtrait
{
    public function emailnoti($data){
        $details = [
            'email' =>$data['email'],
            'subject' =>$data['subject'],
            'name' =>$data['name'],
            'content'=>$data['content'],
            'link'=>isset($data['link'])?$data['link']:Null,
            'id'=>$data['id']
        ];
        Mail::send('email', $details, function ($message) use ($details) {
            $message->from('cincin.com@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
        });
    }
}
