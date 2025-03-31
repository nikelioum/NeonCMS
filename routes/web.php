<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/categories/{category}', function (Category $category) {
    // Your logic for displaying the category, for example:
    return $category;
})->name('categories.show');

