<?php
// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        // Proteger las rutas que requieren autenticación
        $this->middleware('auth')->except(['index', 'show']);
        // Proteger las rutas con autorización (Policies), asumiendo que PostPolicy existe
        $this->middleware('can:update,post')->only(['edit', 'update']);
        $this->middleware('can:delete,post')->only('destroy');
    }

    public function index()
    {
        $posts = Post::with('user', 'category')
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post();
        $categories = Category::all();
        return view('posts.create', compact('post', 'categories'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $post = Post::create([
            'user_id' => Auth::id(),
            ...$validated,
            'slug' => Str::slug($validated['title']),
        ]);

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $post->load('category');
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();
        $post->update([
            ...$validated,
            'slug' => Str::slug($validated['title']),
        ]);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post eliminado correctamente.');
    }
}
