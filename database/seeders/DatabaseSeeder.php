<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Supprime les images des livres
        Storage::disk('public')->deleteDirectory('books');

        // Crée un utilisateur de test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Crée 5 auteurs
        Author::factory(5)
            ->has(Book::factory()->count(rand(2, 10)))
            ->create();
    }
}
