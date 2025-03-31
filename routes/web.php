<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/categories/{category}', function (Category $category) {
    // Your logic for displaying the category, for example:
    return $category;
})->name('categories.show');

Route::get('/pages/{page}', function (Page $page) {
    // Your logic for displaying the category, for example:
    return $page;
})->name('pages.show');


Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Laravel.', function ($message) {
        $message->to('your-email@example.com')
            ->subject('Test Email from Laravel')
            ->html('<h1>Hello!</h1><p>This is a test email with HTML formatting.</p>');
    });

    return 'Test email sent!';
});

