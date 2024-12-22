<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\PostTooLargeException;

class HandleFileUploadErrors
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (PostTooLargeException $e) {
            return back()->with('error', 'The uploaded file is too large. Maximum allowed size is ' . ini_get('upload_max_filesize'));
        }
    }
}
