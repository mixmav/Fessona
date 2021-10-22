<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalloonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balloons', function (Blueprint $table) {
            $table->id();

			$table->longText('content');
			$table->boolean('approved')->default(true);
			$table->integer('likes')->default(0);
			$table->unsignedBigInteger('question_id');

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
        Schema::dropIfExists('balloons');
    }
}
