<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request, ChatbotService $bot): JsonResponse
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:500']]);

        return response()->json($bot->reply($data['message']));
    }
}