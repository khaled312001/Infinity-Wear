<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing marketing dashboard routes...\n\n";

// Test if all marketing routes exist
$routes = [
    'marketing.dashboard',
    'marketing.portfolio',
    'marketing.portfolio.create',
    'marketing.testimonials',
    'marketing.testimonials.create',
    'marketing.tasks.index',
    'marketing.contacts',
    'marketing.profile'
];

foreach ($routes as $route) {
    try {
        $url = route($route);
        echo "✅ {$route}: {$url}\n";
    } catch (Exception $e) {
        echo "❌ {$route}: " . $e->getMessage() . "\n";
    }
}

echo "\nTesting marketing dashboard access...\n";

try {
    // Test marketing user login
    $authResult = \Illuminate\Support\Facades\Auth::attempt([
        'email' => 'marketing@infinitywear.sa',
        'password' => 'marketing123'
    ]);
    
    if ($authResult) {
        echo "✅ Marketing user authentication successful\n";
        
        // Test dashboard route
        $request = \Illuminate\Http\Request::create('/marketing/dashboard', 'GET');
        $request->setLaravelSession(\Illuminate\Support\Facades\Session::getStore());
        
        $router = app('router');
        $response = $router->dispatch($request);
        
        echo "Dashboard response status: " . $response->getStatusCode() . "\n";
        
        if ($response->getStatusCode() === 200) {
            echo "✅ Marketing dashboard accessible\n";
        } else {
            echo "❌ Marketing dashboard failed\n";
        }
        
    } else {
        echo "❌ Marketing user authentication failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

\Illuminate\Support\Facades\Auth::logout();
echo "\nTest completed.\n";
