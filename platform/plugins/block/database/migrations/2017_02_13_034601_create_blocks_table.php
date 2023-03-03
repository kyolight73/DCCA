<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->string('description', 255)->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
