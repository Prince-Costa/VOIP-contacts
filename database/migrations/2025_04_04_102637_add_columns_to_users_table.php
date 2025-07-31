<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('email');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->enum('role',['admin','modaretor'])->nullable()->default('admin')->after('company_id');
            $table->dateTime('last_activity')->nullable()->default(now())->after('role');
            $table->integer('auth_id')->nullable()->after('last_activity');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first before dropping the column
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'role','last_activity','auth_id']);
        });
    }
};
