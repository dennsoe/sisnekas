<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SetDefaultSekolah
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('sekolah_id')) {
            $defaultSekolah = Sekolah::first();
            if ($defaultSekolah) {
                $request->merge(['sekolah_id' => $defaultSekolah->id]);
            }
        }
        
        return $next($request);
    }
}