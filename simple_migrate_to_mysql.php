<?php
/**
 * Simple Migration Script: SQLite to MySQL
 * This script migrates all data from SQLite database to MySQL database named 'infinity_final'
 */

// Database configurations
$sqliteFile = __DIR__ . '/database/database.sqlite';
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';
$mysqlDatabase = 'infinity_final';
$mysqlUsername = 'root';
$mysqlPassword = '';

echo "Starting migration from SQLite to MySQL...\n";

try {
    // Connect to SQLite
    echo "Connecting to SQLite database...\n";
    $sqlite = new PDO("sqlite:$sqliteFile");
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ SQLite connection successful\n";

    // Connect to MySQL
    echo "Connecting to MySQL database...\n";
    $mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort", $mysqlUsername, $mysqlPassword);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ MySQL connection successful\n";

    // Create database if not exists
    echo "Creating MySQL database '$mysqlDatabase' if not exists...\n";
    $mysql->exec("CREATE DATABASE IF NOT EXISTS `$mysqlDatabase` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $mysql->exec("USE `$mysqlDatabase`");
    echo "✓ Database created/verified\n";

    // Get all tables from SQLite
    echo "Getting table list from SQLite...\n";
    $tables = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll(PDO::FETCH_COLUMN);
    echo "Found " . count($tables) . " tables: " . implode(', ', $tables) . "\n";

    // Migrate each table
    foreach ($tables as $tableName) {
        echo "\n--- Migrating table: $tableName ---\n";
        
        // Get table structure
        $columns = $sqlite->query("PRAGMA table_info($tableName)")->fetchAll(PDO::FETCH_ASSOC);
        echo "Found " . count($columns) . " columns\n";
        
        // Get data
        $data = $sqlite->query("SELECT * FROM $tableName")->fetchAll(PDO::FETCH_ASSOC);
        echo "Found " . count($data) . " records\n";
        
        if (count($data) > 0) {
            // Drop table if exists
            $mysql->exec("DROP TABLE IF EXISTS `$tableName`");
            
            // Create table structure
            $createSQL = "CREATE TABLE `$tableName` (";
            $columnDefs = [];
            
            foreach ($columns as $column) {
                $name = $column['name'];
                $type = strtolower($column['type']);
                $notNull = $column['notnull'];
                $defaultValue = $column['dflt_value'];
                $isPrimaryKey = $column['pk'];
                
                // Convert SQLite types to MySQL types
                $mysqlType = 'VARCHAR(255)';
                if ($name === 'id' && $isPrimaryKey) {
                    $mysqlType = 'BIGINT AUTO_INCREMENT PRIMARY KEY';
                } elseif (strpos($type, 'int') !== false) {
                    $mysqlType = 'BIGINT';
                } elseif (strpos($type, 'real') !== false || strpos($type, 'float') !== false || strpos($type, 'double') !== false) {
                    $mysqlType = 'DECIMAL(10,2)';
                } elseif (strpos($type, 'text') !== false) {
                    $mysqlType = 'TEXT';
                } elseif (strpos($type, 'blob') !== false) {
                    $mysqlType = 'LONGTEXT';
                } elseif (strpos($type, 'datetime') !== false || strpos($type, 'timestamp') !== false) {
                    $mysqlType = 'TIMESTAMP NULL';
                } elseif (strpos($type, 'date') !== false) {
                    $mysqlType = 'DATE';
                } elseif (strpos($type, 'time') !== false) {
                    $mysqlType = 'TIME';
                } elseif (strpos($type, 'boolean') !== false) {
                    $mysqlType = 'BOOLEAN';
                } elseif ($name === 'email') {
                    $mysqlType = 'VARCHAR(255) UNIQUE';
                } elseif ($name === 'password') {
                    $mysqlType = 'VARCHAR(255)';
                } elseif ($name === 'remember_token') {
                    $mysqlType = 'VARCHAR(100)';
                } elseif ($name === 'created_at' || $name === 'updated_at') {
                    $mysqlType = 'TIMESTAMP NULL';
                }
                
                $columnDef = "`$name` $mysqlType";
                
                if ($notNull && $name !== 'id' && $name !== 'created_at' && $name !== 'updated_at') {
                    $columnDef .= ' NOT NULL';
                }
                
                if ($defaultValue !== null && $name !== 'id') {
                    $columnDef .= " DEFAULT " . ($defaultValue === 'CURRENT_TIMESTAMP' ? 'CURRENT_TIMESTAMP' : "'$defaultValue'");
                }
                
                $columnDefs[] = $columnDef;
            }
            
            $createSQL .= implode(', ', $columnDefs) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $mysql->exec($createSQL);
            echo "✓ Table structure created\n";
            
            // Insert data
            if (count($data) > 0) {
                $columnNames = array_keys($data[0]);
                $placeholders = ':' . implode(', :', $columnNames);
                $insertSQL = "INSERT INTO `$tableName` (`" . implode('`, `', $columnNames) . "`) VALUES ($placeholders)";
                
                $stmt = $mysql->prepare($insertSQL);
                
                foreach ($data as $row) {
                    // Convert boolean values
                    foreach ($row as $key => $value) {
                        if ($value === '1' || $value === 1) {
                            $row[$key] = 1;
                        } elseif ($value === '0' || $value === 0) {
                            $row[$key] = 0;
                        }
                    }
                    
                    $stmt->execute($row);
                }
                
                echo "✓ Inserted " . count($data) . " records\n";
            }
        } else {
            echo "⚠ No data to migrate for $tableName\n";
        }
    }
    
    echo "\n=== Migration completed successfully! ===\n";
    echo "All data has been migrated from SQLite to MySQL database '$mysqlDatabase'\n";
    
    // Verify migration
    echo "\nVerifying migration...\n";
    $mysql->exec("USE `$mysqlDatabase`");
    $mysqlTables = $mysql->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "MySQL tables: " . implode(', ', $mysqlTables) . "\n";
    
    foreach ($mysqlTables as $table) {
        $count = $mysql->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "- $table: $count records\n";
    }
    
} catch (Exception $e) {
    echo "Error during migration: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
