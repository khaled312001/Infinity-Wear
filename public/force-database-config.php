<?php
/**
 * Force Database Config - Web Interface
 * Forces Laravel to use the correct database configuration
 */

// Security check
$allowedIPs = ['127.0.0.1', '::1', '45.241.19.29'];
$clientIP = $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'unknown';

if (!in_array($clientIP, $allowedIPs) && !str_contains($_SERVER['HTTP_HOST'] ?? '', 'infinitywearsa.com')) {
    http_response_code(403);
    die('Access denied.');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Force Database Config - Infinity Wear</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #e67e22; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .success { background: #27ae60; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { background: #e74c3c; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #f39c12; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { background: #3498db; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        button { background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }
        button:hover { background: #2980b9; }
        .danger { background: #e74c3c; }
        .danger:hover { background: #c0392b; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .critical { background: #dc3545; color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💪 Force Database Config</h1>
            <p>Force Laravel to use the correct database configuration</p>
        </div>

        <?php
        $action = $_POST['action'] ?? '';
        
        if ($action === 'force_config') {
            echo "<div class='info'>💪 Forcing database configuration...</div>";
            
            // Step 1: Override the database configuration directly
            echo "<h3>🔧 Overriding Database Configuration</h3>";
            
            $forcedDatabaseConfig = '<?php

use Illuminate\Support\Str;

return [

    \'default\' => \'mysql\',

    \'connections\' => [

        \'mysql\' => [
            \'driver\' => \'mysql\',
            \'host\' => \'127.0.0.1\',
            \'port\' => \'3306\',
            \'database\' => \'infinity_new\',
            \'username\' => \'infinity_lv424\',
            \'password\' => \'L1wSJR0tw80e\',
            \'unix_socket\' => \'\',
            \'charset\' => \'utf8mb4\',
            \'collation\' => \'utf8mb4_unicode_ci\',
            \'prefix\' => \'\',
            \'prefix_indexes\' => true,
            \'strict\' => true,
            \'engine\' => null,
            \'options\' => [],
        ],

    ],

    \'migrations\' => [
        \'table\' => \'migrations\',
        \'update_date_on_publish\' => true,
    ],

    \'redis\' => [
        \'client\' => \'phpredis\',
        \'options\' => [
            \'cluster\' => \'redis\',
            \'prefix\' => \'infinity_wear_cache\',
            \'persistent\' => false,
        ],
        \'default\' => [
            \'host\' => \'127.0.0.1\',
            \'username\' => null,
            \'password\' => null,
            \'port\' => \'6379\',
            \'database\' => \'0\',
        ],
    ],

];
';

            if (file_put_contents('../config/database.php', $forcedDatabaseConfig)) {
                echo "<div class='success'>✅ Forced database configuration with hardcoded credentials</div>";
            } else {
                echo "<div class='error'>❌ Failed to force database configuration</div>";
            }

            // Step 2: Create a custom index.php that forces the configuration
            echo "<h3>📝 Creating Custom Index.php</h3>";
            
            $customIndex = '<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define(\'LARAVEL_START\', microtime(true));

// Force database configuration
$databaseConfig = [
    \'default\' => \'mysql\',
    \'connections\' => [
        \'mysql\' => [
            \'driver\' => \'mysql\',
            \'host\' => \'127.0.0.1\',
            \'port\' => \'3306\',
            \'database\' => \'infinity_new\',
            \'username\' => \'infinity_lv424\',
            \'password\' => \'L1wSJR0tw80e\',
            \'charset\' => \'utf8mb4\',
            \'collation\' => \'utf8mb4_unicode_ci\',
        ],
    ],
];

