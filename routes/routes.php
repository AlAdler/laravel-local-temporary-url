<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

foreach (config('local-temporary-url.disk') as $disk) {
    Route::get("$disk/temp/{path}", function (string $path) use ($disk) {
        $file = Storage::disk($disk)->get($path);

        return response($file, 200, ['Content-Type' => Storage::mimeType($path)]);
    })
        ->where('path', '.*')
        ->middleware(config('local-temporary-url.middleware'))
        ->name("$disk.temp");
}
