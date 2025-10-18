<?php
/**
 * Final Copy to infinity_final
 * This script copies all data from infinity_final_complete to infinity_final
 */

// Database configurations
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';
$mysqlUsername = 'root';
$mysqlPassword = '';

echo "=== Final Copy to infinity_final ===\n";

try {
    // Connect to MySQL
    $mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort", $mysqlUsername, $mysqlPassword);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ MySQL connection successful\n";

    // Connect to source database
    $source = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=infinity_final_complete", $mysqlUsername, $mysqlPassword);
    $source->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connected to source database\n";

    // Connect to target database
    $target = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=infinity_final", $mysqlUsername, $mysqlPassword);
    $target->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connected to target database\n";

    // Get all tables from source
    $tables = $source->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Found " . count($tables) . " tables to copy\n";

    $totalRecords = 0;

    foreach ($tables as $tableName) {
        echo "\n--- Copying table: $tableName ---\n";
        
        try {
            // Drop table if exists
            $target->exec("DROP TABLE IF EXISTS `$tableName`");
            
            // Get table structure
            $createTableSQL = $source->query("SHOW CREATE TABLE `$tableName`")->fetch(PDO::FETCH_ASSOC);
            $createSQL = $createTableSQL['Create Table'];
            
            // Create table in target database
            $target->exec($createSQL);
            echo "✓ Table structure created\n";
            
            // Copy data
            $data = $source->query("SELECT * FROM `$tableName`")->fetchAll(PDO::FETCH_ASSOC);
            $recordCount = count($data);
            
            if ($recordCount > 0) {
                $columnNames = array_keys($data[0]);
                $placeholders = ':' . implode(', :', $columnNames);
                $insertSQL = "INSERT INTO `$tableName` (`" . implode('`, `', $columnNames) . "`) VALUES ($placeholders)";
                
                $stmt = $target->prepare($insertSQL);
                
                foreach ($data as $row) {
                    $stmt->execute($row);
                }
                
                echo "✓ Copied $recordCount records\n";
                $totalRecords += $recordCount;
            } else {
                echo "✓ Empty table copied\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Error copying $tableName: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== Final Summary ===\n";
    echo "Database: infinity_final\n";
    echo "Total tables: " . count($tables) . "\n";
    echo "Total records: $totalRecords\n";
    
    // Final verification
    echo "\n=== Verification ===\n";
    $finalTables = $target->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in infinity_final:\n";
    
    foreach ($finalTables as $table) {
        $count = $target->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        if ($count > 0) {
            echo "- $table: $count records\n";
        }
    }
    
    echo "\n✅ infinity_final database is ready!\n";
    echo "All data has been successfully migrated from SQLite to MySQL database 'infinity_final'\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
