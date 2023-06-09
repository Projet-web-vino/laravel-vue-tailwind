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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bouteille_id');
            $table->unsignedBigInteger('utilisateur_id');
            $table->text('commentaire')->nullable();
            $table->integer('note')->nullable();
            $table->timestamps();

            $table->foreign('bouteille_id')->references('id')->on('bouteilles')->onDelete('cascade');
            $table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
