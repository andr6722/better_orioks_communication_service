<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use RuntimeException;

class PushNotificationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/notifications",
     *     tags={"notifications"},
     *     summary="Send a push notifications",
     *     @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id", type="string", example="123"),
     *              @OA\Property(property="subject_name", type="string", example="abcd1234"),
     *              @OA\Property(property="control_event_name", type="string", example="sadf3423"),
     *              @OA\Property(property="current_score", type="string", example="_"),
     *              @OA\Property(property="new_score", type="string", example="5")
     *          )
     *      ),
     *     @OA\Response(response="302", description="Displays a push notifications about rating changes")
     * )
     */
    public function sendNotification(Request $request): \Illuminate\Http\JsonResponse
    {

        $json = $request -> json()->all();
        $token = $json['user_id'];
        $body = "Предмет: {$json['subject_name']}, КМ {$json['control_event_name']}. Оценка изменена с {$json['current_score']}, на {$json['new_score']}";
        Log::channel('notificationlog') -> debug($body);
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
    /**
     * @OA\Post(
     *     path="/api/v1/news",
     *     tags={"News"},
     *     summary="Send a push notifications",
     *     @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id", type="string", example="123"),
     *              @OA\Property(property="NewsName", type="string", example="abcd1234"),
     *              @OA\Property(property="link", type="string", example="sadf3423")
     *          )
     *      ),
     *     @OA\Response(response="302", description="Displays a push notifications about rating changes")
     * )
     */
    public function sendNews(Request $request): \Illuminate\Http\JsonResponse{
        $json = $request -> json()->all();
        $token = $json['user_id'];
        Log::channel('notificationlog') -> debug($json);
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
