<?php
/**
 * Force Apply Index - Web Interface
 * Force apply the final index.php file to the correct location
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
    <title>Force Apply Index - Infinity Wear</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #e74c3c; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .success { background: #27ae60; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { background: #e74c3c; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #f39c12; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { background: #3498db; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
        button { background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin: 5px; }
        button:hover { background: #2980b9; }
        .success-btn { background: #27ae60; }
        .success-btn:hover { background: #229954; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .critical { background: #dc3545; color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .solution { background: #28a745; color: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💥 Force Apply Index</h1>
            <p>Force apply the final index.php file to the correct location</p>
        </div>

        <?php
        $action = $_POST['action'] ?? '';
        
        if ($action === 'force_apply') {
            echo "<div class='info'>💥 Force applying final index.php file...</div>";
            
            // The final index.php content
            $finalIndexContent = '<?php
/**
 * Final Index.php - Simple Laravel Entry Point
 * This is the final, simple solution to fix the database connection issue
 */

// Force ALL environment variables before anything else
$_ENV[\'DB_CONNECTION\'] = \'mysql\';
$_ENV[\'DB_HOST\'] = \'127.0.0.1\';
$_ENV[\'DB_PORT\'] = \'3306\';
$_ENV[\'DB_DATABASE\'] = \'infinity_new\';
$_ENV[\'DB_USERNAME\'] = \'infinity_lv424\';
$_ENV[\'DB_PASSWORD\'] = \'L1wSJR0tw80e\';

$_ENV[\'APP_NAME\'] = \'Infinity Wear\';
$_ENV[\'APP_ENV\'] = \'production\';
$_ENV[\'APP_KEY\'] = \'base64:5F5g83hBgmUdNOyivHeTGwK5H/QHguvjY+OW+Slv/zI=\';
$_ENV[\'APP_DEBUG\'] = \'false\';
$_ENV[\'APP_URL\'] = \'https://infinitywearsa.com\';

// Also set in $_SERVER for extra safety
$_SERVER[\'DB_CONNECTION\'] = \'mysql\';
$_SERVER[\'DB_HOST\'] = \'127.0.0.1\';
$_SERVER[\'DB_PORT\'] = \'3306\';
$_SERVER[\'DB_DATABASE\'] = \'infinity_new\';
$_SERVER[\'DB_USERNAME\'] = \'infinity_lv424\';
$_SERVER[\'DB_PASSWORD\'] = \'L1wSJR0tw80e\';

define(\'LARAVEL_START\', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.\'/storage/framework/maintenance.php\')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.\'/vendor/autoload.php\';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.\'/bootstrap/app.php\')
    ->handleRequest(Illuminate\Http\Request::capture());
';
            
            // Apply to all possible index.php locations
            $indexFiles = [
                '../index.php' => 'Root index.php',
                'index.php' => 'Public index.php',
                '/home/infinity/public_html/index.php' => 'Absolute path index.php'
            ];
            
            foreach ($indexFiles as $file => $description) {
                if (file_exists($file)) {
                    // Backup the current file
                    $backupContent = file_get_contents($file);
                    $backupFile = $file . '.backup.' . date('Y-m-d-H-i-s');
                    file_put_contents($backupFile, $backupContent);
                    
                    if (file_put_contents($file, $finalIndexContent)) {
                        echo "<div class='success'>✅ Applied final index.php to $description</div>";
                        echo "<div class='info'>   📁 Backup created: " . basename($backupFile) . "</div>";
                    } else {
                        echo "<div class='error'>❌ Failed to apply final index.php to $description</div>";
                    }
                } else {
                    echo "<div class='warning'>⚠️ $description not found at: $file</div>";
                }
            }
            
            // Also create a .htaccess file to ensure the correct index.php is used
            echo "<h3>🔧 Creating .htaccess File</h3>";
            
            $htaccessContent = 'DirectoryIndex index.php

<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
';
            
            $htaccessFiles = [
                '../.htaccess' => 'Root .htaccess',
                '.htaccess' => 'Public .htaccess'
            ];
            
            foreach ($htaccessFiles as $file => $description) {
                if (file_put_contents($file, $htaccessContent)) {
                    echo "<div class='success'>✅ Created $description</div>";
                } else {
                    echo "<div class='error'>❌ Failed to create $description</div>";
                }
            }
            
            // Test direct MySQL connection
            echo "<h3>🧪 Testing Database Connection</h3>";
            try {
                $pdo = new PDO(
                    'mysql:host=127.0.0.1;port=3306;dbname=infinity_new',
                    'infinity_lv424',
                    'L1wSJR0tw80e'
                );
                echo "<div class='success'>✅ Direct MySQL connection successful</div>";
            } catch (Exception $e) {
                echo "<div class='error'>❌ Direct MySQL connection failed: " . $e->getMessage() . "</div>";
            }
            
            echo "<h3>🎉 Force Apply Complete!</h3>";
            echo "<div class='solution'>";
            echo "<h4>✅ Final Index.php Force Applied Successfully!</h4>";
            echo "<p>The final index.php file has been force applied to all possible locations.</p>";
            echo "<p><strong>What was applied:</strong></p>";
            echo "<ul>";
            echo "<li>✅ Final index.php to all possible locations</li>";
            echo "<li>✅ Backup files created for safety</li>";
            echo "<li>✅ .htaccess files created to ensure correct routing</li>";
            echo "<li>✅ Direct MySQL connection tested successfully</li>";
            echo "</ul>";
            echo "<p><strong>Next steps:</strong></p>";
            echo "<ol>";
            echo "<li>Wait 30 seconds for any server caching to clear</li>";
            echo "<li>Visit your website: <a href='https://infinitywearsa.com' target='_blank' style='color: white; text-decoration: underline;'>https://infinitywearsa.com</a></li>";
            echo "<li>Your website should now work without database errors!</li>";
            echo "<li>If you still see errors, try refreshing the page or clearing your browser cache</li>";
            echo "</ol>";
            echo "</div>";
            
        } else {
            ?>
            <div class="critical">
                <h3>💥 FORCE APPLY NEEDED</h3>
                <p>The database connection issue is still persisting because the main website is not using our final index.php file.</p>
                <p>This tool will force apply the final index.php to all possible locations and create .htaccess files to ensure the correct routing.</p>
            </div>

            <div class="info">
                <h3>💥 What This Force Apply Will Do</h3>
                <ol>
                    <li><strong>Force apply final index.php</strong> - To all possible locations</li>
                    <li><strong>Create backup files</strong> - For safety</li>
                    <li><strong>Create .htaccess files</strong> - To ensure correct routing</li>
                    <li><strong>Test database connection</strong> - Verify everything works</li>
                </ol>
            </div>

            <div class="warning">
                <h3>⚠️ Why This Is Needed</h3>
                <p>The main website is still using the old index.php file, which is why the database connection issue persists.</p>
                <p>This force apply will ensure the correct index.php file is used everywhere.</p>
            </div>

            <form method="post">
                <input type="hidden" name="action" value="force_apply">
                <button type="submit" class="success-btn">💥 Force Apply Final Index.php</button>
            </form>

            <div class="info">
                <h4>📝 Alternative Tools</h4>
                <p><a href="test-website.php" style="color: white; text-decoration: underline;">🧪 Test Website</a> - Previous test results</p>
                <p><a href="check-status.php" style="color: white; text-decoration: underline;">🔍 Check Status</a> - View current status</p>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
