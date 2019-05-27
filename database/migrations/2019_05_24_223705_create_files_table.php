<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 16)->charset('latin1')->collation('latin1_general_cs')->unique();
            $table->string('name')->nullable();
            $table->integer('size')->nullable()->unsigned();
            $table->boolean('is_image')->unsigned();
            $table->decimal('nsfw_score', 5, 4)->unsigned()->default(0);
            $table->datetime('expires_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
