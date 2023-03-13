<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->emptyPublicDirectory();
        DB::beginTransaction();
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();

        DB::commit();
    }

    /**
     * Delete all folders in the app/public directory
     * @return void
     */
    public function emptyPublicDirectory(): void
    {
        $folders = glob('storage/app/public/*');
        foreach ($folders as $folder) {
            foreach (scandir($folder) as $item) {
                if ($item == '.' || $item == '..')
                    continue;
                if (!is_dir($item))
                    unlink($folder . DIRECTORY_SEPARATOR . $item);
            }
            rmdir($folder);
        }
    }
}
