<?php

namespace App\Http\Controllers;

use App\Services\StoreAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreAssistantController extends Controller
{
    public function ask(Request $request, StoreAssistantService $assistant): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:500'],
        ]);

        return response()->json($assistant->answer(trim($data['message'])));
    }
}
