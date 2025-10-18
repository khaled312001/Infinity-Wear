<?php
/**
 * Migration Script: SQLite to MySQL
 * This script migrates all data from SQLite database to MySQL database named 'infinity_final'
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

echo "Starting migration from SQLite to MySQL...\n";

try {
    // Test connections
    echo "Testing SQLite connection...\n";
    $sqliteConnection = Capsule::connection('sqlite');
    $sqliteConnection->getPdo();
    echo "✓ SQLite connection successful\n";

    echo "Testing MySQL connection...\n";
    $mysqlConnection = Capsule::connection('mysql');
    $mysqlConnection->getPdo();
    echo "✓ MySQL connection successful\n";

    // Get all tables from SQLite
    echo "Getting table list from SQLite...\n";
    $tables = $sqliteConnection->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
    $tableNames = array_column($tables, 'name');
    
    echo "Found " . count($tableNames) . " tables: " . implode(', ', $tableNames) . "\n";

    // Create database if not exists
    echo "Creating MySQL database 'infinity_final' if not exists...\n";
    $mysqlConnection->statement("CREATE DATABASE IF NOT EXISTS `infinity_final` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $mysqlConnection->statement("USE `infinity_final`");
    echo "✓ Database created/verified\n";

    // Migrate each table
    foreach ($tableNames as $tableName) {
        echo "\n--- Migrating table: $tableName ---\n";
        
        // Get table structure from SQLite
        $createTableSQL = $sqliteConnection->select("SELECT sql FROM sqlite_master WHERE type='table' AND name='$tableName'")[0]->sql ?? '';
        echo "Original SQLite structure: $createTableSQL\n";
        
        // Get data from SQLite
        $data = $sqliteConnection->table($tableName)->get();
        echo "Found " . count($data) . " records in $tableName\n";
        
        if (count($data) > 0) {
            // Get column information
            $columns = $sqliteConnection->select("PRAGMA table_info($tableName)");
            $columnNames = array_column($columns, 'name');
            $columnTypes = array_column($columns, 'type');
            
            // Create table in MySQL with proper structure
            $mysqlConnection->getSchemaBuilder()->dropIfExists($tableName);
            $mysqlConnection->getSchemaBuilder()->create($tableName, function (Blueprint $table) use ($columns, $tableName) {
                foreach ($columns as $column) {
                    $name = $column->name;
                    $type = strtolower($column->type);
                    $notNull = $column->notnull;
                    $defaultValue = $column->dflt_value;
                    $isPrimaryKey = $column->pk;
                    
                    // Convert SQLite types to MySQL types
                    $mysqlType = 'string';
                    if (strpos($type, 'int') !== false) {
                        $mysqlType = 'bigInteger';
                    } elseif (strpos($type, 'real') !== false || strpos($type, 'float') !== false || strpos($type, 'double') !== false) {
                        $mysqlType = 'decimal';
                    } elseif (strpos($type, 'text') !== false) {
                        $mysqlType = 'text';
                    } elseif (strpos($type, 'blob') !== false) {
                        $mysqlType = 'longText';
                    } elseif (strpos($type, 'datetime') !== false || strpos($type, 'timestamp') !== false) {
                        $mysqlType = 'timestamp';
                    } elseif (strpos($type, 'date') !== false) {
                        $mysqlType = 'date';
                    } elseif (strpos($type, 'time') !== false) {
                        $mysqlType = 'time';
                    } elseif (strpos($type, 'boolean') !== false) {
                        $mysqlType = 'boolean';
                    }
                    
                    // Handle specific column types
                    if ($name === 'id' && $isPrimaryKey) {
                        $table->id();
                    } elseif ($name === 'email' && strpos($type, 'varchar') !== false) {
                        $table->string($name)->unique();
                    } elseif ($name === 'password') {
                        $table->string($name);
                    } elseif ($name === 'remember_token') {
                        $table->string($name, 100)->nullable();
                    } elseif ($name === 'created_at' || $name === 'updated_at') {
                        $table->timestamp($name)->nullable();
                    } elseif ($mysqlType === 'text' && strpos($type, 'varchar') !== false) {
                        $table->string($name, 255);
                    } elseif ($mysqlType === 'text') {
                        $table->text($name);
                    } elseif ($mysqlType === 'decimal') {
                        $table->decimal($name, 10, 2);
                    } elseif ($mysqlType === 'bigInteger') {
                        $table->bigInteger($name);
                    } elseif ($mysqlType === 'boolean') {
                        $table->boolean($name);
                    } elseif ($mysqlType === 'timestamp') {
                        $table->timestamp($name)->nullable();
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
            
            echo "✓ Table structure created in MySQL\n";
            
            // Insert data
            if (count($data) > 0) {
                $chunks = array_chunk($data->toArray(), 100); // Process in chunks of 100
                foreach ($chunks as $chunk) {
                    $mysqlConnection->table($tableName)->insert($chunk);
                }
                echo "✓ Inserted " . count($data) . " records\n";
            }
        } else {
            echo "⚠ No data to migrate for $tableName\n";
        }
    }
    
    echo "\n=== Migration completed successfully! ===\n";
    echo "All data has been migrated from SQLite to MySQL database 'infinity_final'\n";
    
} catch (Exception $e) {
    echo "Error during migration: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
