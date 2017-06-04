<?php

use Illuminate\Database\Seeder;

class BasicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('Basics')->insert([
            'id' => 1,
            'sitetitle' => 'サイトタイトル',
            'catchphrase' => 'キャッチフレーズ'
        ]);
    }
}
