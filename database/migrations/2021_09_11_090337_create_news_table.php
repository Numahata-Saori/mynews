<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     
    // title と body と image_path を追記
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            //ニュースのタイトルを保存するカラム
            $table->string('title');
            //ニュースの本文を保存するカラム
            $table->string('body');
            //画像のパスを保存するカラム
            //image_pathの右側にある、->nullable()という記述は、画像のパスは空でも保存できます、という意味、つまり、他の４つは全て、保存時に必ず値が入るカラムに設定される
            $table->string('image_path')->nullable();
            //idとtimestampsはレコードが新規作成される際に自動で埋まる
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
        Schema::dropIfExists('news');
    }
}
