@extends("layouts.app")

@section("titulo")
    {{ $post->titulo}}
@endsection


@section("contenido")
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset("uploads") . "/" . $post->imagen}}" alt="Imagen del post {{ $post->titulo }}">
            <div class="p-3 flex items-center gap-4">
               
                @auth
                    <livewire:like-post :post="$post" />
                @endauth

            </div>

            <div>
                <p class="font-bold">{{ $post->user->username}}</p>
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans()}}</p>
                <div class="mt-5">
                    {{ $post->descripcion }}
                </div>
            </div>

            @auth
                @if($post->user_id === auth()->user()->id)
                <form method="POST" action="{{ route("posts.destroy", $post)}}">
                    @method("DELETE")
                    @csrf
                    <input
                    onclick="return confirm('¿Estás seguro de que quieres eliminar esta publicación?');" 
                    type="submit"
                    value="Eliminar Publicación"
                    class="bg-red-400 hover:bg-red-700 p-2 rounded text-white font-bold mt-4 cursor-pointer transition-colors"
                    />
                </form>
                @endif
            @endauth
        </div>
        
        <div class="md:w-1/2 p-5">
            
            <div class="shadow bg-white p-5 mb-5">
                <p class="text-xl font-bold text-center mb-4">Comentarios</p>
                
                @auth

                @if(session("mensaje"))
                    <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                        {{session("mensaje")}}
                    </div>
                @endif

                <form action="{{ route("comentarios.store", ["post" => $post, "user" => $user]) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label
                            for="comentario"
                            class="mb-2 block uppercase text-gray-500 font-bold"
                        >Has un Comentario</label>
                        <textarea 
                            id="comentario"
                            name="comentario"
                            placeholder="Agrega un Comentario"
                            class="border p-3 w-full rounded-lg @error("name") border-red-500 @enderror"
                        ></textarea>
                        @error("comentario")
                            <p class="bg-red-500 text-white my-2 rounded-lg p-2 text-center uppercase font-bold">{{($message) }} </p>
                        @enderror
                    </div>

                    <input 
                        type="submit"
                        value="Comentar"
                        class="bg-sky-400 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                    />
                </form>
                @endauth

                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <a class="font-bold" href="{{ route("posts.index", $comentario->user) }}">{{$comentario->user->username}}</a>
                                <p>{{$comentario->comentario}}</p>
                                <p class="text-sm text-gray-500">{{$comentario->created_at->diffForHumans()}}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">Aún no hay comentarios</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection