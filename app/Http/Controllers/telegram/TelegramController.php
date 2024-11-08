<?php

namespace App\Http\Controllers\telegram;

use App\Http\Controllers\Controller;
use App\Http\Controllers\database\AdvertisementController;
use App\Http\Controllers\database\ClientController;
use App\Http\Controllers\telegram\Message\SendMessage;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TelegramController extends Controller
{
    public function index(Request $request): void
    {
        $update = $request->input();

        if (isset($update["message"])) {
            $chatId = $update["message"]["chat"]["id"];
            $text = $update["message"]["text"] ?? null;
            $username = $update["message"]["from"]["username"] ?? null;
            $firstname = $update["message"]["from"]["first_name"];
            $add_file_name = $update["message"]["video"]["file_name"] ?? null;
            $add_duration = $update["message"]["video"]["duration"] ?? null;
            $add_size = $update["message"]["video"]["file_size"] ?? null;
            $add = $update["message"]["video"] ?? null;
            $add_id = $update["message"]["video"]["file_id"] ?? null;
            $add_unique_id = $update["message"]["video"]["file_unique_id"] ?? null;
            $callback_data = $update["callback_query"]["data"] ?? null;

            $message = ["chatId" => $chatId,
                "text" => $text, "firstname" => $firstname,
                "add_file_name" => $add_file_name, "add_duration" => $add_duration,
                "add_size" => $add_size, "add" => $add,
                "add_id" => $add_id, "add_unique_id" => $add_unique_id,
                'username' => $username, "callback_data" => $callback_data
            ];

            self::checkRequest($message);
        }
    }
    private static function checkRequest(array $message): void
    {
        $started = Storage::get('ChatId.json', $message["chatId"]) ?? false;

        if ($message["text"] === "/start") {
            if ($started) {
                SendMessage::started($message);
            } else {
                Storage::put('ChatId.json', $message["chatId"], true);
                ClientController::store($message);
                SendMessage::start($message);
            }
        } elseif (isset($message["callback_data"])) {
            Storage::put('CallbackData.json', "{$message["chatId"]} => {$message["callback_data"]}", true);
            SendMessage::sendInformationAdd($message);
        } elseif (isset($message["add"])) {
            AdvertisementController::checkAdd($message);
            AdvertisementController::store($message);
        } else {
            SendMessage::notFound($message);
        }
    }
}
