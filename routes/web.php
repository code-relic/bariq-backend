<?php
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
 
Mail::to('recipient@example.com')->send(new TestMail());
    return view('welcome');
});
 