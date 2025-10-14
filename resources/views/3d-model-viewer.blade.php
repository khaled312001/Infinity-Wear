<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معاينة المجسم ثلاثي الأبعاد - FinalBaseMesh.obj</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Three.js ES Modules -->
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/"
            }
        }
    </script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container-fluid {
            padding: 20px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        
        .card-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        #model-container {
            width: 100%;
            height: 500px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: #667eea;
        }
        
        .model-info {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .clothing-controls {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .color-picker {
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        
        .color-picker:hover {
            transform: scale(1.1);
        }
        
        .btn-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
        
        .info-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            margin: 5px;
            display: inline-block;
        }
        
        .success-message {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            display: none;
        }
        
        .error-message {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h2><i class="fas fa-cube me-2"></i>معاينة المجسم ثلاثي الأبعاد</h2>
                        <p class="mb-0">FinalBaseMesh.obj - مجسم عالي الجودة للتصميم الاحترافي</p>
                    </div>
                    
                    <div class="card-body">
                        <!-- Model Information -->
                        <div class="model-info">
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <h4><i class="fas fa-cube me-2"></i>مجسم ثلاثي الأبعاد عالي الجودة</h4>
                                    <p class="mb-0">FinalBaseMesh.obj - مجسم احترافي للتصميم والتصور</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Success/Error Messages -->
                        <div id="success-message" class="success-message">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="success-text">تم تحميل المجسم بنجاح!</span>
                        </div>
                        
                        <div id="error-message" class="error-message">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="error-text">حدث خطأ في تحميل المجسم</span>
                        </div>
                        
                        <!-- 3D Model Container -->
                        <div id="model-container">
                            <div id="loading-overlay" class="loading-overlay">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">جاري التحميل...</span>
                                </div>
                                <h4 class="mt-3">جاري تحميل FinalBaseMesh.obj...</h4>
                                <p class="text-muted">يرجى الانتظار بينما يتم تحميل المجسم ثلاثي الأبعاد</p>
                            </div>
                        </div>
                        
                        <!-- View Controls -->
                        <div class="clothing-controls">
                            <h4><i class="fas fa-cube me-2"></i>تحكم في العرض</h4>
                            <div class="text-center mt-3">
                                <button id="reset-view" class="btn btn-custom">
                                    <i class="fas fa-undo me-2"></i>إعادة تعيين العرض
                                </button>
                            </div>
                        </div>
                        
                        <!-- Instructions -->
                        <div class="mt-4">
                            <h5><i class="fas fa-info-circle me-2"></i>تعليمات الاستخدام</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-badge">
                                        <i class="fas fa-mouse me-2"></i>اسحب بالماوس للدوران
                                    </div>
                                    <div class="info-badge">
                                        <i class="fas fa-mouse me-2"></i>استخدم عجلة الماوس للتكبير
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-badge">
                                        <i class="fas fa-keyboard me-2"></i>أسهم الكيبورد للدوران
                                    </div>
                                    <div class="info-badge">
                                        <i class="fas fa-keyboard me-2"></i>R لإعادة تعيين العرض
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script type="module">
        import * as THREE from 'three';
        import { OBJLoader } from 'three/addons/loaders/OBJLoader.js';
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
        
        // Global variables
        let scene, camera, renderer, controls;
        let humanModel;
        let isLoaded = false;
        
        // Initialize the 3D scene
        function init3DScene() {
            const container = document.getElementById('model-container');
            
            // Create scene
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0xf0f0f0);
            
            // Create camera
            camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
            camera.position.set(0, 0, 5);
            
            // Create renderer
            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.shadowMap.enabled = true;
            renderer.shadowMap.type = THREE.PCFSoftShadowMap;
            container.appendChild(renderer.domElement);
            
            // Add controls
            controls = new OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            
            // Add lighting
            const ambientLight = new THREE.AmbientLight(0x404040, 0.6);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(10, 10, 5);
            directionalLight.castShadow = true;
            scene.add(directionalLight);
            
            // Load the model
            loadModel();
            
            // Start render loop
            animate();
        }
        
        // Load the OBJ model
        function loadModel() {
            const loader = new OBJLoader();
            
            loader.load(
                '{{ route("3d.model.obj") }}',
                function (object) {
                    console.log('Model loaded successfully');
                    
                    // Hide loading overlay
                    document.getElementById('loading-overlay').style.display = 'none';
                    
                    // Show success message
                    showSuccessMessage('تم تحميل FinalBaseMesh.obj بنجاح!');
                    
                    // Scale and position the model
                    object.scale.set(0.1, 0.1, 0.1);
                    object.position.set(0, -2, 0);
                    
                    // Apply material to the model
                    const material = new THREE.MeshLambertMaterial({ 
                        color: 0xffdbac,
                        transparent: true,
                        opacity: 0.9
                    });
                    
                    object.traverse(function (child) {
                        if (child instanceof THREE.Mesh) {
                            child.material = material;
                            child.castShadow = true;
                            child.receiveShadow = true;
                        }
                    });
                    
                    humanModel = object;
                    scene.add(humanModel);
                    
                    isLoaded = true;
                },
                function (progress) {
                    console.log('Loading progress: ' + (progress.loaded / progress.total * 100) + '%');
                },
                function (error) {
                    console.error('Error loading model:', error);
                    
                    // Hide loading overlay
                    document.getElementById('loading-overlay').style.display = 'none';
                    
                    // Show error message
                    showErrorMessage('فشل في تحميل المجسم. يرجى المحاولة مرة أخرى.');
                }
            );
        }
        
        
        
        // Show success message
        function showSuccessMessage(message) {
            const successDiv = document.getElementById('success-message');
            const successText = document.getElementById('success-text');
            successText.textContent = message;
            successDiv.style.display = 'block';
            
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 3000);
        }
        
        // Show error message
        function showErrorMessage(message) {
            const errorDiv = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            errorText.textContent = message;
            errorDiv.style.display = 'block';
            
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }
        
        // Animation loop
        function animate() {
            requestAnimationFrame(animate);
            
            if (controls) {
                controls.update();
            }
            
            if (renderer && scene && camera) {
                renderer.render(scene, camera);
            }
        }
        
        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize 3D scene
            init3DScene();
            
            // Reset view button
            document.getElementById('reset-view').addEventListener('click', function() {
                if (controls) {
                    controls.reset();
                }
            });
            
            // Keyboard controls
            document.addEventListener('keydown', function(event) {
                if (event.key.toLowerCase() === 'r') {
                    if (controls) {
                        controls.reset();
                    }
                }
            });
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (camera && renderer) {
                const container = document.getElementById('model-container');
                camera.aspect = container.clientWidth / container.clientHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(container.clientWidth, container.clientHeight);
            }
        });
    </script>
</body>
</html>
