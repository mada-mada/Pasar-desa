<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreUlasanRequest;
use App\Models\Ulasan;
use Illuminate\Http\JsonResponse;

class UlasanController extends Controller
{
    public function store(StoreUlasanRequest $request): JsonResponse
    {
        $ulasan = Ulasan::create(array_merge(
            $request->validated(),
            ['is_approved' => false]
        ));

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil dikirim dan sedang menunggu konfirmasi.',
        ]);
    }
}
