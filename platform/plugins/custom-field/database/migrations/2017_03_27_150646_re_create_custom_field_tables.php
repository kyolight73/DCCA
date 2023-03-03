<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('field_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('rules')->nullable();
            $table->integer('order')->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('field_items', function (Blueprint $table) {
            $table->id();
            $table->integer('field_group_id')->unsigned()->index();
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->integer('order')->default(0)->nullable();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('type', 100);
            $table->text('instructions')->nullable();
            $table->text('options')->nullable();
        });

        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('use_for', 255);
            $table->integer('use_for_id')->unsigned();
            $table->integer('field_item_id')->unsigned()->index();
            $table->string('type', 255);
            $table->string('slug', 255);
            $table->text('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('field_items');
        Schema::dropIfExists('field_groups');
    }
};