// Write the forced configuration
file_put_contents(__DIR__.\'/../config/database.php\', \'<?php return \' . var_export($databaseConfig, true) . \';\');

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.\'/../storage/framework/maintenance.php\')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.\'/../vendor/autoload.php\';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.\'/../bootstrap/app.php\')
    ->handleRequest(Request::capture());
';

            if (file_put_contents('../index.php', $customIndex)) {
                echo "<div class='success'>✅ Created custom index.php with forced database config</div>";
            } else {
                echo "<div class='error'>❌ Failed to create custom index.php</div>";
            }

            // Step 3: Create a database service provider that forces the configuration
            echo "<h3>🔧 Creating Database Service Provider</h3>";
            
            $dbServiceProvider = '<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\MySqlConnection;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\'db\', function ($app) {
            return new \Illuminate\Database\DatabaseManager($app, $app[\'db.factory\']);
        });

        $this->app->singleton(\'db.factory\', function ($app) {
            return new \Illuminate\Database\Connectors\ConnectionFactory($app);
        });

        // Force MySQL connection with correct credentials
        $this->app->singleton(\'db.connection.mysql\', function ($app) {
            $config = [
                \'driver\' => \'mysql\',
                \'host\' => \'127.0.0.1\',
                \'port\' => \'3306\',
                \'database\' => \'infinity_new\',
                \'username\' => \'infinity_lv424\',
                \'password\' => \'L1wSJR0tw80e\',
                \'charset\' => \'utf8mb4\',
                \'collation\' => \'utf8mb4_unicode_ci\',
            ];

            $connector = new MySqlConnector();
            $pdo = $connector->connect($config);
            
            return new MySqlConnection($pdo, $config[\'database\'], $config[\'prefix\'] ?? \'\', $config);
        });
    }

    public function boot()
    {
        //
    }
}
';

            if (file_put_contents('../app/Providers/DatabaseServiceProvider.php', $dbServiceProvider)) {
                echo "<div class='success'>✅ Created DatabaseServiceProvider with forced configuration</div>";
            } else {
                echo "<div class='error'>❌ Failed to create DatabaseServiceProvider</div>";
            }

            // Step 4: Test the forced configuration
            echo "<h3>🧪 Testing Forced Configuration</h3>";
            
            try {
                // Test direct MySQL connection first
                $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=infinity_new', 'infinity_lv424', 'L1wSJR0tw80e');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "<div class='success'>✅ Direct MySQL connection successful</div>";
                
                // Test Laravel connection
                if (file_exists('../vendor/autoload.php')) {
                    require_once '../vendor/autoload.php';
                    echo "<div class='success'>✅ Autoloader loaded</div>";
                }
                
                if (file_exists('../bootstrap/app.php')) {
                    $app = require_once '../bootstrap/app.php';
                    echo "<div class='success'>✅ Bootstrap loaded</div>";
                    
                    // Bootstrap the application
                    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
                    $kernel->bootstrap();
                    echo "<div class='success'>✅ Laravel kernel bootstrapped</div>";
                    
                    // Test database connection
                    $pdo = DB::connection()->getPdo();
                    echo "<div class='success'>✅ Laravel database connection successful!</div>";
                    echo "<div class='info'>📊 Connected to: " . DB::connection()->getDatabaseName() . "</div>";
                    echo "<div class='info'>👤 Using user: infinity_lv424</div>";
                    
                    // Test a simple query
                    $result = DB::select('SELECT 1 as test');
                    echo "<div class='success'>✅ Laravel database queries working</div>";
                    
                    echo "<div class='success'>";
                    echo "<h3>🎉 Forced Database Config Successful!</h3>";
                    echo "<p>✅ Database configuration forced with hardcoded credentials</p>";
                    echo "<p>✅ Custom index.php created</p>";
                    echo "<p>✅ DatabaseServiceProvider created</p>";
                    echo "<p>✅ Laravel can now connect to database properly</p>";
                    echo "<p>🌐 Your website should now work at: <a href='https://infinitywearsa.com' target='_blank' style='color: white;'>https://infinitywearsa.com</a></p>";
                    echo "</div>";
                    
                } else {
                    echo "<div class='error'>❌ Bootstrap file not found</div>";
                }
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Database connection failed: " . $e->getMessage() . "</div>";
                echo "<div class='warning'>The issue persists. You may need to contact your hosting provider.</div>";
            }

        } else {
            // Show initial form
            ?>
            <div class="critical">
                <h3>🚨 PERSISTENT DATABASE ISSUE</h3>
                <p>Your website is still showing this error:</p>
                <pre>SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'</pre>
                <p>Even though we've created all configuration files, Laravel is still using the wrong credentials.</p>
            </div>

            <div class="info">
                <h3>💪 What This Force Fix Will Do</h3>
                <ol>
                    <li><strong>Override database configuration</strong> - Force hardcoded credentials</li>
                    <li><strong>Create custom index.php</strong> - Override the entry point</li>
                    <li><strong>Create DatabaseServiceProvider</strong> - Force database connection</li>
                    <li><strong>Test forced configuration</strong> - Verify everything works</li>
                </ol>
            </div>

            <div class="warning">
                <h3>⚠️ Why Previous Fixes Failed</h3>
                <p>Laravel is still using cached or default configuration despite our fixes. This force fix will:</p>
                <ul>
                    <li>Hardcode the database credentials directly in the config</li>
                    <li>Override the entry point to force the configuration</li>
                    <li>Create a service provider that forces the database connection</li>
                </ul>
            </div>

            <form method="post">
                <input type="hidden" name="action" value="force_config">
                <button type="submit" class="danger">💪 Force Database Configuration</button>
            </form>

            <div class="info">
                <h4>📝 Alternative Tools</h4>
                <p><a href="create-missing-configs.php" style="color: white; text-decoration: underline;">🔧 Create Missing Configs</a> - Previous attempt</p>
                <p><a href="check-status.php" style="color: white; text-decoration: underline;">🔍 Check Status</a> - View current status</p>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
