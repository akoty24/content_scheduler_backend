<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




// use App\Models\User;
// use Illuminate\Support\Carbon;

// $user = User::first();

// for ($i = 1; $i <= 9; $i++) {
//     $user->posts()->create([
//         'title' => "Draft Post $i",
//         'content' => "This is draft post number $i",
//         'status' => 'draft',
//         'image_url' => 'http://127.0.0.1:8000/images/posts/Vac4yt0Sfl.webp',
//         'scheduled_time' => null,
//     ]);
// }

// for ($i = 1; $i <= 9; $i++) {
//     $user->posts()->create([
//         'title' => "Scheduled Post $i",
//         'content' => "This is scheduled post number $i",
//         'status' => 'scheduled',
//         'image_url' => 'images/posts/wh5DfD0quB.jpg',
//         'scheduled_time' => Carbon::now()->addMinutes(10 * $i),  
//     ]);
// }

