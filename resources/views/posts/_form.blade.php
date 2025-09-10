<div class="mb-4">
    <label for="title" class="text-xs font-medium text-gray-700">Título</label>
    <input type="text" name="title" id="title" class="w-full p-2 border border-gray-700 rounded-md" value="{{ old('title', $post->title ?? '') }}" />

    @error('title')<div class="text-red-500 text-xs">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="category_id" class="text-xs font-medium text-gray-700">Categoría</label>
    <select name="category_id" id="category_id" class="w-full p-2 border border-gray-700 rounded-md appearance-none">
        <option value="">Seleccione una categoría</option>

        @foreach ($categories as $category)

        <option value="{{ $category->id }}"
            @selected(old('category_id', $post->category_id ?? '') == $category->id)
            >{{ $category->name }}</option>

        @endforeach

    </select>

    @error('category_id')<div class="text-red-500 text-xs">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label for="content" class="text-xs font-medium text-gray-700">Contenido</label>
    <textarea name="content" id="content" rows="10" class="w-full p-2 border border-gray-700 rounded-md">{{ old('content', $post->content ?? '') }}</textarea>

    @error('content')<div class="text-red-500 text-xs">{{ $message }}</div>@enderror
</div>
