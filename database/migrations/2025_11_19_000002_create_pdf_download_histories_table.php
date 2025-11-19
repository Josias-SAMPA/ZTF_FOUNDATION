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
        Schema::create('pdf_download_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hq_staff_form_id')->constrained('hq_staff_forms')->onDelete('cascade');
            $table->string('pdf_filename');
            $table->string('pdf_path');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('generated_by')->nullable();
            $table->timestamp('generated_at');
            $table->integer('download_count')->default(0);
            $table->timestamp('last_downloaded_at')->nullable();
            $table->timestamps();

            $table->index('hq_staff_form_id');
            $table->index('generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_download_histories');
    }
};
