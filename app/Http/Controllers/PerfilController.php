<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Notifications\ProfileUpdated;


class PerfilController extends Controller
{
    public function index()
    {
        return view("perfil.index");
    }

    public function store(Request $request)
    {
        // Modificar el Request
        $request->request->add(["username" => Str::slug($request->username)]);

        $request->validate([
            "username" => [
                "required",
                Rule::unique("users", "username")->ignore(Auth::user()), 
                "min:3", 
                "max:20", 
                "not_in:twitter,editar-perfil"
            ],
            "email" => [
                "required",
                Rule::unique("users", "email")->ignore(Auth::user()),
                "max:60"
            ],
            "current_password" => "required",
            "new_password" => "nullable|min:8|confirmed"
        ]);

        if($request->imagen) {
             // Identificar que archivo se está subiendo
            $imagen = $request->file("imagen");

            // Crear Id Únicos
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $manager = new ImageManager(new Driver());
            $imagenServidor = $manager->read($imagen);
            $imagenServidor->cover(1000, 1000);

            // Mover la imagen al Servidor
            $imagenPath = public_path("perfiles") . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        } 

        // Verifica la contraseña actual
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Cambia la contraseña si se proporciona una nueva
        if ($request->new_password) {
            $usuario = User::find(Auth::user()->id);
            $usuario->password = Hash::make($request->new_password);
        }
        
        // Guardar Cambios
        $usuario = User::find(Auth::user()->id);
        
        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? null;

        // Cambia la contraseña si se proporciona una nueva
        if ($request->new_password) {
            $usuario->password = Hash::make($request->new_password);
        }
    
        $usuario->save();

        // Redireccionar al Usuario
        return redirect()->route("posts.index", $usuario->username);
    }
}
