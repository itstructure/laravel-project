<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLanguagesTable
 */
class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id()->primaryKey();
            $table->string('locale', 8);
            $table->string('short_name', 3);
            $table->string('name', 64);
            $table->unsignedTinyInteger('default')->default(0);
            $table->timestamps();
        });

        DB::statement("INSERT INTO languages(`locale`, `short_name`, `name`, `default`, `created_at`, `updated_at`) VALUES ('en-EN', 'en', 'English', 1, NOW(), NOW())");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
