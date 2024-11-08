<?php

namespace App\Http\Controllers\telegram\Message;

use App\Http\Controllers\telegram\Replies\Replies;
use App\Models\Definition;

class SendMessage
{
    const TOKEN = "7863946063:AAF15euYwfVOqp8TrCrHPWpiA0T8DvWPlTo";
    const URL = "https://api.telegram.org/bot".self::TOKEN."/";

    public static function start(array $message): void
    {
        $url = self::URL . "sendMessage";

        $firstname = htmlspecialchars($message["firstname"], ENT_QUOTES);

        $welcome = [
            'chat_id' => $message["chatId"],
            'text' => Replies::start(['firstname' => $firstname]),
            'parse_mode' => 'html'
        ];

        file_get_contents($url . '?' . http_build_query($welcome));

        $definitions = Definition::all();

        $definitionsList = [];

        foreach ($definitions as $definition) {
            $definitionsList[] =
                [
                    [
                        'text' => "{$definition->name}: {$definition->view_count}{$definition->duration_days} - {$definition->price} so`m",
                        'callback_data' => "{$definition->id}"
                    ]
                ];
        }

        $replyMarkup = json_encode([
            'inline_keyboard' => $definitionsList
        ]);

        $aboutDefinitions = [
            'chat_id' => $message["chatId"],
            'text' => Replies::informationAboutDefinitions($message),
            'parse_mode' => 'html',
            'reply_markup' => $replyMarkup
        ];

        file_get_contents($url . '?' . http_build_query($aboutDefinitions));
    }
    public static function checkText(array $message): void
    {
        $pattern = "/\+998\s*\(\d{2}\)\s*\d{3}\s*\d{2}\s*\d{2}/";
        $text = $message["text"];
        if (!preg_match($pattern, $text, $matches)) {
            $errors[] = "Telefon raqam kiritilmadi!
To`g`ri format {<code>+998 (**) *** ****</code>}";
        }
    }

    public static function started(array $message): void
    {
        $url = self::URL . "sendMessage";

        $data = [
            'chat_id' => $message["chatId"],
            'text' => Replies::started($message),
            'parse_mode' => 'html'
        ];

        file_get_contents($url . '?' . http_build_query($data));
    }

    public static function sendAddInfo(array $add): void
    {
        $url = self::URL . "sendMessage";

        if (!empty($add["true"])) {
            $errorMessage = implode("\n", $add["messages"]);
            $data = [
                'chat_id' => $add["chat_id"],
                'text' => $errorMessage,
                'parse_mode' => 'html',
            ];
        } else {
            $data = [
                "chat_id" => $add["chat_id"],
                'text' => "<b>Video muvaffaqiyatli yuklandi</b> ✅\n\n" .
                    "Video URL: " . $add["video_url"] . "\n" .
                    "Video ID: " . $add["video_id"],
                'parse_mode' => 'html',
            ];
        }

        file_get_contents($url . '?' . http_build_query($data));
    }

    public static function sendInformationAdd(array $message): void
    {
        $url = self::URL . "sendMessage";

        $data = [
            'chat_id' => $message["chatId"],
            'text' => Replies::informationAboutAdvertising(),
            'parse_mode' => 'html',
        ];

        file_get_contents($url . '?' . http_build_query($data));
    }
    public static function notFound(array $message): void
    {
        $url = self::URL . "sendMessage";

        $data = [
            'chat_id' => $message["chatId"],
            'text' => Replies::notFound(),
            'parse_mode' => 'html'
        ];

        file_get_contents($url . '?' . http_build_query($data));
    }
}
