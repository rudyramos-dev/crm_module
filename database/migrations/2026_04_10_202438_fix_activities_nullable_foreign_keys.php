<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::table('activities', function (Blueprint $table): void {
        $table->dropForeign(['deal_id']);
        $table->dropForeign(['user_id']);

        $table->foreign('deal_id')->references('id')->on('deals')->onDelete('set null');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('activities', function (Blueprint $table): void {
        $table->dropForeign(['deal_id']);
        $table->dropForeign(['user_id']);

        $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
};
