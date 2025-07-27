<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tasks')->get()->each(function ($task) {
            DB::table('tasks')
                ->where('id', $task->id)
                ->update([
                    'name' => json_encode(['en' => $task->name]),
                    'description' => json_encode(['en' => $task->description]),
                ]);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('tasks')->get()->each(function ($task) {
            $name = json_decode($task->name, true)['en'] ?? null;
            $description = json_decode($task->description, true)['en'] ?? null;

            DB::table('tasks')
                ->where('id', $task->id)
                ->update([
                    'name' => $name,
                    'description' => $description,
                ]);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->nullable()->change();
        });
    }
};
