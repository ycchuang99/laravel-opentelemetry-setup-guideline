<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Hello World!',
        ]);
    }
}
