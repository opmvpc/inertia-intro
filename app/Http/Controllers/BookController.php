<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        /** @var \Illuminate\Pagination\LengthAwarePaginator<\App\Models\Book> $books */
        $books = Book::query()
            ->with('author:id,name')
            ->when(request('search'), function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('author', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(12);

        //transform the books to arrays
        $books = $books->through(fn ($book) => [
            'id' => $book->id,
            'title' => $book->title,
            'image_path' => $book->image_path,
            'author' => [
                'id' => $book->author->id,
                'name' => $book->author->name,
            ]
        ]);

        return Inertia::render('Books/Index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::query()
            ->select('id', 'name')
            ->get()
            ->map(fn ($author) => [
                'id' => $author->id,
                'name' => $author->name,
            ]);

        return Inertia::render('Books/Create', ['authors' => $authors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_id' => 'required|exists:authors,id'
        ]);

        Book::create($validated);

        return redirect()->route('books.index')
            ->banner('Le livre a été créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'image_path' => $book->image_path,
                'author' => [
                    'id' => $book->author->id,
                    'name' => $book->author->name,
                ]
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::query()
            ->select('id', 'name')
            ->get()
            ->map(fn ($author) => [
                'id' => $author->id,
                'name' => $author->name,
            ]);

        return Inertia::render('Books/Edit', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'image_path' => $book->image_path,
                'author_id' => $book->author_id,
            ],
            'authors' => $authors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author_id' => 'required|exists:authors,id'
        ]);

        $book->update($validated);

        return redirect()->route('books.index')
            ->banner('Le livre a été modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->banner('Le livre a été supprimé avec succès');
    }
}
