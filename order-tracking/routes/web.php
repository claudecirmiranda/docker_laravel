<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order;
use App\Http\Middleware\TrackingValidateHash;
use Illuminate\Support\Facades\File;


Route::prefix('order-tracking')->group(function () {
    Route::get('/', function () {
        return redirect('https://www.nagem.com.br');
    });

    Route::get('/docs/{path?}', function ($path = null) {
        $filePath = public_path('docs/' . ($path ? $path : 'index.html'));
    
        if (File::exists($filePath)) {
            $mimeType = '';
            if (str_ends_with($filePath, '.js')) {
                $mimeType = 'application/javascript';
            } elseif (str_ends_with($filePath, '.css')) {
                $mimeType = 'text/css';
            }
    
            return response()->file($filePath, ['Content-Type' => $mimeType]);
        }
    
        abort(404);
    })->where('path', '.*');
    
    Route::get('/{orderId}/{channel}', [Order\TrackingController::class, 'generateHash'])
        ->name('order.tracking.generateHash');

    Route::get('/{hash}', [Order\TrackingController::class, 'show'])
        ->middleware(TrackingValidateHash::class)
        ->name('order.tracking.show');

    Route::get('/build/assets/{any}', function ($any) {
        $filePath = public_path("build/assets/$any");

        // Verifica se o arquivo existe
        if (!file_exists($filePath)) {
            abort(404); // Retorna 404 se o arquivo não existir
        }

        // Obtém a extensão do arquivo para definir o tipo MIME
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = match ($extension) {
            'css' => 'text/css',
            'js' => 'application/javascript',
            'html' => 'text/html',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            default => 'application/octet-stream',
        };

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
        ]);
    })->where('any', '.*');

});
