<?php

// Quick fix script for JavaScript task management
// Run this on the server to fix the getPriorityColor error immediately

$jsFile = 'public/js/task-management.js';

if (!file_exists($jsFile)) {
    echo "JavaScript file not found: $jsFile\n";
    exit(1);
}

// Read the current file
$content = file_get_contents($jsFile);

// Find the displayTaskView method and add the fix
$pattern = '/(displayTaskView\(taskData\)\s*\{)/';
$replacement = '$1
        // Quick fix - ensure methods exist
        if (!this.getPriorityColor) {
            this.getPriorityColor = function(priority) {
                const colors = { \'low\': \'success\', \'medium\': \'warning\', \'high\': \'danger\', \'urgent\': \'danger\', \'critical\': \'dark\' };
                return colors[priority] || \'secondary\';
            };
        }
        if (!this.getPriorityLabel) {
            this.getPriorityLabel = function(priority) {
                const labels = { \'low\': \'منخفضة\', \'medium\': \'متوسطة\', \'high\': \'عالية\', \'urgent\': \'عاجلة\', \'critical\': \'حرجة\' };
                return labels[priority] || priority;
            };
        }
        if (!this.getStatusColor) {
            this.getStatusColor = function(status) {
                const colors = { \'pending\': \'warning\', \'in_progress\': \'primary\', \'completed\': \'success\', \'cancelled\': \'danger\', \'on_hold\': \'secondary\' };
                return colors[status] || \'secondary\';
            };
        }
        if (!this.getStatusLabel) {
            this.getStatusLabel = function(status) {
                const labels = { \'pending\': \'معلقة\', \'in_progress\': \'قيد التنفيذ\', \'completed\': \'مكتملة\', \'cancelled\': \'ملغية\', \'on_hold\': \'معلقة\' };
                return labels[status] || status;
            };
        }

        ';

$newContent = preg_replace($pattern, $replacement, $content);

if ($newContent !== $content) {
    // Backup the original file
    file_put_contents($jsFile . '.backup', $content);
    
    // Write the fixed content
    if (file_put_contents($jsFile, $newContent)) {
        echo "✅ JavaScript file fixed successfully!\n";
        echo "✅ Backup created: $jsFile.backup\n";
        echo "✅ The getPriorityColor error should now be resolved.\n";
        echo "✅ Please clear your browser cache (Ctrl+F5) and test the task viewing.\n";
    } else {
        echo "❌ Error writing to file. Please check permissions.\n";
    }
} else {
    echo "⚠️  Pattern not found. The file might already be fixed or have a different structure.\n";
    echo "Current file size: " . strlen($content) . " bytes\n";
}

?>
