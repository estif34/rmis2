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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            
            // Risk assessment attributes
            $table->string('level')->nullable();
            $table->string('proximity')->nullable();
            $table->string('likelihood')->nullable();
            $table->string('risk_area')->nullable();
            $table->string('department')->nullable();
            $table->string('status')->default('open');
            
            // Impact details
            $table->string('impact_level')->nullable();
            $table->string('impact_likelihood')->nullable();
            $table->string('impact_proximity')->nullable();
            $table->text('impact_description')->nullable();
            $table->string('impact_type')->nullable();
            $table->string('cause_of_impact')->nullable();
            $table->decimal('financial_impact', 15, 2)->nullable();
            $table->string('impact_status')->nullable();
            
            // Mitigation details
            $table->string('response_type')->nullable();
            $table->text('mitigation_strategy')->nullable();
            $table->string('residual_risk')->nullable();
            $table->string('mitigation_department')->nullable();
            $table->string('mitigation_status')->nullable();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('risk_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
