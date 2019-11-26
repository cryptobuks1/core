<?php

use Illuminate\Database\Seeder;

class WeblinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weblinks = new App\Modules\Weblink\Models\Weblink([
            'name' => 'Nencer',
            'url' => 'https://nencer.com',
            'image' => 'nencer.jpg',
            'description' => 'Nencer corp',
            'status' => 1,
            'sort' => 1
        ]);

        $weblinks->save();
    }
}
