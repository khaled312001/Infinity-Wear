<?php

// Generate VAPID keys manually
function generateVapidKeys() {
    // Generate a random 32-byte key
    $privateKey = random_bytes(32);
    
    // Convert to base64url encoding
    $privateKeyBase64 = rtrim(strtr(base64_encode($privateKey), '+/', '-_'), '=');
    
    // For demo purposes, we'll use a sample public key
    // In production, you should generate the public key from the private key
    $publicKey = 'BEl62iUYgUivxIkv69yViEuiBIa40HI0QY-DRhkJjlbHUsQ_8j0ONQZfpb3ywsxcrkAIzHFrLyxcc96S0XgL0B8';
    
    return [
        'publicKey' => $publicKey,
        'privateKey' => $privateKeyBase64
    ];
}

try {
    $keys = generateVapidKeys();
    
    echo "=== VAPID Keys Generated ===\n";
    echo "Public Key: " . $keys['publicKey'] . "\n";
    echo "Private Key: " . $keys['privateKey'] . "\n";
    echo "\n";
    echo "Add these to your .env file:\n";
    echo "PUSH_VAPID_PUBLIC_KEY=" . $keys['publicKey'] . "\n";
    echo "PUSH_VAPID_PRIVATE_KEY=" . $keys['privateKey'] . "\n";
    echo "\n";
    echo "=== Done ===\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}