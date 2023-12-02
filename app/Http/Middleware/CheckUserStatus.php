<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\StatusType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && Auth::user()->status == StatusType::CLOSED) {
            Auth::logout();

            return response()->json(['errors' => ['no_active_account' => __('no_active_account_err_msg')]]);
        }

        return $response;
    }
}
