<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name("home")->middleware("auth");

Route::get('/register', [RegisterController::class, "index"])->name("register");
Route::post('/register', [RegisterController::class, "store"])->name("register");

Route::get("/login", [LoginController::class, "index"])->name("login");
Route::post("/login", [LoginController::class, "store"])->name("login");

Route::post("/logout", [LogoutController::class, "store"])->name("logout");

// Perfil
Route::get("/editar-perfil", [PerfilController::class, "index"])->name("perfil.index")->middleware("auth");
Route::post("/editar-perfil", [PerfilController::class, "store"])->name("perfil.store");

Route::get('/posts/create', [PostController::class, "create"])->name("posts.create")->middleware("auth");
Route::post('/posts', [PostController::class, "store"])->name("posts.store")->middleware("auth");
Route::get("{user:username}/posts/{post}", [PostController::class, "show"])->name("posts.show");
Route::delete("/posts/{post}", [PostController::class, "destroy"])->name("posts.destroy");


// Comentarios
Route::post("{user:username}/posts/{post}", [ComentarioController::class, "store"])->name("comentarios.store");

Route::post('/imagenes', [ImagenController::class, "store"])->name("imagenes.store");

// Likes
Route::post("/posts/{post}/likes", [LikeController::class, "store"])->name("posts.like.store");
Route::delete("/posts/{post}/likes", [LikeController::class, "destroy"])->name("posts.like.destroy");

Route::get('/{user:username}', [PostController::class, "index"])->name("posts.index");

// Siguiendo Usuarios
Route::post("/{user:username}/follow", [FollowerController::class, "store"])->name("users.follow");
Route::delete("/{user:username}/unfollow", [FollowerController::class, "destroy"])->name("users.unfollow");