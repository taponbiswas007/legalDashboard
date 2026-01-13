<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations - Add optimal indexes for performance
     */
    public function up(): void
    {
        // ========== ADDCASES ==========
        $this->addIndexSafely('addcases', 'file_number');
        $this->addIndexSafely('addcases', 'client_id');
        $this->addIndexSafely('addcases', 'court_id');
        $this->addIndexSafely('addcases', 'branch_id'); // column may not exist
        $this->addIndexSafely('addcases', 'status');
        $this->addIndexSafely('addcases', 'filing_or_received_date');
        $this->addIndexSafely('addcases', 'next_hearing_date');
        $this->addCompositeIndexSafely('addcases', ['client_id', 'status']);

        // ========== ADDCLIENTS ==========
        $this->addIndexSafely('addclients', 'email');
        $this->addIndexSafely('addclients', 'phone');
        $this->addIndexSafely('addclients', 'name');

        // ========== COURTS ==========
        $this->addIndexSafely('courts', 'name');

        // ========== USERS ==========
        $this->addIndexSafely('users', 'email');

        // ========== SESSIONS ==========
        $this->addIndexSafely('sessions', 'user_id');
        $this->addIndexSafely('sessions', 'last_activity');
    }

    /**
     * Add single index safely (table + column + duplicate safe)
     */
    private function addIndexSafely(string $table, string $column): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, $column)) {
            return;
        }

        $indexName = "{$table}_{$column}_index";

        if ($this->indexExists($table, $indexName)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($column) {
            $table->index($column);
        });
    }

    /**
     * Add composite index safely
     */
    private function addCompositeIndexSafely(string $table, array $columns): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        foreach ($columns as $column) {
            if (!Schema::hasColumn($table, $column)) {
                return;
            }
        }

        $indexName = $table . '_' . implode('_', $columns) . '_index';

        if ($this->indexExists($table, $indexName)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($columns) {
            $table->index($columns);
        });
    }

    /**
     * Check if index already exists
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $result = DB::select(
            "SHOW INDEX FROM `$table` WHERE Key_name = ?",
            [$indexName]
        );

        return !empty($result);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropIndexSafely('addcases', 'addcases_file_number_index');
        $this->dropIndexSafely('addcases', 'addcases_client_id_index');
        $this->dropIndexSafely('addcases', 'addcases_court_id_index');
        $this->dropIndexSafely('addcases', 'addcases_branch_id_index');
        $this->dropIndexSafely('addcases', 'addcases_status_index');
        $this->dropIndexSafely('addcases', 'addcases_client_id_status_index');
    }

    /**
     * Drop index safely
     */
    private function dropIndexSafely(string $table, string $index): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        if (!$this->indexExists($table, $index)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($index) {
            $table->dropIndex($index);
        });
    }
};
