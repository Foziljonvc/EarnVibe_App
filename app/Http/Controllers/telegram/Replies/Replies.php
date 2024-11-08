<?php

declare(strict_types=1);
namespace App\Http\Controllers\telegram\Replies;
class Replies
{
    public static function start(array $replies): string
    {
        return "
    Assalomu aleykum, <b><code>{$replies['firstname']}</code>!</b>
<a href=''><b>EarnVibe</b></a> Appning Botiga xush kelibsiz!
    ";
    }

    public static function informationAboutDefinitions(array $replies): string
    {
        return "
    <b>Tariflardan birini tanlang ✅</b>
        ";
    }

    public static function started(array $replies): string
    {
        return "
    <b>Siz bot ishga tushirdingiz !</b>

<b>Tariflardan birini tanlang !</b>
        ";
    }
    public static function informationAboutAdvertising(): string
    {
        return "
    <i><b>❗Diqqat:</b> Barcha shartlarga asoslanib ma'lumotlarni to'ldiring!</i>

    <b>Video:</b> <i>mp4 formatida</i>

    <b>Davomiyligi: <i>3 sekunddan baland</i></b>
    <i>• 15 sekund</i>
    <i>• 30 sekund</i>
    <i>• 60 sekund</i>
    <i>• 120 sekund</i>

    <b>Hajmi:</b> <i>maximum 100 MB</i>

    <b>Matn:</b> <i>Reklama matni</i>

    <b>Tavsif:</b> <i>Reklama tavsifi</i>

    <b>Manzil:</b> <i>Agar mavjud bo'lsa, reklama qilingan joyning manzili</i>

    <b>Aloqa:</b> <i>Userlar bog'lanishi uchun telefon raqami</i>

    <b>Email:</b> <i>Userlar bog'lanishi uchun email</i>

    <b>⚠️ Majburiy maydonlar:</b>
    <i>Video, Hajmi, Matn va Aloqa.</i>

    <b>✅ Majburiy emas maydonlar:</b>
    <i>Tavsif va Manzil.</i>
";
    }

//    public static function checkFirstAdd(array $replies): string
//    {
//        return ;
//    }
    public static function notFound(): string
    {
        return "
    <i>Bunday ma'lumot topilmadi !.</i>
        ";
    }
}
