<?php
/**
 * Rename Database Script
 * This script renames infinity_final_complete to infinity_final
 */

// Database configurations
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';
$mysqlUsername = 'root';
$mysqlPassword = '';

echo "=== Renaming Database ===\n";

try {
    // Connect to MySQL
    $mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort", $mysqlUsername, $mysqlPassword);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ MySQL connection successful\n";

    // Drop old infinity_final if exists
    echo "Dropping old infinity_final database...\n";
    $mysql->exec("DROP DATABASE IF EXISTS `infinity_final`");
    echo "✓ Old database dropped\n";

    // Rename infinity_final_complete to infinity_final
    echo "Renaming infinity_final_complete to infinity_final...\n";
    $mysql->exec("CREATE DATABASE `infinity_final` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ New infinity_final database created\n";

    // Copy all data from infinity_final_complete to infinity_final
    echo "Copying data...\n";
    
    // Connect to source database
    $source = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=infinity_final_complete", $mysqlUsername, $mysqlPassword);
    $source->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Connect to target database
    $target = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=infinity_final", $mysqlUsername, $mysqlPassword);
    $target->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get all tables from source
    $tables = $source->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Found " . count($tables) . " tables to copy\n";

    $totalRecords = 0;

    foreach ($tables as $tableName) {
        echo "Copying table: $tableName...\n";
        
        // Get table structure
        $createTableSQL = $source->query("SHOW CREATE TABLE `$tableName`")->fetch(PDO::FETCH_ASSOC);
        $createSQL = $createTableSQL['Create Table'];
        
        // Create table in target database
        $target->exec($createSQL);
        
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
            
            $totalRecords += $recordCount;
        }
    }
    
    // Drop source database
    echo "Dropping source database...\n";
    $mysql->exec("DROP DATABASE `infinity_final_complete`");
    echo "✓ Source database dropped\n";
    
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
    
    echo "\n✅ Database renamed successfully!\n";
    echo "infinity_final database is ready with all migrated data\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
