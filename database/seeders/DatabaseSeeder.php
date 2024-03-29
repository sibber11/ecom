<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        dump(env('app_env'));
        if (env('app_env') != 'testing'){
            $this->emptyPublicDirectory();
        }
        DB::beginTransaction();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            TagSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            AttributeSeeder::class,
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
