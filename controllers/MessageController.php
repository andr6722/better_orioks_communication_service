<?php

namespace controllers;

use models\Message;

class MessageController
{
    public function sendMessage($sender, $recipient, $message)
    {
        // Создание экземпляра модели сообщения
        $messageModel = new Message();

        // Установка свойств сообщения
        $messageModel->sender_id = $sender->id;
        $messageModel->recipient_id = $recipient->id;
        $messageModel->message = $message;
        $messageModel->timestamp = date('Y-m-d H:i:s');

        // Сохранение сообщения в базе данных
        $messageModel->save();

        // Вернуть успешный ответ
        return [
            'success' => true,
            'message' => 'Сообщение успешно отправлено.'
        ];
    }
    public function getMessage($user)
    {
        // logic to retrieve message for a user

        // Получение всех сообщений, адресованных пользователю
        $messages = Message::where('recipient_id', $user->id)->get();

        // Форматирование сообщений перед отправкой
        $formattedMessages = [];
        foreach ($messages as $message) {
            $formattedMessages[] = [
                'id' => $message->id,
                'sender' => User::find($message->sender_id)->username,
                'message' => $message->message,
                'timestamp' => $message->timestamp
            ];
        }

        // Возвращение списка сообщений
        return $formattedMessages;
    }
}