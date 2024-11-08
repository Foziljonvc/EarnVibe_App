<?php

namespace App\Http\Controllers\database;

use App\Http\Controllers\Controller;
use App\Http\Controllers\telegram\Message\SendMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Laravel\Prompts\search;

class AdvertisementController extends Controller
{
    const TOKEN = "7863946063:AAF15euYwfVOqp8TrCrHPWpiA0T8DvWPlTo";
    const URL = "https://api.telegram.org/bot".self::TOKEN."/";

    public static function checkAdd(array $message): void
    {
        $errors = [];

        try {
            if (strtolower(pathinfo($message["add_file_name"], PATHINFO_EXTENSION)) !== "mp4") {
                $errors[] = "<b>Reklama formati to'g'ri kelmadi! 📹</b>" . "\n\n" . "<b>To`g`ri format <code>Mp4</code></b>";
            }

            $duration = (int)$message["add_duration"];
            if ($duration < 5) {
                $errors[] = "\n<b>Davomiyligi 5 sekundan tepa bo`lishini taminlang! ➕</b>";
            } elseif ($duration > 120) {
                $errors[] = "\n<b>Davomiyligi 120 sekundan kam bo`lishini taminlang! ➖</b>";
            }

            $sizeMB = (int)$message["add_size"] / (1024 * 1024);
            if ($sizeMB > 100) {
                $errors[] = "\n<b>Reklama formati 100 MB dan kam bo`lishini taminlang! 🔄</b>";
            }

            if (empty($errors)) {
                $fileData = self::getFile($message["add_id"]);
                $videoContent = file_get_contents($fileData['file_url']);

                $fileName = $message["add_unique_id"] . '.mp4';
                $filePath = 'public/videos/' . $fileName;

                Storage::put($filePath, $videoContent);

                $videoUrl = Storage::url($filePath);

                $message += ['videoUrl' => $videoUrl, 'duration' => $duration];

                $videoId = self::store($message);

                SendMessage::sendAddInfo([
                    "true" => false,
                    "chat_id" => $message["chatId"],
                    "video_url" => $videoUrl,
                    "video_id" => $videoId
                ]);
            } else {
                SendMessage::sendAddInfo([
                    "true" => true,
                    "chat_id" => $message["chatId"],
                    "messages" => $errors
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Video processing error: ' . $e->getMessage());
            SendMessage::sendAddInfo([
                "true" => true,
                "chat_id" => $message["chatId"],
                "messages" => ["Tizimda xatolik yuz berdi. Iltimos qaytadan urinib ko'ring."]
            ]);
        }
    }

    private static function getFile($fileId): array
    {
        $response = file_get_contents("https://api.telegram.org/bot" . self::TOKEN . "/getFile?file_id={$fileId}");
        $fileData = json_decode($response, true);

        return [
            'file_path' => $fileData['result']['file_path'],
            'file_url' => "https://api.telegram.org/file/bot" . self::TOKEN . "/" . $fileData['result']['file_path']
        ];
    }

    public static function store(array $message): int
    {

    }
}
