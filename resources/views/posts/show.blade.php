<x-forum.layouts.app>
    <div class="flex items-center gap-2 w-full my-8">
        <livewire:heart :heartable="$post" />

        <div class="w-full">
            <h1 class="text-2xl font-bold md:text-3xl">
                {{ $post->title }}
            </h1>

            <div class="flex justify-between">
                <p class="text-xs text-gray-500">
                    <span class="font-semibold">{{$post->user->name}}</span> |
                    {{ $post->category->name }} |
                    {{ $post->created_at->diffForHumans() }}
                </p>
                @auth

                <div class="flex items-center gap-2">
                    @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="text-xs font-semibold hover:underline">
                        Editar
                    </a>
                    @endcan

                    @can('delete', $post)

                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-md bg-red-600 hover:bg-red-500 px-2 py-1 text-xs font-semibold text-white cursor-pointer">
                            Eliminar
                        </button>
                    </form>
                    @endcan
                </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="my-4 prose prose-invert max-w-none">
        {!! \Illuminate\Support\Str::markdown($post->content) !!}
    </div>

    <div class="my-8">
        <!-- Comments -->
       <livewire:comment :commentable="$post" />
    </div>

</x-forum.layouts.app>
