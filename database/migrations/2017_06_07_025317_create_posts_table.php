<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('link');
            $table->text('content');
            /**
             * TODO: fix
             * _id はテーブルに持っているとき（リレーションがあるとき）に使ったほうがいいかも
             * 将来はステータスもテーブル管理するならこれでも可。
             */
            $table->integer('status_id');
            /**
             * TODO: fix
             * １対多なら、外部キー制約があったほうが良い。
             * あと、idが入るならunsignedも指定したい。
             */
            $table->integer('category_id');
            $table->integer('tag_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
