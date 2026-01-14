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
        // Mettre à jour les départements avec un chef mais sans date d'assignation
        // Utiliser la date de création du département comme date d'assignation
        \DB::statement('UPDATE departments SET head_assigned_at = created_at WHERE head_id IS NOT NULL AND head_assigned_at IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rien à faire
    }
};
