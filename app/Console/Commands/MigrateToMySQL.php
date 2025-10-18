<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class MigrateToMySQL extends Command
{
    protected $signature = 'migrate:to-mysql {--database=infinity_final}';
    protected $description = 'Migrate all data from SQLite to MySQL database';

    public function handle()
    {
        $targetDatabase = $this->option('database');
        
        $this->info("Starting migration from SQLite to MySQL database: $targetDatabase");
        
        try {
            // Test SQLite connection
            $this->info("Testing SQLite connection...");
            DB::connection('sqlite')->getPdo();
            $this->info("✓ SQLite connection successful");
            
            // Test MySQL connection
            $this->info("Testing MySQL connection...");
            DB::connection('mysql')->getPdo();
            $this->info("✓ MySQL connection successful");
            
            // Create target database
            $this->info("Creating MySQL database '$targetDatabase' if not exists...");
            DB::statement("CREATE DATABASE IF NOT EXISTS `$targetDatabase` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $this->info("✓ Database created/verified");
            
            // Get all tables from SQLite
            $this->info("Getting table list from SQLite...");
            $tables = DB::connection('sqlite')->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $tableNames = array_column($tables, 'name');
            $this->info("Found " . count($tableNames) . " tables: " . implode(', ', $tableNames));
            
            // Switch to target database
            config(['database.connections.mysql.database' => $targetDatabase]);
            DB::purge('mysql');
            
            // Migrate each table
            foreach ($tableNames as $tableName) {
                $this->info("\n--- Migrating table: $tableName ---");
                
                // Get table structure
                $columns = DB::connection('sqlite')->select("PRAGMA table_info($tableName)");
                $this->info("Found " . count($columns) . " columns");
                
                // Get data
                $data = DB::connection('sqlite')->table($tableName)->get();
                $this->info("Found " . count($data) . " records");
                
                if (count($data) > 0) {
                    // Drop table if exists
                    Schema::dropIfExists($tableName);
                    
                    // Create table structure
                    Schema::create($tableName, function (Blueprint $table) use ($columns) {
                        foreach ($columns as $column) {
                            $name = $column->name;
                            $type = strtolower($column->type);
                            $notNull = $column->notnull;
                            $defaultValue = $column->dflt_value;
                            $isPrimaryKey = $column->pk;
                            
                            // Convert SQLite types to MySQL types
                            if ($name === 'id' && $isPrimaryKey) {
                                $table->id();
                            } elseif ($name === 'email') {
                                $table->string($name)->unique();
                            } elseif ($name === 'password') {
                                $table->string($name);
                            } elseif ($name === 'remember_token') {
                                $table->string($name, 100)->nullable();
                            } elseif ($name === 'created_at' || $name === 'updated_at') {
                                $table->timestamp($name)->nullable();
                            } elseif (strpos($type, 'int') !== false) {
                                $table->bigInteger($name);
                            } elseif (strpos($type, 'real') !== false || strpos($type, 'float') !== false || strpos($type, 'double') !== false) {
                                $table->decimal($name, 10, 2);
                            } elseif (strpos($type, 'text') !== false) {
                                $table->text($name);
                            } elseif (strpos($type, 'blob') !== false) {
                                $table->longText($name);
                            } elseif (strpos($type, 'datetime') !== false || strpos($type, 'timestamp') !== false) {
                                $table->timestamp($name)->nullable();
                            } elseif (strpos($type, 'date') !== false) {
                                $table->date($name);
                            } elseif (strpos($type, 'time') !== false) {
                                $table->time($name);
                            } elseif (strpos($type, 'boolean') !== false) {
                                $table->boolean($name);
                            } else {
                                $table->string($name);
                            }
                            
                            // Add constraints
                            if ($notNull && $name !== 'id' && $name !== 'created_at' && $name !== 'updated_at') {
                                $table->getColumns()[count($table->getColumns())-1]->nullable(false);
                            }
                            
                            if ($defaultValue !== null && $name !== 'id') {
                                $table->getColumns()[count($table->getColumns())-1]->default($defaultValue);
                            }
                        }
                    });
                    
                    $this->info("✓ Table structure created");
                    
                    // Insert data in chunks
                    $chunks = $data->chunk(100);
                    foreach ($chunks as $chunk) {
                        DB::table($tableName)->insert($chunk->toArray());
                    }
                    
                    $this->info("✓ Inserted " . count($data) . " records");
                } else {
                    $this->warn("⚠ No data to migrate for $tableName");
                }
            }
            
            $this->info("\n=== Migration completed successfully! ===");
            $this->info("All data has been migrated from SQLite to MySQL database '$targetDatabase'");
            
            // Verify migration
            $this->info("\nVerifying migration...");
            $mysqlTables = DB::select("SHOW TABLES");
            $tableNames = array_column($mysqlTables, 'Tables_in_' . $targetDatabase);
            $this->info("MySQL tables: " . implode(', ', $tableNames));
            
            foreach ($tableNames as $table) {
                $count = DB::table($table)->count();
                $this->info("- $table: $count records");
            }
            
        } catch (\Exception $e) {
            $this->error("Error during migration: " . $e->getMessage());
            $this->error("File: " . $e->getFile() . " Line: " . $e->getLine());
            return 1;
        }
        
        return 0;
    }
}
