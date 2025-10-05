<?php
/**
 * Diagnose Entry Point - Web Interface
 * Diagnose which entry point is being used and why
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
    <title>Diagnose Entry Point - Infinity Wear</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: #9b59b6; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
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
            <h1>🔍 Diagnose Entry Point</h1>
            <p>Diagnose which entry point is being used and why</p>
        </div>

        <?php
        $action = $_POST['action'] ?? '';
        
        if ($action === 'diagnose') {
            echo "<div class='info'>🔍 Diagnosing entry point issue...</div>";
            
            // Step 1: Check which index.php files exist
            echo "<h3>📁 Checking Index Files</h3>";
            
            $indexFiles = [
                '../index.php' => 'Root index.php',
                'index.php' => 'Public index.php',
                '../public/index.php' => 'Public directory index.php'
            ];
            
            foreach ($indexFiles as $file => $description) {
                if (file_exists($file)) {
                    $size = filesize($file);
                    $modified = date('Y-m-d H:i:s', filemtime($file));
                    echo "<div class='success'>✅ $description exists (Size: $size bytes, Modified: $modified)</div>";
                    
                    // Check if it's our custom index.php
                    $content = file_get_contents($file);
                    if (strpos($content, 'Force database configuration') !== false) {
                        echo "<div class='info'>   📝 This is our custom index.php with forced database config</div>";
                    } else {
                        echo "<div class='warning'>   ⚠️ This is the original index.php</div>";
                    }
                } else {
                    echo "<div class='error'>❌ $description not found</div>";
                }
            }

            // Step 2: Check web server configuration
            echo "<h3>🌐 Web Server Configuration</h3>";
            
            echo "<div class='info'>";
            echo "<strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
            echo "<strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "<br>";
            echo "<strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "<br>";
            echo "<strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
            echo "<strong>Current File:</strong> " . __FILE__ . "<br>";
            echo "</div>";

            // Step 3: Check .htaccess files
            echo "<h3>📄 Checking .htaccess Files</h3>";
            
            $htaccessFiles = [
                '../.htaccess' => 'Root .htaccess',
                '.htaccess' => 'Public .htaccess',
                '../public/.htaccess' => 'Public directory .htaccess'
            ];
            
            foreach ($htaccessFiles as $file => $description) {
                if (file_exists($file)) {
                    $content = file_get_contents($file);
                    echo "<div class='success'>✅ $description exists</div>";
                    echo "<pre>" . htmlspecialchars($content) . "</pre>";
                } else {
                    echo "<div class='warning'>⚠️ $description not found</div>";
                }
            }

            // Step 4: Check if there's a different entry point
            echo "<h3>🔍 Checking for Alternative Entry Points</h3>";
            
            $possibleEntryPoints = [
                '../public/index.php',
                '../index.php',
                'index.php',
                '../app.php',
                '../bootstrap.php'
            ];
            
            foreach ($possibleEntryPoints as $file) {
                if (file_exists($file)) {
                    $content = file_get_contents($file);
                    if (strpos($content, 'Laravel') !== false || strpos($content, 'Illuminate') !== false) {
                        echo "<div class='success'>✅ Found Laravel entry point: $file</div>";
                    }
                }
            }

            // Step 5: Create a test to see which index.php is being used
            echo "<h3>🧪 Testing Entry Point</h3>";
            
            // Create a test file that will show which index.php is being used
            $testContent = '<?php
echo "TEST: This is the public/index.php file being used<br>";
echo "Current working directory: " . getcwd() . "<br>";
echo "Script name: " . $_SERVER["SCRIPT_NAME"] . "<br>";
echo "Request URI: " . $_SERVER["REQUEST_URI"] . "<br>";
echo "Document root: " . $_SERVER["DOCUMENT_ROOT"] . "<br>";
echo "File path: " . __FILE__ . "<br>";
?>';

            if (file_put_contents('test-entry.php', $testContent)) {
                echo "<div class='success'>✅ Created test file: test-entry.php</div>";
                echo "<div class='info'>Visit: <a href='test-entry.php' target='_blank'>test-entry.php</a> to see which entry point is being used</div>";
            }

            // Step 6: Check if the issue is with the web server configuration
            echo "<h3>🔧 Web Server Analysis</h3>";
            
            $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
            
            if (strpos($scriptName, '/public/') !== false) {
                echo "<div class='success'>✅ Web server is correctly pointing to public directory</div>";
            } else {
                echo "<div class='warning'>⚠️ Web server might not be pointing to public directory</div>";
                echo "<div class='info'>Script name: $scriptName</div>";
            }

            // Step 7: Provide solution
            echo "<h3>💡 Solution</h3>";
            
            if (strpos($scriptName, '/public/') === false) {
                echo "<div class='critical'>";
                echo "<h4>🚨 ROOT CAUSE IDENTIFIED</h4>";
                echo "<p>The web server is <strong>NOT</strong> pointing to the public directory!</p>";
                echo "<p>This means it's using the root index.php instead of public/index.php</p>";
                echo "<p><strong>Solution:</strong> Update your web server configuration to point to the public directory</p>";
                echo "</div>";
            } else {
                echo "<div class='info'>";
                echo "<p>The web server is correctly configured. The issue might be elsewhere.</p>";
                echo "</div>";
            }

        } else {
            // Show initial form
            ?>
            <div class="critical">
                <h3>🚨 ENTRY POINT ISSUE</h3>
                <p>The error still shows <code>index.php:25</code> which means it's using the original index.php file, not our custom one.</p>
                <p>This suggests the web server is not using the index.php file we created.</p>
            </div>

            <div class="info">
                <h3>🔍 What This Diagnosis Will Do</h3>
                <ol>
                    <li><strong>Check index files</strong> - See which index.php files exist and which is being used</li>
                    <li><strong>Check web server configuration</strong> - See how the server is configured</li>
                    <li><strong>Check .htaccess files</strong> - See if there are rewrite rules</li>
                    <li><strong>Check alternative entry points</strong> - Look for other Laravel entry points</li>
                    <li><strong>Test entry point</strong> - Create a test to see which file is being used</li>
                    <li><strong>Provide solution</strong> - Identify the root cause and solution</li>
                </ol>
            </div>

            <div class="warning">
                <h3>⚠️ Why Previous Fixes Failed</h3>
                <p>The issue is that the web server is not using the index.php file we created. This diagnosis will:</p>
                <ul>
                    <li>Identify which index.php file is actually being used</li>
                    <li>Check web server configuration</li>
                    <li>Find the root cause of the entry point issue</li>
                </ul>
            </div>

            <form method="post">
                <input type="hidden" name="action" value="diagnose">
                <button type="submit" class="danger">🔍 Diagnose Entry Point Issue</button>
            </form>

            <div class="info">
                <h4>📝 Alternative Tools</h4>
                <p><a href="force-database-config.php" style="color: white; text-decoration: underline;">💪 Force Database Config</a> - Previous attempt</p>
                <p><a href="check-status.php" style="color: white; text-decoration: underline;">🔍 Check Status</a> - View current status</p>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
