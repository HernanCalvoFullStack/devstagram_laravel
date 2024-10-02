@extends("layouts.app")

@section("titulo")
    Editar Perfil: {{ Auth::user()->username}}
@endsection

@section("contenido")
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form 
                class="mt-10 md:mt-0" 
                method="POST" 
                action="{{ route("perfil.store")}}"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="mb-5">
                    <label
                        for="username"
                        class="mb-2 block uppercase text-gray-500 font-bold"
                    >Username</label>
                    <input 
                        id="username"
                        name="username"
                        type="text"
                        placeholder="Tu Nombre de Usuario"
                        class="border p-3 w-full rounded-lg @error("username") border-red-500 @enderror"
                        value="{{ Auth::user()->username }}"
                    />
                    @error("username")
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center uppercase font-bold">{{ str_replace('name', 'nombre', $message) }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label
                        for="email"
                        class="mb-2 block uppercase text-gray-500 font-bold"
                    >Email</label>
                    <input 
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Tu Email de Registro"
                        class="border p-3 w-full rounded-lg @error("email") border-red-500 @enderror"
                        value="{{ Auth::user()->email }}"
                    />
                    @error("email")
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center uppercase font-bold">{{ str_replace('name', 'nombre', $message) }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label
                        for="imagen"
                        class="mb-2 block uppercase text-gray-500 font-bold"
                    >Imagen Perfil</label>
                    <input 
                        id="imagen"
                        name="imagen"
                        type="file"
                        class="border p-3 w-full rounded-lg" 
                        value=""
                        accept=".jpg, .jpeg, .png"
                    />
                </div>

                <div class="mb-5">
                    <label
                        for="current_password"
                        class="mb-2 block uppercase text-gray-500 font-bold"
                    >Password Actual</label>
                    <input 
                        id="current_password"
                        name="current_password"
                        type="password"
                        placeholder="Tu Password Actual"
                        class="border p-3 w-full rounded-lg @error("current_password") border-red-500 @enderror"
                    />
                    @error("current_password")
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center uppercase font-bold">{{ str_replace('name', 'nombre', $message) }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label
                        for="new_password"
                        class="mb-2 block uppercase text-gray-500 font-bold"
                    >Nuevo Password</label>
                    <input 
                        id="new_password"
                        name="new_password"
                        type="password"
                        placeholder="Tu Password Actual"
                        class="border p-3 w-full rounded-lg @error("new_password") border-red-500 @enderror"
                    />
                    @error("new_password")
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center uppercase font-bold">{{ str_replace('name', 'nombre', $message) }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label
                        for="new_password_confirmation"
                        class="mb-2 block uppercase text-gray-500 font-bold"
                    >Confirmar Nueva Contraseña</label>
                    <input 
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        type="password"
                        placeholder="Confirma tu Nueva Contraseña"
                        class="border p-3 w-full rounded-lg @error('new_password_confirmation') border-red-500 @enderror"
                    />
                    @error('new_password_confirmation')
                        <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center uppercase font-bold">{{ str_replace('name', 'nombre', $message) }} </p>
                    @enderror
                </div>

                <input 
                    type="submit"
                    value="Guardar Cambios"
                    class="bg-sky-400 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection