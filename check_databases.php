<?php
/**
 * Check Databases Script
 * This script shows all available databases and their contents
 */

// Database configurations
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';
$mysqlUsername = 'root';
$mysqlPassword = '';

echo "=== Database Status Check ===\n";

try {
    // Connect to MySQL
    $mysql = new PDO("mysql:host=$mysqlHost;port=$mysqlPort", $mysqlUsername, $mysqlPassword);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ MySQL connection successful\n\n";

    // Get all databases
    $databases = $mysql->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Available databases:\n";
    foreach ($databases as $db) {
        if (strpos($db, 'infinity') !== false) {
            echo "- $db\n";
        }
    }
    
    echo "\n=== Checking infinity_final_complete ===\n";
    try {
        $mysql->exec("USE `infinity_final_complete`");
        $tables = $mysql->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables in infinity_final_complete: " . count($tables) . "\n";
        
        $totalRecords = 0;
        foreach ($tables as $table) {
            $count = $mysql->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
            $totalRecords += $count;
            if ($count > 0) {
                echo "- $table: $count records\n";
            }
        }
        echo "Total records: $totalRecords\n";
    } catch (Exception $e) {
        echo "❌ Error accessing infinity_final_complete: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== Checking infinity_final ===\n";
    try {
        $mysql->exec("USE `infinity_final`");
        $tables = $mysql->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables in infinity_final: " . count($tables) . "\n";
        
        $totalRecords = 0;
        foreach ($tables as $table) {
            $count = $mysql->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
            $totalRecords += $count;
            if ($count > 0) {
                echo "- $table: $count records\n";
            }
        }
        echo "Total records: $totalRecords\n";
    } catch (Exception $e) {
        echo "❌ Error accessing infinity_final: " . $e->getMessage() . "\n";
    }
    
    echo "\n✅ Database check completed!\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
