<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>اختبار تسجيل الدخول</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #0056b3;
        }
        .info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            background: #ffe7e7;
            color: #d00;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .success {
            background: #e7ffe7;
            color: #080;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>اختبار تسجيل الدخول</h1>
        
        <div class="info">
            <strong>معلومات الجلسة:</strong><br>
            CSRF Token: <code>{{ csrf_token() }}</code><br>
            Session ID: <code>{{ session()->getId() }}</code>
        </div>

        <form method="POST" action="{{ route('login') }}" id="testForm">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" value="khaledahmedhaggagy@gmail.com" required>
            </div>
            
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" value="01010254819" required>
            </div>
            
            <button type="submit">تسجيل الدخول</button>
        </form>

        <div id="result"></div>
    </div>

    <script>
        document.getElementById('testForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('result');
            
            resultDiv.innerHTML = '<div class="info">جاري إرسال البيانات...</div>';
            
            fetch('{{ route("login") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    throw new Error('HTTP ' + response.status);
                }
            })
            .then(data => {
                resultDiv.innerHTML = '<div class="success">تم تسجيل الدخول بنجاح!</div>';
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '/importers/dashboard';
                }, 2000);
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="error">خطأ: ' + error.message + '</div>';
            });
        });
    </script>
</body>
</html>
