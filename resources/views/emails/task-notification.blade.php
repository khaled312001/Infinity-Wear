<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Notification - Infinity Wear</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .action-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .action-created { background: #e8f5e8; color: #388e3c; }
        .action-updated { background: #e3f2fd; color: #1976d2; }
        .action-completed { background: #f3e5f5; color: #7b1fa2; }
        .action-assigned { background: #fff3e0; color: #f57c00; }
        .task-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin-bottom: 20px;
        }
        .field {
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 3px;
        }
        .field-label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .field-value {
            color: #333;
        }
        .priority-high { border-left: 4px solid #f44336; }
        .priority-medium { border-left: 4px solid #ff9800; }
        .priority-low { border-left: 4px solid #4caf50; }
        .status-pending { color: #ff9800; font-weight: bold; }
        .status-in_progress { color: #2196f3; font-weight: bold; }
        .status-completed { color: #4caf50; font-weight: bold; }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            color: #666;
        }
        .timestamp {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Task Notification</h1>
            <p>Infinity Wear - Task Management System</p>
        </div>

        <div class="action-badge action-{{ $action }}">
            {{ ucfirst($action) }}
        </div>

        <div class="task-details priority-{{ strtolower($task->priority ?? 'medium') }}">
            <div class="field">
                <div class="field-label">📝 Task Title:</div>
                <div class="field-value">{{ $task->title ?? 'N/A' }}</div>
            </div>

            @if(isset($task->description))
            <div class="field">
                <div class="field-label">📄 Description:</div>
                <div class="field-value" style="white-space: pre-wrap;">{{ $task->description }}</div>
            </div>
            @endif

            @if(isset($task->priority))
            <div class="field">
                <div class="field-label">⚡ Priority:</div>
                <div class="field-value">{{ ucfirst($task->priority) }}</div>
            </div>
            @endif

            @if(isset($task->status))
            <div class="field">
                <div class="field-label">📊 Status:</div>
                <div class="field-value status-{{ strtolower(str_replace(' ', '_', $task->status)) }}">{{ ucfirst($task->status) }}</div>
            </div>
            @endif

            @if(isset($task->assigned_to))
            <div class="field">
                <div class="field-label">👤 Assigned To:</div>
                <div class="field-value">{{ $task->assigned_to }}</div>
            </div>
            @endif

            @if(isset($task->due_date))
            <div class="field">
                <div class="field-label">📅 Due Date:</div>
                <div class="field-value">{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i') }}</div>
            </div>
            @endif
        </div>

        <div class="timestamp">
            <strong>📅 Notification Sent:</strong> {{ now()->format('Y-m-d H:i:s') }} ({{ now()->timezoneName }})
        </div>

        <div class="footer">
            <p><strong>Infinity Wear</strong> - Task Management System</p>
            <p>This notification was sent automatically from the task management system</p>
        </div>
    </div>
</body>
</html>
