<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ImagenController extends Controller
{
    public function store(Request $request)
    {
        // Identificar que archivo se está subiendo
        $imagen = $request->file("file");

        // Crear Id Únicos
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        $manager = new ImageManager(new Driver());
        $imagenServidor = $manager->read($imagen);
        $imagenServidor->cover(1000, 1000);

        // Mover la imagen al Servidor
        $imagenPath = public_path("uploads") . "/" . $nombreImagen;
        $imagenServidor->save($imagenPath);


        return response()->json(["imagen" => $nombreImagen]);
    }
}
