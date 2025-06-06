<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QRCodeController extends Controller
{
    public function generateQR(Request $request)
    {
        try {
            $response = Http::post('https://open.oapi.vn/banking/generate-qr', [
                'bin' => '970422',  
                'accountNo' => '999999999',
                'accountName' => 'WATCH STORE',
                'amount' => $request->amount,
                'content' => $request->description
            ]);

            $data = $response->json();

            // Log response để debug
            \Log::info('QR API Response:', $data);

            return response()->json([
                'code' => $data['code'] ?? 'error',
                'data' => $data['data'] ?? null,
                'message' => $data['message'] ?? 'Unknown error'
            ]);

        } catch (\Exception $e) {
            \Log::error('QR Generation Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'code' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
