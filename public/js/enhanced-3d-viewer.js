/**
 * Enhanced 3D Design Viewer for Infinity Wear
 * Professional 3D clothing design interface with realistic models
 * @version 2.0.0
 */

class Enhanced3DViewer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error('3D Viewer container not found:', containerId);
            return;
        }

        // Three.js components
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.raycaster = new THREE.Raycaster();
        this.mouse = new THREE.Vector2();

        // Model components
        this.humanModel = null;
        this.clothingPieces = new Map();
        this.accessories = new Map();
        this.selectedPiece = null;

        // Animation
        this.animationMixer = null;
        this.clock = new THREE.Clock();

        // State
        this.isInitialized = false;
        this.currentDesign = {
            pieces: {},
            colors: {},
            patterns: {},
            logos: [],
            texts: []
        };

        this.init();
    }

    async init() {
        try {
            this.setupScene();
            this.setupCamera();
            this.setupRenderer();
            this.setupLighting();
            await this.setupControls();
            this.loadHumanModel();
            this.setupInteraction();
            this.animate();
            this.isInitialized = true;
            console.log('✓ Enhanced 3D Viewer initialized successfully');
        } catch (error) {
            console.error('Failed to initialize 3D Viewer:', error);
        }
    }

    setupScene() {
        this.scene = new THREE.Scene();
        
        // Professional background with gradient
        const canvas = document.createElement('canvas');
        canvas.width = 512;
        canvas.height = 512;
        const ctx = canvas.getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 512);
        gradient.addColorStop(0, '#f0f2f5');
        gradient.addColorStop(0.5, '#e3e8ed');
        gradient.addColorStop(1, '#d5dce3');
        
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, 512, 512);
        
        const texture = new THREE.CanvasTexture(canvas);
        this.scene.background = texture;

        // Add fog for depth
        this.scene.fog = new THREE.Fog(0xe3e8ed, 8, 20);

        // Add grid for reference (optional, can be toggled)
        const gridHelper = new THREE.GridHelper(10, 10, 0xcccccc, 0xe0e0e0);
        gridHelper.position.y = -2;
        gridHelper.visible = false; // Hidden by default
        gridHelper.name = 'gridHelper';
        this.scene.add(gridHelper);
    }

    setupCamera() {
        const width = this.container.clientWidth || 800;
        const height = this.container.clientHeight || 600;
        
        this.camera = new THREE.PerspectiveCamera(
            45, // Field of view
            width / height,
            0.1,
            1000
        );
        
        this.camera.position.set(0, 1, 6);
        this.camera.lookAt(0, 0.5, 0);
    }

    setupRenderer() {
        this.renderer = new THREE.WebGLRenderer({ 
            antialias: true,
            alpha: true,
            powerPreference: 'high-performance'
        });
        
        const width = this.container.clientWidth || 800;
        const height = this.container.clientHeight || 600;
        
        this.renderer.setSize(width, height);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        
        // Enable shadows for realism
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        
        // Tone mapping for better colors
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.2;
        this.renderer.outputEncoding = THREE.sRGBEncoding;
        
        // Clear container and add renderer
        this.container.innerHTML = '';
        this.container.appendChild(this.renderer.domElement);
        
        // Handle window resize
        window.addEventListener('resize', () => this.onWindowResize());
    }

    setupLighting() {
        // Hemisphere light for ambient lighting
        const hemisphereLight = new THREE.HemisphereLight(0xffffff, 0x444444, 0.6);
        hemisphereLight.position.set(0, 20, 0);
        this.scene.add(hemisphereLight);

        // Main directional light (sun)
        const mainLight = new THREE.DirectionalLight(0xffffff, 1.0);
        mainLight.position.set(5, 10, 7);
        mainLight.castShadow = true;
        
        // Configure shadow properties
        mainLight.shadow.mapSize.width = 2048;
        mainLight.shadow.mapSize.height = 2048;
        mainLight.shadow.camera.near = 0.5;
        mainLight.shadow.camera.far = 50;
        mainLight.shadow.camera.left = -10;
        mainLight.shadow.camera.right = 10;
        mainLight.shadow.camera.top = 10;
        mainLight.shadow.camera.bottom = -10;
        mainLight.shadow.bias = -0.001;
        
        this.scene.add(mainLight);

        // Fill light (opposite side)
        const fillLight = new THREE.DirectionalLight(0xffffff, 0.4);
        fillLight.position.set(-5, 8, -5);
        this.scene.add(fillLight);

        // Rim light (back light for definition)
        const rimLight = new THREE.DirectionalLight(0xffffff, 0.3);
        rimLight.position.set(0, 5, -8);
        this.scene.add(rimLight);

        // Point lights for accent
        const pointLight1 = new THREE.PointLight(0xffffff, 0.3, 50);
        pointLight1.position.set(3, 3, 3);
        this.scene.add(pointLight1);

        const pointLight2 = new THREE.PointLight(0xffffff, 0.2, 50);
        pointLight2.position.set(-3, 3, 3);
        this.scene.add(pointLight2);

        // Ambient light for overall brightness
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
        this.scene.add(ambientLight);
    }

    async setupControls() {
        // Wait for OrbitControls to be available
        return new Promise((resolve) => {
            const checkControls = () => {
                if (typeof THREE.OrbitControls !== 'undefined') {
                    this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
                    
                    // Configure controls
                    this.controls.enableDamping = true;
                    this.controls.dampingFactor = 0.05;
                    this.controls.screenSpacePanning = false;
                    this.controls.minDistance = 3;
                    this.controls.maxDistance = 10;
                    this.controls.maxPolarAngle = Math.PI / 1.5;
                    this.controls.minPolarAngle = Math.PI / 6;
                    this.controls.target.set(0, 0.5, 0);
                    this.controls.autoRotate = false;
                    this.controls.autoRotateSpeed = 1.0;
                    
                    resolve();
                } else {
                    setTimeout(checkControls, 100);
                }
            };
            checkControls();
        });
    }

    async loadGLTFModel(url) {
        // Check if GLTFLoader is available
        if (typeof THREE.GLTFLoader === 'undefined') {
            console.warn('GLTFLoader not available, using fallback model');
            return null;
        }

        return new Promise((resolve, reject) => {
            const loader = new THREE.GLTFLoader();
            
            // Set timeout to avoid hanging on failed requests
            const timeout = setTimeout(() => {
                reject(new Error('Model load timeout'));
            }, 10000); // 10 second timeout
            
            loader.load(
                url,
                (gltf) => {
                    clearTimeout(timeout);
                    resolve(gltf.scene);
                },
                (progress) => {
                    if (progress.total > 0) {
                        const percent = Math.round((progress.loaded / progress.total) * 100);
                        if (percent < 100) {
                            console.log('Loading model:', percent + '%');
                        }
                    }
                },
                (error) => {
                    clearTimeout(timeout);
                    // Suppress logging for expected network errors (403, CORS, etc.)
                    // These are expected when CDN models fail, and we have a fallback
                    const isNetworkError = error && (
                        error.type === 'error' || 
                        (error.target && error.target.status >= 400) ||
                        !error.lengthComputable
                    );
                    if (!isNetworkError) {
                        console.error('Error loading GLTF model:', error);
                    }
                    reject(error);
                }
            );
        });
    }

    async loadHumanModel() {
        // Try to load realistic GLTF model first
        try {
            const gltfModel = await this.loadRealisticHumanModel();
            if (gltfModel) {
                return;
            }
        } catch (error) {
            console.log('Using fallback model');
        }

        // Fallback: Create enhanced realistic mannequin
        this.createEnhancedMannequin();
    }

    async loadRealisticHumanModel() {
        // URLs for free human models
        const modelUrls = [
            'https://cdn.jsdelivr.net/gh/KhronosGroup/glTF-Sample-Models@master/2.0/RobotExpressive/glTF-Binary/RobotExpressive.glb',
            // You can add your own model URL here
        ];

        for (const url of modelUrls) {
            try {
                const model = await this.loadGLTFModel(url);
                if (model) {
                    model.scale.set(0.8, 0.8, 0.8);
                    model.position.set(0, -1, 0);
                    model.rotation.y = 0.1;
                    
                    // Enable shadows
                    model.traverse((child) => {
                        if (child.isMesh) {
                            child.castShadow = true;
                            child.receiveShadow = true;
                        }
                    });

                    this.humanModel = model;
                    this.scene.add(this.humanModel);
                    console.log('✓ Realistic human model loaded');
                    return model;
                }
            } catch (error) {
                // Silently fail and use fallback - don't log expected network errors
                // The fallback model will be used automatically
            }
        }

        return null;
    }

    createEnhancedMannequin() {
        // Create a highly detailed realistic human mannequin
        const humanGroup = new THREE.Group();
        humanGroup.name = 'humanModel';

        // Enhanced realistic skin material with subsurface
        const skinMaterial = new THREE.MeshStandardMaterial({ 
            color: 0xffd5b4,
            roughness: 0.6,
            metalness: 0.05,
            envMapIntensity: 0.5,
            flatShading: false
        });

        const hairMaterial = new THREE.MeshStandardMaterial({
            color: 0x3d2817,
            roughness: 0.9,
            metalness: 0.1
        });

        // Head Group with detailed features
        const headGroup = new THREE.Group();
        
        // Main head with better shape
        const headGeometry = new THREE.SphereGeometry(0.25, 64, 64);
        const head = new THREE.Mesh(headGeometry, skinMaterial);
        head.scale.set(1, 1.15, 0.95);
        head.position.y = 1.55;
        head.castShadow = true;
        head.receiveShadow = true;
        headGroup.add(head);

        // Face features
        // Eyes
        const eyeGeo = new THREE.SphereGeometry(0.03, 16, 16);
        const eyeMaterial = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            roughness: 0.2,
            metalness: 0.1
        });
        
        const leftEye = new THREE.Mesh(eyeGeo, eyeMaterial);
        leftEye.position.set(-0.08, 1.58, 0.2);
        headGroup.add(leftEye);
        
        const rightEye = new THREE.Mesh(eyeGeo, eyeMaterial);
        rightEye.position.set(0.08, 1.58, 0.2);
        headGroup.add(rightEye);

        // Pupils
        const pupilGeo = new THREE.SphereGeometry(0.015, 16, 16);
        const pupilMaterial = new THREE.MeshStandardMaterial({
            color: 0x1a1a1a,
            roughness: 0.1
        });
        
        const leftPupil = new THREE.Mesh(pupilGeo, pupilMaterial);
        leftPupil.position.set(-0.08, 1.58, 0.22);
        headGroup.add(leftPupil);
        
        const rightPupil = new THREE.Mesh(pupilGeo, pupilMaterial);
        rightPupil.position.set(0.08, 1.58, 0.22);
        headGroup.add(rightPupil);

        // Nose
        const noseGeo = new THREE.ConeGeometry(0.025, 0.08, 8);
        const nose = new THREE.Mesh(noseGeo, skinMaterial);
        nose.position.set(0, 1.52, 0.23);
        nose.rotation.x = Math.PI / 2;
        headGroup.add(nose);

        // Ears
        const earGeo = new THREE.SphereGeometry(0.05, 16, 16);
        earGeo.scale(0.5, 1, 0.3);
        
        const leftEar = new THREE.Mesh(earGeo, skinMaterial);
        leftEar.position.set(-0.24, 1.55, 0);
        leftEar.castShadow = true;
        headGroup.add(leftEar);
        
        const rightEar = new THREE.Mesh(earGeo, skinMaterial);
        rightEar.position.set(0.24, 1.55, 0);
        rightEar.castShadow = true;
        headGroup.add(rightEar);

        // Hair
        const hairGeo = new THREE.SphereGeometry(0.27, 32, 32);
        const hair = new THREE.Mesh(hairGeo, hairMaterial);
        hair.scale.set(1, 0.9, 1);
        hair.position.y = 1.65;
        hair.castShadow = true;
        headGroup.add(hair);

        humanGroup.add(headGroup);

        // Neck
        const neckGeometry = new THREE.CylinderGeometry(0.1, 0.12, 0.2, 16);
        const neck = new THREE.Mesh(neckGeometry, skinMaterial);
        neck.position.y = 1.25;
        neck.castShadow = true;
        humanGroup.add(neck);

        // Torso - using better shape
        const torsoGeometry = new THREE.CylinderGeometry(0.38, 0.45, 1.1, 32);
        const torso = new THREE.Mesh(torsoGeometry, skinMaterial);
        torso.position.y = 0.45;
        torso.castShadow = true;
        torso.receiveShadow = true;
        torso.scale.set(1, 1, 0.7); // Make it more flat (front to back)
        humanGroup.add(torso);

        // Shoulders
        const shoulderGeometry = new THREE.SphereGeometry(0.16, 16, 16);
        
        const leftShoulder = new THREE.Mesh(shoulderGeometry, skinMaterial);
        leftShoulder.position.set(-0.54, 0.9, 0);
        leftShoulder.castShadow = true;
        humanGroup.add(leftShoulder);

        const rightShoulder = new THREE.Mesh(shoulderGeometry, skinMaterial);
        rightShoulder.position.set(0.54, 0.9, 0);
        rightShoulder.castShadow = true;
        humanGroup.add(rightShoulder);

        // Arms
        this.createArm(humanGroup, -0.6, skinMaterial); // Left arm
        this.createArm(humanGroup, 0.6, skinMaterial);  // Right arm

        // Hips/Pelvis
        const hipsGeometry = new THREE.CylinderGeometry(0.4, 0.45, 0.2, 32);
        const hips = new THREE.Mesh(hipsGeometry, skinMaterial);
        hips.position.y = -0.15;
        hips.castShadow = true;
        hips.scale.set(1, 1, 0.6);
        humanGroup.add(hips);

        // Legs
        this.createLeg(humanGroup, -0.22, skinMaterial); // Left leg
        this.createLeg(humanGroup, 0.22, skinMaterial);  // Right leg

        // Position the model
        humanGroup.position.y = 0;
        
        this.humanModel = humanGroup;
        this.scene.add(this.humanModel);

        // Add a subtle rotation animation
        this.humanModel.rotation.y = 0.1;

        console.log('✓ Human model loaded');
    }

    createArm(parentGroup, xOffset, material) {
        const isLeft = xOffset < 0;
        const sign = isLeft ? -1 : 1;

        // Upper arm with muscle definition
        const upperArmGeo = new THREE.CylinderGeometry(0.08, 0.1, 0.45, 16);
        const upperArm = new THREE.Mesh(upperArmGeo, material);
        upperArm.position.set(xOffset, 0.6, 0);
        upperArm.rotation.z = sign * Math.PI / 15;
        upperArm.castShadow = true;
        parentGroup.add(upperArm);

        // Elbow joint
        const elbowGeo = new THREE.SphereGeometry(0.085, 12, 12);
        const elbow = new THREE.Mesh(elbowGeo, material);
        elbow.position.set(xOffset + (sign * 0.05), 0.35, 0);
        elbow.castShadow = true;
        parentGroup.add(elbow);

        // Lower arm (forearm)
        const lowerArmGeo = new THREE.CylinderGeometry(0.07, 0.08, 0.4, 16);
        const lowerArm = new THREE.Mesh(lowerArmGeo, material);
        lowerArm.position.set(xOffset + (sign * 0.1), 0.1, 0.05);
        lowerArm.rotation.z = sign * Math.PI / 12;
        lowerArm.castShadow = true;
        parentGroup.add(lowerArm);

        // Wrist
        const wristGeo = new THREE.SphereGeometry(0.07, 12, 12);
        const wrist = new THREE.Mesh(wristGeo, material);
        wrist.position.set(xOffset + (sign * 0.15), -0.1, 0.08);
        wrist.castShadow = true;
        parentGroup.add(wrist);

        // Hand - more detailed
        const handGeo = new THREE.BoxGeometry(0.1, 0.15, 0.05);
        const hand = new THREE.Mesh(handGeo, material);
        hand.position.set(xOffset + (sign * 0.15), -0.18, 0.08);
        hand.castShadow = true;
        parentGroup.add(hand);

        // Fingers
        for (let i = 0; i < 5; i++) {
            const fingerGeo = new THREE.CylinderGeometry(0.008, 0.006, 0.05, 8);
            const finger = new THREE.Mesh(fingerGeo, material);
            finger.position.set(
                xOffset + (sign * 0.15) + (i - 2) * 0.015 * sign,
                -0.255,
                0.1
            );
            finger.rotation.x = Math.PI / 6;
            finger.castShadow = true;
            parentGroup.add(finger);
        }
    }

    createLeg(parentGroup, xOffset, material) {
        // Upper leg (thigh) with muscle definition
        const upperLegGeo = new THREE.CylinderGeometry(0.11, 0.13, 0.55, 16);
        const upperLeg = new THREE.Mesh(upperLegGeo, material);
        upperLeg.position.set(xOffset, -0.35, 0);
        upperLeg.castShadow = true;
        parentGroup.add(upperLeg);

        // Knee cap
        const kneeGeo = new THREE.SphereGeometry(0.11, 16, 16);
        const knee = new THREE.Mesh(kneeGeo, material);
        knee.position.set(xOffset, -0.65, 0.05);
        knee.scale.set(1, 0.9, 0.8);
        knee.castShadow = true;
        parentGroup.add(knee);

        // Lower leg (calf) with natural taper
        const lowerLegGeo = new THREE.CylinderGeometry(0.09, 0.1, 0.55, 16);
        const lowerLeg = new THREE.Mesh(lowerLegGeo, material);
        lowerLeg.position.set(xOffset, -0.95, 0);
        lowerLeg.castShadow = true;
        parentGroup.add(lowerLeg);

        // Ankle
        const ankleGeo = new THREE.SphereGeometry(0.08, 12, 12);
        const ankle = new THREE.Mesh(ankleGeo, material);
        ankle.position.set(xOffset, -1.225, 0);
        ankle.castShadow = true;
        parentGroup.add(ankle);

        // Foot - more anatomical
        const footGeo = new THREE.BoxGeometry(0.15, 0.1, 0.3);
        const foot = new THREE.Mesh(footGeo, material);
        foot.position.set(xOffset, -1.28, 0.07);
        foot.castShadow = true;
        foot.receiveShadow = true;
        parentGroup.add(foot);

        // Toes
        for (let i = 0; i < 5; i++) {
            const toeGeo = new THREE.SphereGeometry(0.015, 8, 8);
            toeGeo.scale(1, 0.7, 1.2);
            const toe = new THREE.Mesh(toeGeo, material);
            toe.position.set(
                xOffset + (i - 2) * 0.025,
                -1.32,
                0.2
            );
            toe.castShadow = true;
            parentGroup.add(toe);
        }
    }

    setupInteraction() {
        // Mouse interaction
        this.renderer.domElement.addEventListener('mousemove', (event) => {
            this.onMouseMove(event);
        });

        this.renderer.domElement.addEventListener('click', (event) => {
            this.onMouseClick(event);
        });

        // Touch interaction for mobile
        this.renderer.domElement.addEventListener('touchstart', (event) => {
            this.onTouchStart(event);
        }, { passive: true });
    }

    onMouseMove(event) {
        const rect = this.renderer.domElement.getBoundingClientRect();
        this.mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        this.mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        // Highlight on hover
        this.raycaster.setFromCamera(this.mouse, this.camera);
        const intersects = this.raycaster.intersectObjects(this.scene.children, true);

        if (intersects.length > 0) {
            const object = intersects[0].object;
            if (object.userData.selectable) {
                this.renderer.domElement.style.cursor = 'pointer';
            } else {
                this.renderer.domElement.style.cursor = 'default';
            }
        } else {
            this.renderer.domElement.style.cursor = 'default';
        }
    }

    onMouseClick(event) {
        const rect = this.renderer.domElement.getBoundingClientRect();
        this.mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        this.mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        this.raycaster.setFromCamera(this.mouse, this.camera);
        const intersects = this.raycaster.intersectObjects(this.scene.children, true);

        if (intersects.length > 0) {
            const object = intersects[0].object;
            if (object.userData.selectable) {
                this.selectPiece(object);
            }
        }
    }

    onTouchStart(event) {
        if (event.touches.length === 1) {
            const rect = this.renderer.domElement.getBoundingClientRect();
            this.mouse.x = ((event.touches[0].clientX - rect.left) / rect.width) * 2 - 1;
            this.mouse.y = -((event.touches[0].clientY - rect.top) / rect.height) * 2 + 1;
        }
    }

    // Clothing piece management
    addClothingPiece(pieceType, options = {}) {
        // Remove existing piece of same type
        this.removeClothingPiece(pieceType);

        const piece = this.createClothingPiece(pieceType, options);
        if (piece) {
            this.clothingPieces.set(pieceType, piece);
            this.scene.add(piece);
            this.currentDesign.pieces[pieceType] = options;
            
            // Animate entrance
            this.animatePieceEntrance(piece);
            
            console.log(`✓ Added ${pieceType}`);
            return piece;
        }
        return null;
    }

    createClothingPiece(pieceType, options) {
        const color = options.color || '#4A90E2';
        const material = new THREE.MeshStandardMaterial({ 
            color: color,
            roughness: 0.7,
            metalness: 0.1,
            side: THREE.DoubleSide
        });

        switch (pieceType) {
            case 'shirt':
            case 'tshirt':
                return this.createShirt(material, options);
            case 'pants':
                return this.createPants(material, options);
            case 'shorts':
                return this.createShorts(material, options);
            case 'jacket':
                return this.createJacket(material, options);
            case 'shoes':
                return this.createShoes(material, options);
            case 'socks':
                return this.createSocks(material, options);
            default:
                console.warn(`Unknown piece type: ${pieceType}`);
                return null;
        }
    }

    createShirt(material, options) {
        const group = new THREE.Group();
        group.name = 'shirt';
        group.userData = { type: 'shirt', selectable: true };

        // Main body
        const bodyGeometry = new THREE.CylinderGeometry(0.4, 0.47, 1.0, 32);
        const body = new THREE.Mesh(bodyGeometry, material);
        body.position.y = 0.4;
        body.scale.set(1, 1, 0.72);
        body.castShadow = true;
        body.receiveShadow = true;
        body.userData = { part: 'body', pieceType: 'shirt' };
        group.add(body);

        // Collar
        const collarMaterial = options.collarColor 
            ? new THREE.MeshStandardMaterial({ 
                color: options.collarColor, 
                roughness: 0.7,
                metalness: 0.1 
            })
            : material.clone();
        
        const collarGeometry = new THREE.TorusGeometry(0.42, 0.04, 8, 16, Math.PI);
        const collar = new THREE.Mesh(collarGeometry, collarMaterial);
        collar.position.y = 0.92;
        collar.rotation.x = Math.PI / 2;
        collar.castShadow = true;
        collar.userData = { part: 'collar', pieceType: 'shirt' };
        group.add(collar);

        // Sleeves
        const sleeveMaterial = options.sleeveColor 
            ? new THREE.MeshStandardMaterial({ 
                color: options.sleeveColor, 
                roughness: 0.7,
                metalness: 0.1 
            })
            : material.clone();
        
        this.createSleeve(group, -0.62, sleeveMaterial, options.sleeveLength || 'short');
        this.createSleeve(group, 0.62, sleeveMaterial, options.sleeveLength || 'short');

        // Bottom trim
        const trimGeometry = new THREE.TorusGeometry(0.47, 0.015, 8, 32);
        const trimMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x333333,
            roughness: 0.8 
        });
        const trim = new THREE.Mesh(trimGeometry, trimMaterial);
        trim.position.y = -0.1;
        trim.rotation.x = Math.PI / 2;
        trim.castShadow = true;
        group.add(trim);

        // Store positions for logos/text
        group.userData.positions = {
            'front-center': { x: 0, y: 0.5, z: 0.33 },
            'front-left': { x: -0.15, y: 0.5, z: 0.33 },
            'front-right': { x: 0.15, y: 0.5, z: 0.33 },
            'back-center': { x: 0, y: 0.5, z: -0.33 },
            'left-sleeve': { x: -0.62, y: 0.5, z: 0 },
            'right-sleeve': { x: 0.62, y: 0.5, z: 0 },
            'collar': { x: 0, y: 0.92, z: 0.15 }
        };

        return group;
    }

    createSleeve(parentGroup, xOffset, material, length = 'short') {
        const isLeft = xOffset < 0;
        const sign = isLeft ? -1 : 1;
        const sleeveLength = length === 'long' ? 0.7 : length === 'medium' ? 0.45 : 0.25;

        const sleeveGeometry = new THREE.CylinderGeometry(0.11, 0.13, sleeveLength, 16);
        const sleeve = new THREE.Mesh(sleeveGeometry, material);
        sleeve.position.set(xOffset, 0.5, 0);
        sleeve.rotation.z = sign * Math.PI / 10;
        sleeve.castShadow = true;
        sleeve.receiveShadow = true;
        sleeve.userData = { part: 'sleeves', pieceType: 'shirt' };
        parentGroup.add(sleeve);

        // Sleeve cuff
        const cuffGeometry = new THREE.TorusGeometry(0.13, 0.015, 8, 16);
        const cuffMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x333333,
            roughness: 0.8 
        });
        const cuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        cuff.position.set(xOffset + (sign * 0.03), 0.5 - (sleeveLength / 2), 0);
        cuff.rotation.x = Math.PI / 2;
        cuff.rotation.z = sign * Math.PI / 10;
        cuff.castShadow = true;
        parentGroup.add(cuff);
    }

    createPants(material, options) {
        const group = new THREE.Group();
        group.name = 'pants';
        group.userData = { type: 'pants', selectable: true };

        // Waistband
        const waistMaterial = options.waistColor 
            ? new THREE.MeshStandardMaterial({ 
                color: options.waistColor, 
                roughness: 0.8,
                metalness: 0.2 
            })
            : material.clone();
        
        const waistGeometry = new THREE.CylinderGeometry(0.42, 0.44, 0.12, 32);
        const waist = new THREE.Mesh(waistGeometry, waistMaterial);
        waist.position.y = -0.12;
        waist.scale.set(1, 1, 0.65);
        waist.castShadow = true;
        waist.userData = { part: 'waist', pieceType: 'pants' };
        group.add(waist);

        // Legs
        this.createPantsLeg(group, -0.22, material);
        this.createPantsLeg(group, 0.22, material);

        // Belt loops
        for (let i = 0; i < 6; i++) {
            const angle = (i / 6) * Math.PI * 2;
            const loopGeometry = new THREE.BoxGeometry(0.025, 0.08, 0.025);
            const loopMaterial = new THREE.MeshStandardMaterial({ 
                color: 0x2c3e50,
                roughness: 0.9 
            });
            const loop = new THREE.Mesh(loopGeometry, loopMaterial);
            loop.position.set(
                Math.sin(angle) * 0.3,
                -0.08,
                Math.cos(angle) * 0.21
            );
            loop.castShadow = true;
            group.add(loop);
        }

        group.userData.positions = {
            'left-leg': { x: -0.22, y: -0.6, z: 0.16 },
            'right-leg': { x: 0.22, y: -0.6, z: 0.16 },
            'waist': { x: 0, y: -0.12, z: 0.3 }
        };

        return group;
    }

    createPantsLeg(parentGroup, xOffset, material) {
        // Upper leg
        const upperLegGeometry = new THREE.CylinderGeometry(0.14, 0.16, 0.65, 16);
        const upperLeg = new THREE.Mesh(upperLegGeometry, material);
        upperLeg.position.set(xOffset, -0.5, 0);
        upperLeg.castShadow = true;
        upperLeg.receiveShadow = true;
        upperLeg.userData = { part: 'body', pieceType: 'pants' };
        parentGroup.add(upperLeg);

        // Lower leg
        const lowerLegGeometry = new THREE.CylinderGeometry(0.12, 0.14, 0.65, 16);
        const lowerLeg = new THREE.Mesh(lowerLegGeometry, material);
        lowerLeg.position.set(xOffset, -1.15, 0);
        lowerLeg.castShadow = true;
        lowerLeg.receiveShadow = true;
        lowerLeg.userData = { part: 'body', pieceType: 'pants' };
        parentGroup.add(lowerLeg);

        // Cuff
        const cuffGeometry = new THREE.TorusGeometry(0.14, 0.015, 8, 16);
        const cuffMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x333333,
            roughness: 0.9 
        });
        const cuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        cuff.position.set(xOffset, -1.48, 0);
        cuff.rotation.x = Math.PI / 2;
        cuff.castShadow = true;
        parentGroup.add(cuff);
    }

    createShorts(material, options) {
        const group = new THREE.Group();
        group.name = 'shorts';
        group.userData = { type: 'shorts', selectable: true };

        // Waistband
        const waistMaterial = options.waistColor 
            ? new THREE.MeshStandardMaterial({ 
                color: options.waistColor, 
                roughness: 0.8,
                metalness: 0.2 
            })
            : material.clone();
        
        const waistGeometry = new THREE.CylinderGeometry(0.42, 0.47, 0.12, 32);
        const waist = new THREE.Mesh(waistGeometry, waistMaterial);
        waist.position.y = -0.12;
        waist.scale.set(1, 1, 0.65);
        waist.castShadow = true;
        waist.userData = { part: 'waist', pieceType: 'shorts' };
        group.add(waist);

        // Legs (shorter than pants)
        this.createShortsLeg(group, -0.24, material);
        this.createShortsLeg(group, 0.24, material);

        group.userData.positions = {
            'left-leg': { x: -0.24, y: -0.3, z: 0.2 },
            'right-leg': { x: 0.24, y: -0.3, z: 0.2 },
            'waist': { x: 0, y: -0.12, z: 0.32 }
        };

        return group;
    }

    createShortsLeg(parentGroup, xOffset, material) {
        const legGeometry = new THREE.CylinderGeometry(0.17, 0.19, 0.45, 16);
        const leg = new THREE.Mesh(legGeometry, material);
        leg.position.set(xOffset, -0.4, 0);
        leg.castShadow = true;
        leg.receiveShadow = true;
        leg.userData = { part: 'body', pieceType: 'shorts' };
        parentGroup.add(leg);

        // Cuff/hem
        const cuffGeometry = new THREE.TorusGeometry(0.19, 0.02, 8, 16);
        const cuffMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x333333,
            roughness: 0.9 
        });
        const cuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        cuff.position.set(xOffset, -0.625, 0);
        cuff.rotation.x = Math.PI / 2;
        cuff.castShadow = true;
        parentGroup.add(cuff);
    }

    createJacket(material, options) {
        const group = new THREE.Group();
        group.name = 'jacket';
        group.userData = { type: 'jacket', selectable: true };

        // Main body (slightly larger than shirt)
        const bodyGeometry = new THREE.CylinderGeometry(0.48, 0.55, 1.1, 32);
        const body = new THREE.Mesh(bodyGeometry, material);
        body.position.y = 0.35;
        body.scale.set(1, 1, 0.75);
        body.castShadow = true;
        body.receiveShadow = true;
        body.userData = { part: 'body', pieceType: 'jacket' };
        group.add(body);

        // Collar (larger)
        const collarGeometry = new THREE.BoxGeometry(0.5, 0.15, 0.08);
        const collarMaterial = options.collarColor 
            ? new THREE.MeshStandardMaterial({ color: options.collarColor, roughness: 0.7 })
            : material.clone();
        const collar = new THREE.Mesh(collarGeometry, collarMaterial);
        collar.position.set(0, 0.95, 0.05);
        collar.rotation.x = -Math.PI / 6;
        collar.castShadow = true;
        collar.userData = { part: 'collar', pieceType: 'jacket' };
        group.add(collar);

        // Sleeves (longer)
        const sleeveMaterial = options.sleeveColor 
            ? new THREE.MeshStandardMaterial({ color: options.sleeveColor, roughness: 0.7 })
            : material.clone();
        
        this.createJacketSleeve(group, -0.7, sleeveMaterial);
        this.createJacketSleeve(group, 0.7, sleeveMaterial);

        // Zipper
        const zipperGeometry = new THREE.BoxGeometry(0.04, 1.0, 0.02);
        const zipperMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x888888,
            metalness: 0.8,
            roughness: 0.3 
        });
        const zipper = new THREE.Mesh(zipperGeometry, zipperMaterial);
        zipper.position.set(0, 0.35, 0.42);
        zipper.castShadow = true;
        group.add(zipper);

        // Pockets
        for (let side of [-1, 1]) {
            const pocketGeometry = new THREE.BoxGeometry(0.15, 0.18, 0.03);
            const pocket = new THREE.Mesh(pocketGeometry, material);
            pocket.position.set(side * 0.25, 0.05, 0.42);
            pocket.castShadow = true;
            group.add(pocket);
        }

        group.userData.positions = {
            'front-center': { x: 0, y: 0.6, z: 0.42 },
            'back-center': { x: 0, y: 0.6, z: -0.42 },
            'left-sleeve': { x: -0.7, y: 0.4, z: 0 },
            'right-sleeve': { x: 0.7, y: 0.4, z: 0 }
        };

        return group;
    }

    createJacketSleeve(parentGroup, xOffset, material) {
        const isLeft = xOffset < 0;
        const sign = isLeft ? -1 : 1;

        const sleeveGeometry = new THREE.CylinderGeometry(0.13, 0.15, 0.75, 16);
        const sleeve = new THREE.Mesh(sleeveGeometry, material);
        sleeve.position.set(xOffset, 0.35, 0);
        sleeve.rotation.z = sign * Math.PI / 10;
        sleeve.castShadow = true;
        sleeve.receiveShadow = true;
        sleeve.userData = { part: 'sleeves', pieceType: 'jacket' };
        parentGroup.add(sleeve);

        // Cuff
        const cuffGeometry = new THREE.TorusGeometry(0.15, 0.02, 8, 16);
        const cuffMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x333333,
            roughness: 0.9 
        });
        const cuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        cuff.position.set(xOffset + (sign * 0.04), -0.025, 0);
        cuff.rotation.x = Math.PI / 2;
        cuff.rotation.z = sign * Math.PI / 10;
        cuff.castShadow = true;
        parentGroup.add(cuff);
    }

    createShoes(material, options) {
        const group = new THREE.Group();
        group.name = 'shoes';
        group.userData = { type: 'shoes', selectable: true };

        // Create left and right shoes
        this.createShoe(group, -0.22, material, options);
        this.createShoe(group, 0.22, material, options);

        group.userData.positions = {
            'left-shoe': { x: -0.22, y: -1.55, z: 0.15 },
            'right-shoe': { x: 0.22, y: -1.55, z: 0.15 }
        };

        return group;
    }

    createShoe(parentGroup, xOffset, material, options) {
        // Main shoe body
        const shoeGeometry = new THREE.BoxGeometry(0.22, 0.18, 0.4);
        const shoe = new THREE.Mesh(shoeGeometry, material);
        shoe.position.set(xOffset, -1.55, 0.08);
        shoe.rotation.x = Math.PI / 20;
        shoe.castShadow = true;
        shoe.receiveShadow = true;
        shoe.userData = { part: 'body', pieceType: 'shoes' };
        parentGroup.add(shoe);

        // Toe cap
        const toeGeometry = new THREE.SphereGeometry(0.11, 12, 12, 0, Math.PI * 2, 0, Math.PI / 2);
        const toe = new THREE.Mesh(toeGeometry, material);
        toe.position.set(xOffset, -1.55, 0.26);
        toe.rotation.x = -Math.PI / 2;
        toe.castShadow = true;
        parentGroup.add(toe);

        // Sole
        const soleMaterial = options.soleColor 
            ? new THREE.MeshStandardMaterial({ 
                color: options.soleColor, 
                roughness: 0.9,
                metalness: 0.1 
            })
            : new THREE.MeshStandardMaterial({ color: 0x2c3e50, roughness: 0.9 });
        
        const soleGeometry = new THREE.BoxGeometry(0.24, 0.06, 0.42);
        const sole = new THREE.Mesh(soleGeometry, soleMaterial);
        sole.position.set(xOffset, -1.64, 0.08);
        sole.rotation.x = Math.PI / 20;
        sole.castShadow = true;
        sole.userData = { part: 'sole', pieceType: 'shoes' };
        parentGroup.add(sole);

        // Laces (decorative)
        const laceMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x333333,
            roughness: 0.7 
        });
        
        for (let i = 0; i < 3; i++) {
            const laceGeometry = new THREE.CylinderGeometry(0.01, 0.01, 0.15, 8);
            const lace = new THREE.Mesh(laceGeometry, laceMaterial);
            lace.position.set(xOffset, -1.45 - (i * 0.06), 0.15);
            lace.rotation.z = Math.PI / 2;
            lace.castShadow = true;
            parentGroup.add(lace);
        }
    }

    createSocks(material, options) {
        const group = new THREE.Group();
        group.name = 'socks';
        group.userData = { type: 'socks', selectable: true };

        // Create left and right socks
        this.createSock(group, -0.22, material, options);
        this.createSock(group, 0.22, material, options);

        group.userData.positions = {
            'left-sock': { x: -0.22, y: -1.35, z: 0.12 },
            'right-sock': { x: 0.22, y: -1.35, z: 0.12 }
        };

        return group;
    }

    createSock(parentGroup, xOffset, material, options) {
        // Main sock body
        const sockGeometry = new THREE.CylinderGeometry(0.105, 0.12, 0.35, 16);
        const sock = new THREE.Mesh(sockGeometry, material);
        sock.position.set(xOffset, -1.35, 0.05);
        sock.rotation.x = Math.PI / 15;
        sock.castShadow = true;
        sock.receiveShadow = true;
        sock.userData = { part: 'body', pieceType: 'socks' };
        parentGroup.add(sock);

        // Cuff
        const cuffMaterial = options.cuffColor 
            ? new THREE.MeshStandardMaterial({ 
                color: options.cuffColor, 
                roughness: 0.8 
            })
            : material.clone();
        
        const cuffGeometry = new THREE.CylinderGeometry(0.11, 0.105, 0.08, 16);
        const cuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        cuff.position.set(xOffset, -1.19, 0.05);
        cuff.rotation.x = Math.PI / 15;
        cuff.castShadow = true;
        cuff.userData = { part: 'cuff', pieceType: 'socks' };
        parentGroup.add(cuff);

        // Stripes (if specified)
        if (options.stripes) {
            const stripeMaterial = new THREE.MeshStandardMaterial({ 
                color: options.stripeColor || 0xffffff,
                roughness: 0.8 
            });
            
            for (let i = 0; i < 2; i++) {
                const stripeGeometry = new THREE.CylinderGeometry(0.106, 0.11, 0.03, 16);
                const stripe = new THREE.Mesh(stripeGeometry, stripeMaterial);
                stripe.position.set(xOffset, -1.24 - (i * 0.08), 0.05);
                stripe.rotation.x = Math.PI / 15;
                stripe.castShadow = true;
                parentGroup.add(stripe);
            }
        }
    }

    removeClothingPiece(pieceType) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            // Animate exit
            this.animatePieceExit(piece, () => {
                this.scene.remove(piece);
                this.clothingPieces.delete(pieceType);
                delete this.currentDesign.pieces[pieceType];
                console.log(`✗ Removed ${pieceType}`);
            });
        }
    }

    updateClothingColor(pieceType, color, part = 'body') {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            piece.traverse((child) => {
                if (child.isMesh && child.userData.pieceType === pieceType) {
                    if (!part || child.userData.part === part) {
                        // Animate color change
                        this.animateColorChange(child.material, color);
                    }
                }
            });
            
            if (!this.currentDesign.colors[pieceType]) {
                this.currentDesign.colors[pieceType] = {};
            }
            this.currentDesign.colors[pieceType][part] = color;
            
            console.log(`✓ Updated ${pieceType} ${part} color to ${color}`);
        }
    }

    updateClothingPattern(pieceType, pattern, options = {}) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            piece.traverse((child) => {
                if (child.isMesh && child.userData.pieceType === pieceType && child.userData.part === 'body') {
                    switch (pattern) {
                        case 'solid':
                            child.material.map = null;
                            break;
                        case 'stripes':
                            child.material.map = this.createStripesTexture(options);
                            break;
                        case 'dots':
                            child.material.map = this.createDotsTexture(options);
                            break;
                        case 'gradient':
                            child.material.map = this.createGradientTexture(options);
                            break;
                        case 'checkered':
                            child.material.map = this.createCheckeredTexture(options);
                            break;
                    }
                    child.material.needsUpdate = true;
                }
            });
            
            this.currentDesign.patterns[pieceType] = { type: pattern, options };
            console.log(`✓ Updated ${pieceType} pattern to ${pattern}`);
        }
    }

    // Texture generators
    createStripesTexture(options = {}) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 256;
        canvas.height = 256;
        
        const color1 = options.color1 || '#ffffff';
        const color2 = options.color2 || '#333333';
        const stripeWidth = options.stripeWidth || 16;
        const horizontal = options.horizontal || false;
        
        ctx.fillStyle = color1;
        ctx.fillRect(0, 0, 256, 256);
        
        ctx.fillStyle = color2;
        if (horizontal) {
            for (let i = 0; i < 256; i += stripeWidth * 2) {
                ctx.fillRect(0, i, 256, stripeWidth);
            }
        } else {
            for (let i = 0; i < 256; i += stripeWidth * 2) {
                ctx.fillRect(i, 0, stripeWidth, 256);
            }
        }
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(2, 2);
        return texture;
    }

    createDotsTexture(options = {}) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 256;
        canvas.height = 256;
        
        const bgColor = options.bgColor || '#ffffff';
        const dotColor = options.dotColor || '#333333';
        const dotSize = options.dotSize || 8;
        const spacing = options.spacing || 24;
        
        ctx.fillStyle = bgColor;
        ctx.fillRect(0, 0, 256, 256);
        
        ctx.fillStyle = dotColor;
        for (let x = spacing / 2; x < 256; x += spacing) {
            for (let y = spacing / 2; y < 256; y += spacing) {
                ctx.beginPath();
                ctx.arc(x, y, dotSize / 2, 0, Math.PI * 2);
                ctx.fill();
            }
        }
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(2, 2);
        return texture;
    }

    createGradientTexture(options = {}) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 256;
        canvas.height = 256;
        
        const color1 = options.color1 || '#667eea';
        const color2 = options.color2 || '#764ba2';
        const angle = options.angle || 45;
        
        const angleRad = (angle * Math.PI) / 180;
        const x1 = 128 - Math.cos(angleRad) * 128;
        const y1 = 128 - Math.sin(angleRad) * 128;
        const x2 = 128 + Math.cos(angleRad) * 128;
        const y2 = 128 + Math.sin(angleRad) * 128;
        
        const gradient = ctx.createLinearGradient(x1, y1, x2, y2);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, 256, 256);
        
        const texture = new THREE.CanvasTexture(canvas);
        return texture;
    }

    createCheckeredTexture(options = {}) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 256;
        canvas.height = 256;
        
        const color1 = options.color1 || '#ffffff';
        const color2 = options.color2 || '#333333';
        const squareSize = options.squareSize || 32;
        
        for (let x = 0; x < 256; x += squareSize) {
            for (let y = 0; y < 256; y += squareSize) {
                const isEven = ((x / squareSize) + (y / squareSize)) % 2 === 0;
                ctx.fillStyle = isEven ? color1 : color2;
                ctx.fillRect(x, y, squareSize, squareSize);
            }
        }
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(2, 2);
        return texture;
    }

    // Logo and text management
    async addLogo(pieceType, location, logoFile, options = {}) {
        if (!logoFile) return null;

        const reader = new FileReader();
        return new Promise((resolve) => {
            reader.onload = (e) => {
                const loader = new THREE.TextureLoader();
                loader.load(e.target.result, (texture) => {
                    const size = options.size || 0.2;
                    const aspectRatio = texture.image.width / texture.image.height;
                    
                    const logoGeometry = new THREE.PlaneGeometry(size * aspectRatio, size);
                    const logoMaterial = new THREE.MeshStandardMaterial({ 
                        map: texture, 
                        transparent: true,
                        alphaTest: 0.1,
                        side: THREE.DoubleSide,
                        roughness: 0.5,
                        metalness: 0.1
                    });
                    const logo = new THREE.Mesh(logoGeometry, logoMaterial);
                    
                    // Get position
                    const position = this.getPosition(pieceType, location);
                    if (position) {
                        logo.position.set(position.x, position.y, position.z);
                        logo.userData = { 
                            type: 'logo', 
                            selectable: true,
                            pieceType,
                            location,
                            size
                        };
                        
                        // Adjust rotation based on location
                        if (location.includes('back')) {
                            logo.rotation.y = Math.PI;
                        } else if (location.includes('sleeve')) {
                            logo.rotation.y = location.includes('left') ? Math.PI / 2 : -Math.PI / 2;
                        }
                        
                        this.scene.add(logo);
                        
                        // Store in design
                        this.currentDesign.logos.push({
                            pieceType,
                            location,
                            size,
                            mesh: logo
                        });
                        
                        // Animate entrance
                        this.animatePieceEntrance(logo);
                        
                        console.log(`✓ Added logo to ${pieceType} ${location}`);
                        resolve(logo);
                    }
                });
            };
            reader.readAsDataURL(logoFile);
        });
    }

    addText(pieceType, location, text, options = {}) {
        if (!text || text.trim() === '') return null;

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 1024;
        canvas.height = 256;
        
        const fontSize = options.fontSize || 80;
        const color = options.color || '#000000';
        const fontFamily = options.fontFamily || 'Arial';
        const fontWeight = options.fontWeight || 'bold';
        const textAlign = options.textAlign || 'center';
        const strokeColor = options.strokeColor || null;
        const strokeWidth = options.strokeWidth || 0;
        
        // Background (optional)
        if (options.backgroundColor && options.backgroundColor !== 'transparent') {
            ctx.fillStyle = options.backgroundColor;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }
        
        // Set text properties
        ctx.font = `${fontWeight} ${fontSize}px ${fontFamily}`;
        ctx.textAlign = textAlign;
        ctx.textBaseline = 'middle';
        ctx.fillStyle = color;
        
        const x = textAlign === 'center' ? canvas.width / 2 : textAlign === 'right' ? canvas.width - 50 : 50;
        const y = canvas.height / 2;
        
        // Draw stroke
        if (strokeColor && strokeWidth > 0) {
            ctx.strokeStyle = strokeColor;
            ctx.lineWidth = strokeWidth;
            ctx.strokeText(text, x, y);
        }
        
        // Draw text
        ctx.fillText(text, x, y);
        
        const texture = new THREE.CanvasTexture(canvas);
        const size = options.size || 0.3;
        const textGeometry = new THREE.PlaneGeometry(size * 4, size);
        const textMaterial = new THREE.MeshStandardMaterial({ 
            map: texture, 
            transparent: true,
            alphaTest: 0.1,
            side: THREE.DoubleSide,
            roughness: 0.5,
            metalness: 0.1
        });
        const textMesh = new THREE.Mesh(textGeometry, textMaterial);
        
        // Get position
        const position = this.getPosition(pieceType, location);
        if (position) {
            textMesh.position.set(position.x, position.y - 0.15, position.z);
            textMesh.userData = { 
                type: 'text', 
                selectable: true,
                pieceType,
                location,
                text,
                size
            };
            
            // Adjust rotation based on location
            if (location.includes('back')) {
                textMesh.rotation.y = Math.PI;
            } else if (location.includes('sleeve')) {
                textMesh.rotation.y = location.includes('left') ? Math.PI / 2 : -Math.PI / 2;
            }
            
            this.scene.add(textMesh);
            
            // Store in design
            this.currentDesign.texts.push({
                pieceType,
                location,
                text,
                options,
                mesh: textMesh
            });
            
            // Animate entrance
            this.animatePieceEntrance(textMesh);
            
            console.log(`✓ Added text "${text}" to ${pieceType} ${location}`);
            return textMesh;
        }
        
        return null;
    }

    getPosition(pieceType, location) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece && piece.userData.positions) {
            return piece.userData.positions[location] || null;
        }
        return null;
    }

    removeLogo(index) {
        if (index >= 0 && index < this.currentDesign.logos.length) {
            const logo = this.currentDesign.logos[index];
            this.scene.remove(logo.mesh);
            this.currentDesign.logos.splice(index, 1);
            console.log(`✗ Removed logo at index ${index}`);
        }
    }

    removeText(index) {
        if (index >= 0 && index < this.currentDesign.texts.length) {
            const text = this.currentDesign.texts[index];
            this.scene.remove(text.mesh);
            this.currentDesign.texts.splice(index, 1);
            console.log(`✗ Removed text at index ${index}`);
        }
    }

    selectPiece(piece) {
        // Deselect previous piece
        if (this.selectedPiece && this.selectedPiece.material) {
            if (this.selectedPiece.material.emissive) {
                this.selectedPiece.material.emissive.setHex(0x000000);
            }
        }
        
        // Select new piece
        this.selectedPiece = piece;
        if (piece && piece.material && piece.material.emissive) {
            piece.material.emissive.setHex(0x444444);
        }
        
        // Emit event
        if (piece && piece.userData) {
            const event = new CustomEvent('pieceSelected', { 
                detail: { 
                    type: piece.userData.type,
                    part: piece.userData.part 
                } 
            });
            window.dispatchEvent(event);
        }
    }

    // Animation methods
    animatePieceEntrance(piece) {
        piece.scale.set(0, 0, 0);
        piece.userData.targetScale = { x: 1, y: 1, z: 1 };
        piece.userData.animating = true;
        piece.userData.animationStart = Date.now();
        piece.userData.animationDuration = 500; // ms
    }

    animatePieceExit(piece, callback) {
        piece.userData.targetScale = { x: 0, y: 0, z: 0 };
        piece.userData.animating = true;
        piece.userData.animationStart = Date.now();
        piece.userData.animationDuration = 300; // ms
        piece.userData.onComplete = callback;
    }

    animateColorChange(material, newColor) {
        const currentColor = material.color.clone();
        const targetColor = new THREE.Color(newColor);
        
        material.userData.startColor = currentColor;
        material.userData.targetColor = targetColor;
        material.userData.animating = true;
        material.userData.animationStart = Date.now();
        material.userData.animationDuration = 500; // ms
    }

    updateAnimations() {
        const now = Date.now();
        
        // Update object animations
        this.scene.traverse((object) => {
            if (object.userData.animating) {
                const elapsed = now - object.userData.animationStart;
                const progress = Math.min(elapsed / object.userData.animationDuration, 1);
                const eased = this.easeInOutCubic(progress);
                
                if (object.userData.targetScale) {
                    object.scale.lerp(
                        new THREE.Vector3(
                            object.userData.targetScale.x,
                            object.userData.targetScale.y,
                            object.userData.targetScale.z
                        ),
                        eased
                    );
                }
                
                if (progress >= 1) {
                    object.userData.animating = false;
                    if (object.userData.onComplete) {
                        object.userData.onComplete();
                        delete object.userData.onComplete;
                    }
                }
            }
            
            // Update material color animations
            if (object.material && object.material.userData.animating) {
                const material = object.material;
                const elapsed = now - material.userData.animationStart;
                const progress = Math.min(elapsed / material.userData.animationDuration, 1);
                const eased = this.easeInOutCubic(progress);
                
                material.color.lerpColors(
                    material.userData.startColor,
                    material.userData.targetColor,
                    eased
                );
                
                if (progress >= 1) {
                    material.userData.animating = false;
                }
            }
        });
    }

    easeInOutCubic(t) {
        return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }

    // Control methods
    rotateModel(axis, angle) {
        if (this.humanModel) {
            switch (axis) {
                case 'x':
                    this.humanModel.rotation.x += angle;
                    break;
                case 'y':
                    this.humanModel.rotation.y += angle;
                    break;
                case 'z':
                    this.humanModel.rotation.z += angle;
                    break;
            }
        }
    }

    resetView() {
        if (this.controls) {
            this.controls.reset();
        }
        if (this.humanModel) {
            this.humanModel.rotation.set(0, 0.1, 0);
        }
        console.log('✓ View reset');
    }

    toggleAutoRotate() {
        if (this.controls) {
            this.controls.autoRotate = !this.controls.autoRotate;
            console.log(`✓ Auto-rotate ${this.controls.autoRotate ? 'enabled' : 'disabled'}`);
            return this.controls.autoRotate;
        }
        return false;
    }

    setView(view) {
        if (!this.controls) return;
        
        const distance = 6;
        const target = new THREE.Vector3(0, 0.5, 0);
        
        switch (view) {
            case 'front':
                this.camera.position.set(0, 0.5, distance);
                break;
            case 'back':
                this.camera.position.set(0, 0.5, -distance);
                break;
            case 'left':
                this.camera.position.set(-distance, 0.5, 0);
                break;
            case 'right':
                this.camera.position.set(distance, 0.5, 0);
                break;
            case 'top':
                this.camera.position.set(0, distance, 0);
                break;
        }
        
        this.camera.lookAt(target);
        this.controls.target.copy(target);
        this.controls.update();
        
        console.log(`✓ View set to ${view}`);
    }

    toggleGrid() {
        const grid = this.scene.getObjectByName('gridHelper');
        if (grid) {
            grid.visible = !grid.visible;
            return grid.visible;
        }
        return false;
    }

    // Export design data
    exportDesign() {
        return {
            pieces: this.currentDesign.pieces,
            colors: this.currentDesign.colors,
            patterns: this.currentDesign.patterns,
            logos: this.currentDesign.logos.map(l => ({
                pieceType: l.pieceType,
                location: l.location,
                size: l.size
            })),
            texts: this.currentDesign.texts.map(t => ({
                pieceType: t.pieceType,
                location: t.location,
                text: t.text,
                options: t.options
            }))
        };
    }

    // Screenshot/render
    captureScreenshot() {
        this.renderer.render(this.scene, this.camera);
        return this.renderer.domElement.toDataURL('image/png');
    }

    // Window resize handler
    onWindowResize() {
        if (!this.container || !this.camera || !this.renderer) return;
        
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        
        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
    }

    // Animation loop
    animate() {
        requestAnimationFrame(() => this.animate());
        
        if (this.controls) {
            this.controls.update();
        }
        
        if (this.animationMixer) {
            const delta = this.clock.getDelta();
            this.animationMixer.update(delta);
        }
        
        // Update custom animations
        this.updateAnimations();
        
        if (this.renderer && this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
        }
    }

    // Cleanup
    dispose() {
        if (this.renderer) {
            this.renderer.dispose();
        }
        
        if (this.controls) {
            this.controls.dispose();
        }
        
        this.clothingPieces.clear();
        this.accessories.clear();
        
        console.log('✓ 3D Viewer disposed');
    }
}

// Export to window
window.Enhanced3DViewer = Enhanced3DViewer;

