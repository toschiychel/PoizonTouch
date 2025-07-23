<?php

namespace App\Http\Controllers\Api\Telegram\QRCode;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminPanel\Telegram\QrCode\QrCodeServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function __construct(
        protected QrCodeServiceInterface $qr
    ) {}

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $imageData = $this->qr->generateFor($user);

        return response()->json([
            'qr'  => 'data:image/png;base64,' . base64_encode($imageData),
        ]);
    }
}
