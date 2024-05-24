<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use chillerlan\QRCode\{QRCode, QROptions};

class QrController extends Controller
{
    public function showScanner()
    {
        return view('scan-qr');
    }

    public function validateQr($eventId, $qrCode)
    {
        try {
            $user = User::where('qr_code', $qrCode)->firstOrFail();

            if ($user->events()->where('event_id', $eventId)->exists()) {
                return response()->json(['message' => 'Пользователь является участником данного мероприятия'], 200);
            } else {
                return response()->json(['message' => 'Пользователь не является участником данного мероприятия'], 403);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Неверный QR-код или пользователь не найден'], 404);
        }
    }
}
