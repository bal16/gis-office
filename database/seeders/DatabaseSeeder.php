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
            'email' => "admin".env('APP_EMAIL', '@gis.dev'),
            'password' => Hash::make('A2345678'),
            'accepted_at' => now(),
            'email_verified_at' => now(),
        ]);

        // Models\User::factory()->create([
        //     'name' => 'unaccepted admin',
        //     'email' => "unaccepted".env('APP_EMAIL', '@gis.dev'),
        //     'password' => Hash::make('A2345678'),
        //     'email_verified_at' => now(),
        // ]);

        // Models\User::factory()->create([
        //     'name' => 'unverified email',
        //     'email' => "unverified".env('APP_EMAIL', '@gis.dev'),
        //     'password' => Hash::make('A2345678'),
        // ]);

        // Models\User::factory()->create([
        //     'name' => 'wrong format test',
        //     'email' => 'test@gmail.com',
        //     'password' => Hash::make('A2345678'),
        // ]);

        // unzip file images.zip
        $zip = new \ZipArchive;
        $res = $zip->open($this->dataPath('images.zip'));
        if ($res === TRUE) {
            $zip->extractTo($this->dataPath());
            $zip->close();
        } else {
            echo 'failed, code:' . $res;
            return;
        }

        $districts = $this->makeCollectionfromJSON($this->dataPath('kecamatan.json'));

        $districts->each(function ($district) {
            Models\District::factory()->create([
                'id' => $district->id,
                'name' => $district->name,
            ]);
        });


        $offices = $this->makeCollectionfromJSON($this->dataPath('kantor.json'));

        $offices->each(function ($office)  {
            $imagePath = $this->dataPath($office->image);

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

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        });
    }

    private function dataPath($path=''){
        return base_path("database/seeders/data/$path");
    }

    private function makeCollectionfromJSON($path){
        return collect(
            json_decode(
                file_get_contents($path)
                )
        );
    }
}
