<?php

namespace Database\Seeders;

use App\Models;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@tabel.dev',
            'password' => Hash::make('adminadmin'),
            'accepted_at' => now(),
            'email_verified_at' => now(),
        ]);

        $districts = collect(
            json_decode(
                file_get_contents(base_path('database/seeders/data/kecamatan.json'))
            )
        );

        $districts->each(function ($district) {
            Models\District::factory()->create([
                'id' => $district->id,
                'name' => $district->name,
            ]);
        });

        $offices = collect(
            json_decode(
                file_get_contents(base_path('database/seeders/data/kantor.json'))
            )
        );

        $offices->each(function ($office) use ($districts) {
            $imagePath = base_path("database/seeders/data/$office->image");

            if (file_exists($imagePath)) {
                $imageContent = file_get_contents($imagePath);
                $extension = pathinfo($office->image, PATHINFO_EXTENSION);

                $randomString = Str::random(40);
                $hashedFileName = "offices/$randomString.$extension";

                Storage::disk('public')->put($hashedFileName, $imageContent);

                $office->image = $hashedFileName;
            }

            Models\Office::factory()->create([
                'id' => $office->id,
                'district_id' => $office->district_id,
                'is_district' => $office->is_district,
                'name' => $office->name,
                'latitude' => $office->latitude,
                'longitude' => $office->longitude,
                'image' => $office->image,
            ]);
        });
    }
}
