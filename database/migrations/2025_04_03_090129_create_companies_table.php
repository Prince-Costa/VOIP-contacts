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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->string('domain_name')->unique();
            $table->text('registered_address')->nullable();
            $table->text('office_address')->nullable();
            $table->string('business_phone')->nullable();
            $table->enum('agreement_status',['Completed','Pending for Clients Signature','Have to Fillup & Sign', 'Not Yet'])->nullable();
            $table->string('credit_limit')->nullable();
            $table->enum('usdt_support',['Yes', 'No'])->nullable();
            $table->unsignedBigInteger('based_on')->nullable();
            $table->foreign('based_on')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('operating_on')->nullable();
            $table->foreign('operating_on')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('business_type')->nullable();
            $table->foreign('business_type')->references('id')->on('business_types')->onDelete('cascade');
            $table->unsignedBigInteger('interconnection_type')->nullable();
            $table->foreign('interconnection_type')->references('id')->on('interconnection_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
