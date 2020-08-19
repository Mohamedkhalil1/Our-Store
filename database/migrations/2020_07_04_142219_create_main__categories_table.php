<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main__categories', function (Blueprint $table) {
            $table->id();
          
            $table->string('translation_lang',10);
            $table->tinyInteger('translation_off')->default(0)->unsigned();
            $table->string('name',150);
            $table->string('slug',150);
            $table->string('photo',150)->nullable();
            $table->tinyInteger('active')->default('1');
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
        Schema::dropIfExists('main__categories');
    }
}
