<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // créer un répertoire pour les images
        Storage::disk('public')->makeDirectory('books');

        // Génère un nom unique pour l'image
        $imageName = 'books/' . uniqid() . '.jpg';

        // Télécharge une image aléatoire depuis picsum
        $imageUrl = 'https://picsum.photos/640/480';
        $imageContent = file_get_contents($imageUrl);

        // Sauvegarde l'image dans le storage
        Storage::disk('public')->put($imageName, $imageContent);

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(3, true),
            'image_path' => $imageName,
            'author_id' => Author::factory()
        ];
    }
}
