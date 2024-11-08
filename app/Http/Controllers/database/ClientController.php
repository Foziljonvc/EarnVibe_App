<?php

namespace App\Http\Controllers\database;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public static function store(array $client): void
    {
        Client::query()->create([
            'chat_id' => $client['chatId'],
            'username' => $client['username'] ?? null,
            'full_name' => $client['firstname'],
            'phone' => $client['phone'] ?? null,
        ]);
    }
}
