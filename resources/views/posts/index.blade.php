<x-forum.layouts.app>
    <div class="flex justify-between my-8">
        <h1 class="text-2xl font-bold">
            Blog
        </h1>
        @auth
            <a href="{{ route('posts.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500">Crear Post</a>
        @endauth
    </div>

    <div class="space-y-4">
        @foreach ($posts as $post)
            <div class="mb-4">
                <h2 class="text-2xl font-bold">
                    <a href="{{ route('posts.show', $post) }}" class="hover:underline">
                        {{ $post->title }}
                    </a>
                </h2>

                <p class="text-xs text-gray-500">
                    <span class="font-semibold">{{$post->user->name}}</span> |
                    {{ $post->category->name }} |
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        @endforeach

        {{ $posts->links() }}
    </div>
</x-forum.layouts.app>
