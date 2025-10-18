<?php
// اختبار حالة الخادم المباشر
header('Content-Type: text/plain; charset=utf-8');

echo "=== اختبار حالة الخادم المباشر ===\n\n";

// 1. التحقق من إصدار PHP
echo "1. إصدار PHP: " . PHP_VERSION . "\n";

// 2. التحقق من اتصال قاعدة البيانات
try {
    $pdo = new PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'], 
        $_ENV['DB_USERNAME'], 
        $_ENV['DB_PASSWORD']
    );
    echo "✅ اتصال قاعدة البيانات: نجح\n";
    
    // 3. التحقق من وجود جدول المهام
    $stmt = $pdo->query("SHOW TABLES LIKE 'tasks'");
    if ($stmt->fetch()) {
        echo "✅ جدول المهام: موجود\n";
        
        // 4. التحقق من بنية الجدول
        $stmt = $pdo->query("DESCRIBE tasks");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $requiredColumns = ['department', 'column_status', 'position', 'importer_id'];
        $missingColumns = [];
        
        foreach ($requiredColumns as $col) {
            $found = false;
            foreach ($columns as $column) {
                if ($column['Field'] === $col) {
                    $found = true;
                    echo "✅ العمود '$col': موجود (" . $column['Type'] . ")\n";
                    break;
                }
            }
            if (!$found) {
                $missingColumns[] = $col;
                echo "❌ العمود '$col': مفقود\n";
            }
        }
        
        if (empty($missingColumns)) {
            echo "\n✅ جميع الأعمدة المطلوبة موجودة\n";
            
            // 5. اختبار إدراج مهمة
            echo "\n5. اختبار إنشاء مهمة:\n";
            try {
                $stmt = $pdo->prepare("INSERT INTO tasks (title, description, board_id, column_id, priority, assigned_to, assigned_to_type, created_by, created_by_type, sort_order, labels, tags, estimated_hours, color, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
                
                $result = $stmt->execute([
                    'Test Server Task',
                    'Test Description',
                    8,
                    5,
                    'medium',
                    1,
                    'admin',
                    1,
                    'admin',
                    1,
                    '[]',
                    '[]',
                    12,
                    '#ff0000'
                ]);
                
                if ($result) {
                    $taskId = $pdo->lastInsertId();
                    echo "✅ تم إنشاء مهمة تجريبية بنجاح (ID: $taskId)\n";
                    
                    // حذف المهمة التجريبية
                    $pdo->prepare("DELETE FROM tasks WHERE id = ?")->execute([$taskId]);
                    echo "✅ تم حذف المهمة التجريبية\n";
                } else {
                    echo "❌ فشل في إنشاء مهمة تجريبية\n";
                }
            } catch (Exception $e) {
                echo "❌ خطأ في إنشاء المهمة: " . $e->getMessage() . "\n";
            }
        } else {
            echo "\n❌ الأعمدة المفقودة: " . implode(', ', $missingColumns) . "\n";
            echo "يجب تطبيق migrations الجديدة\n";
        }
        
    } else {
        echo "❌ جدول المهام: غير موجود\n";
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في اتصال قاعدة البيانات: " . $e->getMessage() . "\n";
}

echo "\n=== انتهاء الاختبار ===\n";
?>