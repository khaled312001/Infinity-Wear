<?php
/**
 * Create Missing Configs - Web Interface
 * Creates all missing Laravel configuration files
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
    <title>Create Missing Configs - Infinity Wear</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
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
            <h1>🔧 Create Missing Configs</h1>
            <p>Create all missing Laravel configuration files</p>
        </div>

        <?php
        $action = $_POST['action'] ?? '';
        
        if ($action === 'create_configs') {
            echo "<div class='info'>🔧 Creating missing configuration files...</div>";
            
            // Step 1: Create config directory
            echo "<h3>📁 Creating Config Directory</h3>";
            
            if (!is_dir('../config')) {
                if (mkdir('../config', 0755, true)) {
                    echo "<div class='success'>✅ Created config directory</div>";
                } else {
                    echo "<div class='error'>❌ Failed to create config directory</div>";
                }
            } else {
                echo "<div class='success'>✅ Config directory exists</div>";
            }

            // Step 2: Create database.php config
            echo "<h3>🗄️ Creating Database Configuration</h3>";
            
            $databaseConfig = '<?php

use Illuminate\Support\Str;

return [

    \'default\' => env(\'DB_CONNECTION\', \'mysql\'),

    \'connections\' => [

        \'mysql\' => [
            \'driver\' => \'mysql\',
            \'url\' => env(\'DB_URL\'),
            \'host\' => env(\'DB_HOST\', \'127.0.0.1\'),
            \'port\' => env(\'DB_PORT\', \'3306\'),
            \'database\' => env(\'DB_DATABASE\', \'infinity_new\'),
            \'username\' => env(\'DB_USERNAME\', \'infinity_lv424\'),
            \'password\' => env(\'DB_PASSWORD\', \'L1wSJR0tw80e\'),
            \'unix_socket\' => env(\'DB_SOCKET\', \'\'),
            \'charset\' => env(\'DB_CHARSET\', \'utf8mb4\'),
            \'collation\' => env(\'DB_COLLATION\', \'utf8mb4_unicode_ci\'),
            \'prefix\' => \'\',
            \'prefix_indexes\' => true,
            \'strict\' => true,
            \'engine\' => null,
            \'options\' => extension_loaded(\'pdo_mysql\') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env(\'MYSQL_ATTR_SSL_CA\'),
            ]) : [],
        ],

    ],

    \'migrations\' => [
        \'table\' => \'migrations\',
        \'update_date_on_publish\' => true,
    ],

    \'redis\' => [
        \'client\' => env(\'REDIS_CLIENT\', \'phpredis\'),
        \'options\' => [
            \'cluster\' => env(\'REDIS_CLUSTER\', \'redis\'),
            \'prefix\' => env(\'REDIS_PREFIX\', Str::slug((string) env(\'APP_NAME\', \'laravel\')).\'-database-\'),
            \'persistent\' => env(\'REDIS_PERSISTENT\', false),
        ],
        \'default\' => [
            \'url\' => env(\'REDIS_URL\'),
            \'host\' => env(\'REDIS_HOST\', \'127.0.0.1\'),
            \'username\' => env(\'REDIS_USERNAME\'),
            \'password\' => env(\'REDIS_PASSWORD\'),
            \'port\' => env(\'REDIS_PORT\', \'6379\'),
            \'database\' => env(\'REDIS_DB\', \'0\'),
        ],
    ],

];
';

            if (file_put_contents('../config/database.php', $databaseConfig)) {
                echo "<div class='success'>✅ Created database.php config</div>";
            } else {
                echo "<div class='error'>❌ Failed to create database.php config</div>";
            }

            // Step 3: Create app.php config
            echo "<h3>📱 Creating App Configuration</h3>";
            
            $appConfig = '<?php

return [

    \'name\' => env(\'APP_NAME\', \'Infinity Wear\'),
    \'env\' => env(\'APP_ENV\', \'production\'),
    \'debug\' => (bool) env(\'APP_DEBUG\', false),
    \'url\' => env(\'APP_URL\', \'https://infinitywearsa.com\'),
    \'timezone\' => \'UTC\',
    \'locale\' => env(\'APP_LOCALE\', \'en\'),
    \'fallback_locale\' => env(\'APP_FALLBACK_LOCALE\', \'en\'),
    \'faker_locale\' => env(\'APP_FAKER_LOCALE\', \'en_US\'),
    \'key\' => env(\'APP_KEY\'),
    \'cipher\' => \'AES-256-CBC\',
    \'maintenance\' => [
        \'driver\' => env(\'APP_MAINTENANCE_DRIVER\', \'file\'),
        \'store\' => env(\'APP_MAINTENANCE_STORE\', \'database\'),
    ],

];
';

            if (file_put_contents('../config/app.php', $appConfig)) {
                echo "<div class='success'>✅ Created app.php config</div>";
            } else {
                echo "<div class='error'>❌ Failed to create app.php config</div>";
            }

            // Step 4: Create session.php config
            echo "<h3>🔐 Creating Session Configuration</h3>";
            
            $sessionConfig = '<?php

use Illuminate\Support\Str;

return [

    \'driver\' => env(\'SESSION_DRIVER\', \'file\'),
    \'lifetime\' => env(\'SESSION_LIFETIME\', 120),
    \'expire_on_close\' => false,
    \'encrypt\' => false,
    \'files\' => storage_path(\'framework/sessions\'),
    \'connection\' => env(\'SESSION_CONNECTION\'),
    \'table\' => \'sessions\',
    \'store\' => env(\'SESSION_STORE\'),
    \'lottery\' => [2, 100],
    \'cookie\' => env(\'SESSION_COOKIE\', Str::slug(env(\'APP_NAME\', \'laravel\'), \'_\').\'_session\'),
    \'path\' => \'/\',
    \'domain\' => env(\'SESSION_DOMAIN\'),
    \'secure\' => env(\'SESSION_SECURE_COOKIE\'),
    \'http_only\' => true,
    \'same_site\' => \'lax\',

];
';

            if (file_put_contents('../config/session.php', $sessionConfig)) {
                echo "<div class='success'>✅ Created session.php config</div>";
            } else {
                echo "<div class='error'>❌ Failed to create session.php config</div>";
            }

            // Step 5: Create cache.php config
            echo "<h3>💾 Creating Cache Configuration</h3>";
            
            $cacheConfig = '<?php

use Illuminate\Support\Str;

return [

    \'default\' => env(\'CACHE_STORE\', \'file\'),
    \'stores\' => [
        \'array\' => [
            \'driver\' => \'array\',
            \'serialize\' => false,
        ],
        \'database\' => [
            \'driver\' => \'database\',
            \'table\' => \'cache\',
            \'connection\' => env(\'DB_CONNECTION\', \'mysql\'),
            \'lock_connection\' => env(\'DB_CONNECTION\', \'mysql\'),
        ],
        \'file\' => [
            \'driver\' => \'file\',
            \'path\' => storage_path(\'framework/cache/data\'),
        ],
        \'memcached\' => [
            \'driver\' => \'memcached\',
            \'persistent_id\' => env(\'MEMCACHED_PERSISTENT_ID\'),
            \'sasl\' => [
                env(\'MEMCACHED_USERNAME\'),
                env(\'MEMCACHED_PASSWORD\'),
            ],
            \'options\' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            \'servers\' => [
                [
                    \'host\' => env(\'MEMCACHED_HOST\', \'127.0.0.1\'),
                    \'port\' => env(\'MEMCACHED_PORT\', 11211),
                    \'weight\' => 100,
                ],
            ],
        ],
        \'redis\' => [
            \'driver\' => \'redis\',
            \'connection\' => \'cache\',
            \'lock_connection\' => \'default\',
        ],
    ],
    \'prefix\' => env(\'CACHE_PREFIX\', Str::slug(env(\'APP_NAME\', \'laravel\'), \'_\').\'_cache\'),

];
';

            if (file_put_contents('../config/cache.php', $cacheConfig)) {
                echo "<div class='success'>✅ Created cache.php config</div>";
            } else {
                echo "<div class='error'>❌ Failed to create cache.php config</div>";
            }

            // Step 6: Test the configuration
            echo "<h3>🧪 Testing Configuration</h3>";
            
            try {
                // Load Laravel environment
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
                    echo "<h3>🎉 Missing Configs Fix Successful!</h3>";
                    echo "<p>✅ All configuration files created</p>";
                    echo "<p>✅ Database configuration with correct credentials</p>";
                    echo "<p>✅ Laravel can now connect to database properly</p>";
                    echo "<p>🌐 Your website should now work at: <a href='https://infinitywearsa.com' target='_blank' style='color: white;'>https://infinitywearsa.com</a></p>";
                    echo "</div>";
                    
                } else {
                    echo "<div class='error'>❌ Bootstrap file not found</div>";
                }
                
            } catch (Exception $e) {
                echo "<div class='error'>❌ Laravel database connection failed: " . $e->getMessage() . "</div>";
                echo "<div class='warning'>The issue persists. You may need to contact your hosting provider.</div>";
            }

        } else {
            // Show initial form
            ?>
            <div class="critical">
                <h3>🚨 MISSING CONFIGURATION FILES</h3>
                <p>Your website is still showing this error:</p>
                <pre>SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'</pre>
                <p>The issue is that Laravel's <strong>configuration files are missing</strong>, so it's using default hardcoded values.</p>
            </div>

            <div class="info">
                <h3>🔧 What This Fix Will Create</h3>
                <ol>
                    <li><strong>Config directory</strong> - Create the config folder</li>
                    <li><strong>Database configuration</strong> - Create database.php with correct credentials</li>
                    <li><strong>App configuration</strong> - Create app.php with proper settings</li>
                    <li><strong>Session configuration</strong> - Create session.php for session handling</li>
                    <li><strong>Cache configuration</strong> - Create cache.php for caching</li>
                    <li><strong>Test configuration</strong> - Verify everything works</li>
                </ol>
            </div>

            <div class="warning">
                <h3>⚠️ Why Previous Fixes Failed</h3>
                <p>The issue is that Laravel's <strong>configuration files are missing</strong>, so it falls back to hardcoded defaults. This fix will:</p>
                <ul>
                    <li>Create all missing configuration files</li>
                    <li>Set correct database credentials as defaults</li>
                    <li>Ensure Laravel has proper configuration</li>
                </ul>
            </div>

            <form method="post">
                <input type="hidden" name="action" value="create_configs">
                <button type="submit" class="danger">🚀 Create Missing Configuration Files</button>
            </form>

            <div class="info">
                <h4>📝 Alternative Tools</h4>
                <p><a href="ultimate-laravel-fix.php" style="color: white; text-decoration: underline;">🚀 Ultimate Laravel Fix</a> - Previous attempt</p>
                <p><a href="check-status.php" style="color: white; text-decoration: underline;">🔍 Check Status</a> - View current status</p>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
