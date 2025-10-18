<?php
/**
 * Fix Remaining Tables Migration Script
 * This script handles the remaining tables with default value issues
 */

// Database configurations
$sqliteFile = __DIR__ . '/database/database.sqlite';
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';
$mysqlDatabase = 'infinity_final_v2';
$mysqlUsername = 'root';
$mysqlPassword = '';

echo "=== Fixing Remaining Tables ===\n";
echo "Target Database: $mysqlDatabase\n\n";

try {
    // Connect to SQLite
    $sqlite = new PDO("sqlite:$sqliteFile");
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connect to MySQL
    $mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=$mysqlDatabase", $mysqlUsername, $mysqlPassword);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tables that need fixing
    $problematicTables = [
        'users', 'admins', 'marketing_team', 'sales_team', 'tasks', 
        'portfolio_items', 'testimonials', 'hero_sliders', 'home_sections', 
        'section_contents', 'task_boards'
    ];

    foreach ($problematicTables as $tableName) {
        echo "\n--- Fixing table: $tableName ---\n";
        
        try {
            // Get data from SQLite
            $data = $sqlite->query("SELECT * FROM $tableName")->fetchAll(PDO::FETCH_ASSOC);
            echo "   Records: " . count($data) . "\n";
            
            if (count($data) > 0) {
                // Drop table if exists
                $mysql->exec("DROP TABLE IF EXISTS `$tableName`");
                
                // Get table structure
                $columns = $sqlite->query("PRAGMA table_info($tableName)")->fetchAll(PDO::FETCH_ASSOC);
                
                // Create table without problematic defaults
                $createSQL = "CREATE TABLE `$tableName` (";
                $columnDefs = [];
                
                foreach ($columns as $column) {
                    $name = $column['name'];
                    $type = strtolower($column['type']);
                    $notNull = $column['notnull'];
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
                    } elseif (strpos($type, 'enum') !== false) {
                        $mysqlType = 'VARCHAR(255)';
                    }
                    
                    $columnDef = "`$name` $mysqlType";
                    
                    if ($notNull && $name !== 'id' && $name !== 'created_at' && $name !== 'updated_at') {
                        $columnDef .= ' NOT NULL';
                    }
                    
                    // Add specific defaults for known problematic columns
                    if ($name === 'is_active' || $name === 'is_featured') {
                        $columnDef .= ' DEFAULT 1';
                    } elseif ($name === 'sort_order' || $name === 'position' || $name === 'rating') {
                        $columnDef .= ' DEFAULT 0';
                    }
                    
                    $columnDefs[] = $columnDef;
                }
                
                $createSQL .= implode(', ', $columnDefs) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                $mysql->exec($createSQL);
                echo "   ✓ Table structure created\n";
                
                // Insert data
                $columnNames = array_keys($data[0]);
                $placeholders = ':' . implode(', :', $columnNames);
                $insertSQL = "INSERT INTO `$tableName` (`" . implode('`, `', $columnNames) . "`) VALUES ($placeholders)";
                
                $stmt = $mysql->prepare($insertSQL);
                
                foreach ($data as $row) {
                    // Convert boolean values and handle nulls
                    foreach ($row as $key => $value) {
                        if ($value === '1' || $value === 1) {
                            $row[$key] = 1;
                        } elseif ($value === '0' || $value === 0) {
                            $row[$key] = 0;
                        } elseif ($value === '') {
                            $row[$key] = null;
                        } elseif ($value === 'true') {
                            $row[$key] = 1;
                        } elseif ($value === 'false') {
                            $row[$key] = 0;
                        }
                    }
                    
                    $stmt->execute($row);
                }
                
                echo "   ✓ Inserted " . count($data) . " records\n";
            }
            
        } catch (Exception $e) {
            echo "   ❌ Error fixing $tableName: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== Final Verification ===\n";
    $mysqlTables = $mysql->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Total MySQL tables: " . count($mysqlTables) . "\n";
    
    $totalRecords = 0;
    foreach ($mysqlTables as $table) {
        $count = $mysql->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        $totalRecords += $count;
        if ($count > 0) {
            echo "- $table: $count records\n";
        }
    }
    
    echo "\nTotal records in database: $totalRecords\n";
    echo "\n✅ All tables fixed successfully!\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
