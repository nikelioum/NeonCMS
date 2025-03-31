<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Page;

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

