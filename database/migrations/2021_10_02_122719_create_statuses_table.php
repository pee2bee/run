<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id')->comment('自增主键');
            $table->text('content')->comment('微博内容');
            $table->integer('user_id')->index()->comment('增加用户id作索引');
            $table->index('created_at')->comment('创建时间添加索引');
            $table->timestamps();//created_at当前时间 updated_at当前时间并更新时会自动更新字段

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
