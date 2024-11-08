<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator<\App\Models\Author> $authors */
        $authors = Author::query()
            ->when(request('search'), function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->withCount('books')
            ->paginate(12);

        //transform the authors to arrays
        $authors = $authors->through(fn ($author) => [
            'id' => $author->id,
            'name' => $author->name,
            'created_at' => $author->created_at->format('d/m/Y'),
            'books_count' => $author->books_count,
        ]);

        return Inertia::render('Authors/Index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Authors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string'
        ]);

        Author::create($validated);

        return redirect()->route('authors.index')
            ->banner('Auteur créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return Inertia::render('Authors/Show', [
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
                'biography' => $author->biography,
                'books' => $author->books->map(fn ($book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'image_path' => $book->image_path,
                ]),
                'books_count' => $author->books->count(),
                'created_at' => $author->created_at->format('d/m/Y'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return Inertia::render('Authors/Edit', [
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
                'biography' => $author->biography,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string'
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')
            ->banner('Auteur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')
            ->banner('Auteur supprimé avec succès');
    }
}
