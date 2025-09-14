<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Http\JsonResponse;

class KeywordController extends Controller
{
    public function index(): JsonResponse
    {
        $keywords = Keyword::all();
        return response()->json($keywords);
    }

    public function store(): JsonResponse
    {
        $request = request();
        $keyword = Keyword::firstOrCreate(['name' => $request->input('name')]);

        return response()->json($keyword, 201);
    }
}