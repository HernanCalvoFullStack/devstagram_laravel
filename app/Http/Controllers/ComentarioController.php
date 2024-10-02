<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        // Validamos
        $request->validate([
            "comentario" => "required|max:255"
            ]);

        // Almacenamos el comentario
        Comentario::create([
            "user_id" => Auth::user()->id,
            "post_id" => $post->id,
            "comentario" => $request->comentario
        ]);

        // Imprimimos un mensaje
        return back()->with("mensaje", "Comentario Realizado Correctamente");
    }
}
