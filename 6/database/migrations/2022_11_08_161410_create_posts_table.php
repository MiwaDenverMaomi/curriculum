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
            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('つぶやいたユーザーのID')->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('body')->nullable()->default(null)->comment('つぶやき本文');
            $table->timestamp('created_at')->nullable()->default(null)->comment('作成日');
            $table->timestamp('updated_at')->nullable()->default(null)->comment('更新日');
            $table->timestamp('deleted_at')->nullable()->default(null)->comment('論理削除フラグ');
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

// 個人用メモ①：$table->softDeletes();-->これをtimestamp('deleted_at')と同時に記述したらエラーが出た。
//個人用メモ②： $table->timestamps()--->created)at,updated_atを自動設定。対して$table->timetamp('create_at')として
//個別に設定できるが、「timestamp」（単数形）であることに注意
