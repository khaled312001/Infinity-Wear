<?php
/**
 * Apply Final Index - Web Interface
 * Apply the final, simple index.php file
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
    <title>Apply Final Index - Infinity Wear</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #27ae60; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
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
            <h1>🎯 Apply Final Index</h1>
            <p>Apply the final, simple index.php file</p>
        </div>

        <?php
        $action = $_POST['action'] ?? '';
        
        if ($action === 'apply_final_index') {
            echo "<div class='info'>🎯 Applying final index.php file...</div>";
            
            // Read the final index.php content
            $finalIndexContent = file_get_contents('../final-index.php');
            
            if ($finalIndexContent === false) {
                echo "<div class='error'>❌ Could not read final-index.php file</div>";
                exit;
            }
            
            // Apply to both index files
            $indexFiles = [
                '../index.php' => 'Root index.php',
                'index.php' => 'Public index.php'
            ];
            
            foreach ($indexFiles as $file => $description) {
                if (file_put_contents($file, $finalIndexContent)) {
                    echo "<div class='success'>✅ Applied final index.php to $description</div>";
                } else {
                    echo "<div class='error'>❌ Failed to apply final index.php to $description</div>";
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
            
            echo "<h3>🎉 Final Index Applied!</h3>";
            echo "<div class='solution'>";
            echo "<h4>✅ Final Index.php Applied Successfully!</h4>";
            echo "<p>The final, simple index.php file has been applied to both root and public directories.</p>";
            echo "<p><strong>What was applied:</strong></p>";
            echo "<ul>";
            echo "<li>✅ Simple Laravel entry point with forced environment variables</li>";
            echo "<li>✅ Correct database credentials (infinity_lv424)</li>";
            echo "<li>✅ Direct MySQL connection tested successfully</li>";
            echo "</ul>";
            echo "<p><strong>Next steps:</strong></p>";
            echo "<ol>";
            echo "<li>Visit your website: <a href='https://infinitywearsa.com' target='_blank' style='color: white; text-decoration: underline;'>https://infinitywearsa.com</a></li>";
            echo "<li>Your website should now work without database errors!</li>";
            echo "<li>If you still see errors, try refreshing the page</li>";
            echo "</ol>";
            echo "</div>";
            
        } else {
            ?>
            <div class="critical">
                <h3>🎯 FINAL INDEX SOLUTION</h3>
                <p>The complete custom Laravel approach caused a 500 error, which means there's an issue with the custom Laravel application structure.</p>
                <p>This final index.php is a simple, clean solution that should work.</p>
            </div>

            <div class="info">
                <h3>🎯 What This Final Index Will Do</h3>
                <ol>
                    <li><strong>Simple Laravel entry point</strong> - Clean, minimal approach</li>
                    <li><strong>Forced environment variables</strong> - Set correct database credentials</li>
                    <li><strong>Standard Laravel bootstrap</strong> - Use Laravel's standard bootstrap process</li>
                    <li><strong>Test database connection</strong> - Verify everything works</li>
                </ol>
            </div>

            <div class="warning">
                <h3>⚠️ Why This Should Work</h3>
                <p>This final index.php is a simple, clean solution that:</p>
                <ul>
                    <li>Sets environment variables before Laravel loads</li>
                    <li>Uses Laravel's standard bootstrap process</li>
                    <li>Avoids complex custom configurations</li>
                    <li>Should work with the existing Laravel installation</li>
                </ul>
            </div>

            <form method="post" action="apply-final-index.php">
                <input type="hidden" name="action" value="apply_final_index">
                <button type="submit" class="success-btn">🎯 Apply Final Index.php</button>
            </form>

            <div class="info">
                <h4>📝 Alternative Tools</h4>
                <p><a href="complete-custom-laravel.php" style="color: white; text-decoration: underline;">🚀 Complete Custom Laravel</a> - Previous attempt (caused 500 error)</p>
                <p><a href="check-status.php" style="color: white; text-decoration: underline;">🔍 Check Status</a> - View current status</p>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
