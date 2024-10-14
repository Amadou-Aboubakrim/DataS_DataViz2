<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(default: route(name: 'dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with(key: 'status', value: 'verification-link-sent');
    }
}
