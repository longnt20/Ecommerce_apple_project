<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên sản phẩm
            $table->string('slug')->unique(); // SEO link
            $table->string('short_description')->nullable(); // Mô tả ngắn
            $table->text('description')->nullable(); // Mô tả chi tiết
            $table->unsignedBigInteger('category_id'); // FK tới categories
            $table->string('thumbnail')->nullable(); // Ảnh đại diện
            $table->json('gallery')->nullable(); // Bộ sưu tập ảnh (JSON array)
            $table->decimal('default_price', 15, 2)->nullable(); // Giá mặc định
            $table->enum('visibility', ['public', 'hidden'])->default('public');
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
