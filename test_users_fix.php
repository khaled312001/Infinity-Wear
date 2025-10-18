<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing users array fix...\n\n";

// Test marketing user authentication
try {
    $authResult = \Illuminate\Support\Facades\Auth::attempt([
        'email' => 'marketing@infinitywear.sa',
        'password' => 'marketing123'
    ]);
    
    if ($authResult) {
        echo "✅ Marketing user authenticated successfully\n";
        
        $user = \Illuminate\Support\Facades\Auth::user();
        echo "User: {$user->name} ({$user->email})\n";
        echo "User type: {$user->user_type}\n";
        
        // Test marketing tasks controller
        echo "\nTesting marketing tasks controller...\n";
        try {
            $controller = new \App\Http\Controllers\Marketing\TaskController();
            $request = \Illuminate\Http\Request::create('/marketing/tasks', 'GET');
            $response = $controller->index();
            
            if ($response instanceof \Illuminate\View\View) {
                $data = $response->getData();
                $users = $data['users'];
                
                echo "✅ Controller executed successfully\n";
                echo "Users type: " . gettype($users) . "\n";
                
                if (is_array($users)) {
                    echo "✅ Users is an array\n";
                    echo "Users keys: " . implode(', ', array_keys($users)) . "\n";
                    
                    // Check if required keys exist
                    $requiredKeys = ['admins', 'marketing', 'sales'];
                    $missingKeys = array_diff($requiredKeys, array_keys($users));
                    
                    if (empty($missingKeys)) {
                        echo "✅ All required user keys are present\n";
                        echo "Admins count: " . count($users['admins']) . "\n";
                        echo "Marketing count: " . count($users['marketing']) . "\n";
                        echo "Sales count: " . count($users['sales']) . "\n";
                    } else {
                        echo "❌ Missing user keys: " . implode(', ', $missingKeys) . "\n";
                    }
                } else {
                    echo "❌ Users is not an array: " . gettype($users) . "\n";
                }
                
            } else {
                echo "❌ Controller did not return a view\n";
            }
            
        } catch (Exception $e) {
            echo "❌ Controller error: " . $e->getMessage() . "\n";
        }
        
    } else {
        echo "❌ Marketing user authentication failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Authentication error: " . $e->getMessage() . "\n";
}

\Illuminate\Support\Facades\Auth::logout();
echo "\nTest completed.\n";
