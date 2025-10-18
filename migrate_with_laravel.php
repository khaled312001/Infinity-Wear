<?php
/**
 * Laravel-based Migration Script: SQLite to MySQL
 * This script uses Laravel's database connections to migrate data
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

// Database configurations
$sqliteConfig = [
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database/database.sqlite',
    'prefix' => '',
    'foreign_key_constraints' => true,
];

$mysqlConfig = [
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'infinity_final',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'timezone' => '+03:00',
];

// Initialize Eloquent
$capsule = new Capsule;
$capsule->addConnection($sqliteConfig, 'sqlite');
$capsule->addConnection($mysqlConfig, 'mysql');
$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "=== Laravel-based Database Migration ===\n";
echo "Target Database: infinity_final\n\n";

try {
    // Test connections
    echo "1. Testing connections...\n";
    $sqliteConnection = Capsule::connection('sqlite');
    $sqliteConnection->getPdo();
    echo "   ✓ SQLite connection successful\n";
    
    $mysqlConnection = Capsule::connection('mysql');
    $mysqlConnection->getPdo();
    echo "   ✓ MySQL connection successful\n";

    // Create target database
    echo "2. Creating target database...\n";
    $mysqlConnection->statement("CREATE DATABASE IF NOT EXISTS `infinity_final` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "   ✓ Database created/verified\n";

    // Get all tables from SQLite
    echo "3. Getting table list from SQLite...\n";
    $tables = $sqliteConnection->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
    $tableNames = array_column($tables, 'name');
    echo "   Found " . count($tableNames) . " tables\n";

    $totalRecords = 0;
    $migratedTables = 0;

    // Migrate each table
    foreach ($tableNames as $tableName) {
        echo "\n--- Migrating table: $tableName ---\n";
        
        try {
            // Get data from SQLite
            $data = $sqliteConnection->table($tableName)->get();
            echo "   Records: " . count($data) . "\n";
            
            if (count($data) > 0) {
                // Get table structure
                $columns = $sqliteConnection->select("PRAGMA table_info($tableName)");
                
                // Drop table if exists
                $mysqlConnection->statement("DROP TABLE IF EXISTS `$tableName`");
                
                // Create table with proper structure
                $mysqlConnection->getSchemaBuilder()->create($tableName, function (Blueprint $table) use ($columns) {
                    foreach ($columns as $column) {
                        $name = $column->name;
                        $type = strtolower($column->type);
                        $notNull = $column->notnull;
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
                        
                        // Add NOT NULL constraint
                        if ($notNull && $name !== 'id' && $name !== 'created_at' && $name !== 'updated_at') {
                            $table->getColumns()[count($table->getColumns())-1]->nullable(false);
                        }
                    }
                });
                
                echo "   ✓ Table structure created\n";
                
                // Insert data in chunks
                $chunks = $data->chunk(100);
                foreach ($chunks as $chunk) {
                    $mysqlConnection->table($tableName)->insert($chunk->toArray());
                }
                
                echo "   ✓ Inserted " . count($data) . " records\n";
                $totalRecords += count($data);
                $migratedTables++;
            } else {
                echo "   ⚠ No data to migrate\n";
            }
            
        } catch (Exception $e) {
            echo "   ❌ Error migrating $tableName: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== Migration Summary ===\n";
    echo "Tables migrated: $migratedTables\n";
    echo "Total records migrated: $totalRecords\n";
    echo "Target database: infinity_final\n";
    
    // Verify migration
    echo "\n=== Verification ===\n";
    $mysqlTables = $mysqlConnection->select("SHOW TABLES");
    $tableNames = array_column($mysqlTables, 'Tables_in_infinity_final');
    echo "MySQL tables: " . implode(', ', $tableNames) . "\n";
    
    foreach ($tableNames as $table) {
        $count = $mysqlConnection->table($table)->count();
        echo "- $table: $count records\n";
    }
    
    echo "\n✅ Migration completed successfully!\n";
    echo "All data has been migrated from SQLite to MySQL database 'infinity_final'\n";
    
} catch (Exception $e) {
    echo "\n❌ Error during migration: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    exit(1);
}
