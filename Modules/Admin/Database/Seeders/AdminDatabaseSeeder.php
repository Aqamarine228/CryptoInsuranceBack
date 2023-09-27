<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\MediaFolder;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        MediaFolder::firstOrCreate([
            'id' => 1,
            'name' => 'images',
        ]);
        MediaFolder::firstOrCreate([
            'id' => 2,
            'name' => 'advertising',
        ]);
    }
}
