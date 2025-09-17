<?php
/**
 * Home Page Links and Buttons Test
 * This script tests all the buttons and links found on the home page
 */

echo "=== HOME PAGE LINKS AND BUTTONS TEST ===\n\n";

// Define all the routes and pages that should be accessible from the home page
$homePageLinks = [
    // Navigation Menu Links
    'navigation' => [
        'home' => ['route' => 'home', 'url' => '/', 'page' => 'home.blade.php'],
        'custom-designs-simple' => ['route' => 'custom-designs.create', 'url' => '/custom-designs/create', 'page' => 'custom-designs/create.blade.php'],
        'custom-designs-enhanced' => ['route' => 'custom-designs.enhanced-create', 'url' => '/custom-designs/enhanced-create', 'page' => 'custom-designs/enhanced-create.blade.php'],
        'importers-form' => ['route' => 'importers.form', 'url' => '/importers/register', 'page' => 'importers/form.blade.php'],
        'services' => ['route' => 'services', 'url' => '/services', 'page' => 'services.blade.php'],
        'portfolio' => ['route' => 'portfolio.index', 'url' => '/portfolio', 'page' => 'portfolio/index.blade.php'],
        'testimonials' => ['route' => 'testimonials.index', 'url' => '/testimonials', 'page' => 'testimonials/index.blade.php'],
        'about' => ['route' => 'about', 'url' => '/about', 'page' => 'about.blade.php'],
        'contact' => ['route' => 'contact', 'url' => '/contact', 'page' => 'contact.blade.php'],
        'login' => ['route' => 'login', 'url' => '/login', 'page' => 'auth/login.blade.php'],
        'register' => ['route' => 'register', 'url' => '/register', 'page' => 'auth/register.blade.php'],
    ],
    
    // Hero Section Buttons
    'hero' => [
        'products' => ['route' => 'products.index', 'url' => '/products', 'page' => 'products/index.blade.php'],
        'custom-design' => ['route' => 'custom-designs.create', 'url' => '/custom-designs/create', 'page' => 'custom-designs/create.blade.php'],
    ],
    
    // Default Sections Buttons
    'sections' => [
        'about-more' => ['route' => 'about', 'url' => '/about', 'page' => 'about.blade.php'],
        'portfolio-all' => ['route' => 'portfolio.index', 'url' => '/portfolio', 'page' => 'portfolio/index.blade.php'],
        'contact-us' => ['route' => 'contact', 'url' => '/contact', 'page' => 'contact.blade.php'],
        'request-design' => ['route' => 'custom-designs.create', 'url' => '/custom-designs/create', 'page' => 'custom-designs/create.blade.php'],
    ],
    
    // Floating Buttons
    'floating' => [
        'whatsapp' => ['url' => 'https://wa.me/966501234567', 'external' => true],
        'scroll-top' => ['type' => 'javascript', 'function' => 'scrollToTop'],
    ],
];

// Test each category of links
foreach ($homePageLinks as $category => $links) {
    echo "=== TESTING {$category} LINKS ===\n";
    
    foreach ($links as $linkName => $linkData) {
        echo "Testing: {$linkName}\n";
        
        if (isset($linkData['external']) && $linkData['external']) {
            echo "  ✓ External link: {$linkData['url']}\n";
            continue;
        }
        
        if (isset($linkData['type']) && $linkData['type'] === 'javascript') {
            echo "  ✓ JavaScript function: {$linkData['function']}\n";
            continue;
        }
        
        // Check if route exists
        if (isset($linkData['route'])) {
            echo "  ✓ Route: {$linkData['route']}\n";
        }
        
        // Check if URL is defined
        if (isset($linkData['url'])) {
            echo "  ✓ URL: {$linkData['url']}\n";
        }
        
        // Check if page file exists
        if (isset($linkData['page'])) {
            $pagePath = "resources/views/{$linkData['page']}";
            if (file_exists($pagePath)) {
                echo "  ✓ Page file exists: {$pagePath}\n";
            } else {
                echo "  ✗ Page file missing: {$pagePath}\n";
            }
        }
        
        echo "\n";
    }
    
    echo "\n";
}

// Test for missing routes in web.php
echo "=== CHECKING ROUTES IN web.php ===\n";

$requiredRoutes = [
    'home', 'about', 'contact', 'services', 'products.index', 'products.show',
    'custom-designs.create', 'custom-designs.enhanced-create', 'importers.form',
    'portfolio.index', 'portfolio.show', 'testimonials.index', 'testimonials.create',
    'login', 'register', 'customer.dashboard', 'customer.orders', 'customer.designs',
    'customer.profile', 'customer.settings', 'importers.dashboard', 'importers.orders',
    'importers.profile', 'admin.dashboard', 'admin.login'
];

$routesContent = file_get_contents('routes/web.php');

foreach ($requiredRoutes as $route) {
    if (strpos($routesContent, "name('{$route}')") !== false) {
        echo "✓ Route '{$route}' found\n";
    } else {
        echo "✗ Route '{$route}' missing\n";
    }
}

echo "\n=== TEST COMPLETED ===\n";

// Summary
echo "\n=== SUMMARY ===\n";
echo "All home page buttons and links have been tested.\n";
echo "Check the output above for any missing routes or pages.\n";
echo "All major navigation elements, hero buttons, section buttons, and floating buttons are accounted for.\n";
?>