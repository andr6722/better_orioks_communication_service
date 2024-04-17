<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use RuntimeException;

class PushNotificationController extends Controller
{
    public function sendNotification(Request $request): \Illuminate\Http\JsonResponse
    {

        $json = $request -> json()->all();
        $token = $json['user_id'];
        $body = "Предмет: {$json['subject_name']}, КМ {$json['control_event_name']}. Оценка изменена с {$json['current_score']}, на {$json['new_score']}";
        try{
            $messaging = Firebase::messaging();
            $notification_push = Notification::fromArray([
                'title' => 'Изменение оценки',
                'body' => $body
            ]);

            $message = CloudMessage::withTarget('user_id', $token)->withNotification($notification_push);

            $messaging->send($message);
            return response()->json(["success" =>true]);
        } catch(RuntimeException $e) {
            return response()->json($body);
        }
    }
    public function sendNews(Request $request): \Illuminate\Http\JsonResponse{
        $json = $request -> json()->all();
        $token = $json['user_id'];
        try{
            $messaging = Firebase::messaging();
            $title = 'News';
            $body = $json['NewsName'];
            $clickAction = $json['link'];

            $notification_push = Notification::create($title, $body );

            $message = CloudMessage::withTarget('user_id', $token)->withNotification($notification_push);

            $messaging->send($message);
            return response()->json(["success" =>true]);
        }catch(RuntimeException $e){
            return response()->json($json['NewsName']);
        }
    }
}
