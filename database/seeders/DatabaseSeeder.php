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

        // unzip file images.zip
        $zip = new \ZipArchive;
        $res = $zip->open(base_path('database/seeders/data/images.zip'));
        if ($res === TRUE) {
            $zip->extractTo(base_path('storage/app/public/offices'));
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

        $offices->each(function ($office) use ($districts) {
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

    private function dataPath($filename){
        return base_path("database/seeders/data/$filename");
    }

    private function makeCollectionfromJSON($filename){
        return collect(
            json_decode(
                file_get_contents($this->dataPath('kantor.json'))
                )
        );
    }
}
