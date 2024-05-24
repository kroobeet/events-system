<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        Mail::to('kroo.beet@yandex.ru')->send(new TestEmail());
        return 'Test email sent!';
    }
}

