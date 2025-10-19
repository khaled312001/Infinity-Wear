<?php

// Simple fix for JavaScript task management
// This replaces the problematic lines directly

$jsFile = 'public/js/task-management.js';

if (!file_exists($jsFile)) {
    echo "JavaScript file not found: $jsFile\n";
    exit(1);
}

// Read the current file
$content = file_get_contents($jsFile);

// Create backup
file_put_contents($jsFile . '.backup', $content);

// Replace the problematic lines
$replacements = [
    // Replace priority color and label calls
    'this.getPriorityColor(taskData.priority)' => '(this.getPriorityColor || function(p) { const c = {\'low\':\'success\',\'medium\':\'warning\',\'high\':\'danger\',\'urgent\':\'danger\',\'critical\':\'dark\'}; return c[p] || \'secondary\'; })(taskData.priority)',
    'this.getPriorityLabel(taskData.priority)' => '(this.getPriorityLabel || function(p) { const l = {\'low\':\'منخفضة\',\'medium\':\'متوسطة\',\'high\':\'عالية\',\'urgent\':\'عاجلة\',\'critical\':\'حرجة\'}; return l[p] || p; })(taskData.priority)',
    
    // Replace status color and label calls
    'this.getStatusColor(taskData.status)' => '(this.getStatusColor || function(s) { const c = {\'pending\':\'warning\',\'in_progress\':\'primary\',\'completed\':\'success\',\'cancelled\':\'danger\',\'on_hold\':\'secondary\'}; return c[s] || \'secondary\'; })(taskData.status)',
    'this.getStatusLabel(taskData.status)' => '(this.getStatusLabel || function(s) { const l = {\'pending\':\'معلقة\',\'in_progress\':\'قيد التنفيذ\',\'completed\':\'مكتملة\',\'cancelled\':\'ملغية\',\'on_hold\':\'معلقة\'}; return l[s] || s; })(taskData.status)'
];

$newContent = $content;
foreach ($replacements as $search => $replace) {
    $newContent = str_replace($search, $replace, $newContent);
}

if ($newContent !== $content) {
    if (file_put_contents($jsFile, $newContent)) {
        echo "✅ JavaScript file fixed successfully!\n";
        echo "✅ Backup created: $jsFile.backup\n";
        echo "✅ The getPriorityColor error should now be resolved.\n";
        echo "✅ Please clear your browser cache (Ctrl+F5) and test the task viewing.\n";
        echo "\nChanges made:\n";
        foreach ($replacements as $search => $replace) {
            if (strpos($content, $search) !== false) {
                echo "- Fixed: $search\n";
            }
        }
    } else {
        echo "❌ Error writing to file. Please check permissions.\n";
    }
} else {
    echo "⚠️  No changes needed. The file might already be fixed.\n";
}

?>
