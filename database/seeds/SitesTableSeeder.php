<?php

use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('sites')->insert([
            'id' => 1,
            'title' => 'サイトタイトル',
            'phrase' => 'キャッチフレーズ'
        ]);
    }
}
