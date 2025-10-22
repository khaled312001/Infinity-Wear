/**
 * 3D Design Viewer for Infinity Wear
 * Advanced 3D clothing design interface
 */

class Design3DViewer {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.model = null;
        this.clothingPieces = new Map();
        this.selectedPiece = null;
        this.rotation = { x: 0, y: 0, z: 0 };
        this.zoom = 1;
        this.isRotating = false;
        this.mousePosition = { x: 0, y: 0 };
        
        this.init();
    }

    init() {
        if (!this.container) {
            console.error('3D Viewer container not found');
            return;
        }

        this.setupScene();
        this.setupCamera();
        this.setupRenderer();
        this.setupLighting();
        this.setupControls();
        this.animate();
    }

    setupScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0xf8f9fa);
    }

    setupCamera() {
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        
        this.camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
        this.camera.position.set(0, 0, 5);
    }

    setupRenderer() {
        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        
        // Set size with proper dimensions
        const width = this.container.clientWidth || 400;
        const height = this.container.clientHeight || 400;
        
        this.renderer.setSize(width, height);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        
        // Clear any existing content
        this.container.innerHTML = '';
        this.container.appendChild(this.renderer.domElement);
        
        console.log('3D Renderer setup complete:', width, 'x', height);
    }

    setupLighting() {
        // Ambient light
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
        this.scene.add(ambientLight);

        // Directional light
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight.position.set(10, 10, 5);
        directionalLight.castShadow = true;
        directionalLight.shadow.mapSize.width = 2048;
        directionalLight.shadow.mapSize.height = 2048;
        this.scene.add(directionalLight);

        // Point light for better illumination
        const pointLight = new THREE.PointLight(0xffffff, 0.5);
        pointLight.position.set(-10, 10, 10);
        this.scene.add(pointLight);
    }

    setupControls() {
        // Mouse controls for rotation
        this.container.addEventListener('mousedown', (e) => this.onMouseDown(e));
        this.container.addEventListener('mousemove', (e) => this.onMouseMove(e));
        this.container.addEventListener('mouseup', (e) => this.onMouseUp(e));
        this.container.addEventListener('wheel', (e) => this.onWheel(e));

        // Touch controls for mobile
        this.container.addEventListener('touchstart', (e) => this.onTouchStart(e));
        this.container.addEventListener('touchmove', (e) => this.onTouchMove(e));
        this.container.addEventListener('touchend', (e) => this.onTouchEnd(e));
    }

    loadHumanModel() {
        try {
            // Create a professional human figure with better proportions
            const humanGroup = new THREE.Group();

        // Head with better shape
        const headGeometry = new THREE.SphereGeometry(0.25, 32, 32);
        const headMaterial = new THREE.MeshLambertMaterial({ 
            color: 0xffdbac,
            shininess: 30
        });
        const head = new THREE.Mesh(headGeometry, headMaterial);
        head.position.y = 1.4;
        head.castShadow = true;
        humanGroup.add(head);

        // Neck
        const neckGeometry = new THREE.CylinderGeometry(0.08, 0.1, 0.15, 16);
        const neckMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        const neck = new THREE.Mesh(neckGeometry, neckMaterial);
        neck.position.y = 1.2;
        neck.castShadow = true;
        humanGroup.add(neck);

        // Torso with better proportions
        const torsoGeometry = new THREE.CylinderGeometry(0.35, 0.4, 1.0, 32);
        const torsoMaterial = new THREE.MeshLambertMaterial({ 
            color: 0xffdbac,
            shininess: 20
        });
        const torso = new THREE.Mesh(torsoGeometry, torsoMaterial);
        torso.position.y = 0.4;
        torso.castShadow = true;
        humanGroup.add(torso);

        // Shoulders
        const shoulderGeometry = new THREE.SphereGeometry(0.15, 16, 16);
        const shoulderMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        
        const leftShoulder = new THREE.Mesh(shoulderGeometry, shoulderMaterial);
        leftShoulder.position.set(-0.5, 0.8, 0);
        leftShoulder.castShadow = true;
        humanGroup.add(leftShoulder);

        const rightShoulder = new THREE.Mesh(shoulderGeometry, shoulderMaterial);
        rightShoulder.position.set(0.5, 0.8, 0);
        rightShoulder.castShadow = true;
        humanGroup.add(rightShoulder);

        // Arms with better positioning
        const upperArmGeometry = new THREE.CylinderGeometry(0.08, 0.1, 0.4, 16);
        const lowerArmGeometry = new THREE.CylinderGeometry(0.06, 0.08, 0.35, 16);
        const armMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        
        // Left arm
        const leftUpperArm = new THREE.Mesh(upperArmGeometry, armMaterial);
        leftUpperArm.position.set(-0.6, 0.5, 0);
        leftUpperArm.rotation.z = Math.PI / 6;
        leftUpperArm.castShadow = true;
        humanGroup.add(leftUpperArm);

        const leftLowerArm = new THREE.Mesh(lowerArmGeometry, armMaterial);
        leftLowerArm.position.set(-0.8, 0.2, 0);
        leftLowerArm.rotation.z = Math.PI / 4;
        leftLowerArm.castShadow = true;
        humanGroup.add(leftLowerArm);

        // Right arm
        const rightUpperArm = new THREE.Mesh(upperArmGeometry, armMaterial);
        rightUpperArm.position.set(0.6, 0.5, 0);
        rightUpperArm.rotation.z = -Math.PI / 6;
        rightUpperArm.castShadow = true;
        humanGroup.add(rightUpperArm);

        const rightLowerArm = new THREE.Mesh(lowerArmGeometry, armMaterial);
        rightLowerArm.position.set(0.8, 0.2, 0);
        rightLowerArm.rotation.z = -Math.PI / 4;
        rightLowerArm.castShadow = true;
        humanGroup.add(rightLowerArm);

        // Legs with better proportions
        const upperLegGeometry = new THREE.CylinderGeometry(0.1, 0.12, 0.5, 16);
        const lowerLegGeometry = new THREE.CylinderGeometry(0.08, 0.1, 0.45, 16);
        const legMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        
        // Left leg
        const leftUpperLeg = new THREE.Mesh(upperLegGeometry, legMaterial);
        leftUpperLeg.position.set(-0.15, -0.2, 0);
        leftUpperLeg.castShadow = true;
        humanGroup.add(leftUpperLeg);

        const leftLowerLeg = new THREE.Mesh(lowerLegGeometry, legMaterial);
        leftLowerLeg.position.set(-0.15, -0.7, 0);
        leftLowerLeg.castShadow = true;
        humanGroup.add(leftLowerLeg);

        // Right leg
        const rightUpperLeg = new THREE.Mesh(upperLegGeometry, legMaterial);
        rightUpperLeg.position.set(0.15, -0.2, 0);
        rightUpperLeg.castShadow = true;
        humanGroup.add(rightUpperLeg);

        const rightLowerLeg = new THREE.Mesh(lowerLegGeometry, legMaterial);
        rightLowerLeg.position.set(0.15, -0.7, 0);
        rightLowerLeg.castShadow = true;
        humanGroup.add(rightLowerLeg);

        // Add subtle rotation for better presentation
        humanGroup.rotation.y = Math.PI / 8;

        this.model = humanGroup;
        this.scene.add(this.model);
        
        console.log('Human model loaded successfully');
        } catch (error) {
            console.error('Error loading human model:', error);
        }
    }

    addClothingPiece(pieceType, options = {}) {
        const piece = this.createClothingPiece(pieceType, options);
        if (piece) {
            this.clothingPieces.set(pieceType, piece);
            this.scene.add(piece);
            return piece;
        }
        return null;
    }

    createClothingPiece(pieceType, options) {
        const group = new THREE.Group();
        const color = options.color || 0x666666;
        const material = new THREE.MeshLambertMaterial({ color: color });

        switch (pieceType) {
            case 'shirt':
                return this.createShirt(group, material, options);
            case 'pants':
                return this.createPants(group, material, options);
            case 'shorts':
                return this.createShorts(group, material, options);
            case 'jacket':
                return this.createJacket(group, material, options);
            case 'shoes':
                return this.createShoes(group, material, options);
            case 'socks':
                return this.createSocks(group, material, options);
            default:
                return null;
        }
    }

    createShirt(group, material, options) {
        // Shirt body with better fit
        const bodyGeometry = new THREE.CylinderGeometry(0.38, 0.42, 0.9, 32);
        const body = new THREE.Mesh(bodyGeometry, material);
        body.position.y = 0.3;
        body.castShadow = true;
        body.userData = { pieceType: 'shirt', part: 'body' };
        group.add(body);

        // Collar
        const collarGeometry = new THREE.CylinderGeometry(0.4, 0.4, 0.1, 32);
        const collarMaterial = new THREE.MeshLambertMaterial({ 
            color: options.collarColor || 0xffffff 
        });
        const collar = new THREE.Mesh(collarGeometry, collarMaterial);
        collar.position.y = 0.8;
        collar.castShadow = true;
        collar.userData = { pieceType: 'shirt', part: 'collar' };
        group.add(collar);

        // Sleeves with better positioning
        const sleeveGeometry = new THREE.CylinderGeometry(0.1, 0.12, 0.5, 16);
        const sleeveMaterial = new THREE.MeshLambertMaterial({ 
            color: options.sleeveColor || material.color 
        });
        
        const leftSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        leftSleeve.position.set(-0.6, 0.4, 0);
        leftSleeve.rotation.z = Math.PI / 8;
        leftSleeve.castShadow = true;
        leftSleeve.userData = { pieceType: 'shirt', part: 'sleeves' };
        group.add(leftSleeve);

        const rightSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        rightSleeve.position.set(0.6, 0.4, 0);
        rightSleeve.rotation.z = -Math.PI / 8;
        rightSleeve.castShadow = true;
        rightSleeve.userData = { pieceType: 'shirt', part: 'sleeves' };
        group.add(rightSleeve);

        // Trim details
        const trimGeometry = new THREE.TorusGeometry(0.42, 0.02, 8, 16);
        const trimMaterial = new THREE.MeshLambertMaterial({ color: 0x000000 });
        const trim = new THREE.Mesh(trimGeometry, trimMaterial);
        trim.position.y = 0.3;
        trim.castShadow = true;
        trim.userData = { pieceType: 'shirt', part: 'trim' };
        group.add(trim);

        // Add positioning data for logos and text
        group.userData = { 
            type: 'shirt', 
            selectable: true,
            positions: {
                front: { x: 0, y: 0.5, z: 0.42 },
                back: { x: 0, y: 0.5, z: -0.42 },
                leftSleeve: { x: -0.6, y: 0.4, z: 0.12 },
                rightSleeve: { x: 0.6, y: 0.4, z: 0.12 },
                collar: { x: 0, y: 0.8, z: 0.4 }
            }
        };
        return group;
    }

    createPants(group, material, options) {
        // Left leg with better fit
        const legGeometry = new THREE.CylinderGeometry(0.12, 0.15, 0.7, 16);
        const leftLeg = new THREE.Mesh(legGeometry, material);
        leftLeg.position.set(-0.15, -0.3, 0);
        leftLeg.castShadow = true;
        leftLeg.userData = { pieceType: 'pants', part: 'body' };
        group.add(leftLeg);

        // Right leg
        const rightLeg = new THREE.Mesh(legGeometry, material);
        rightLeg.position.set(0.15, -0.3, 0);
        rightLeg.castShadow = true;
        rightLeg.userData = { pieceType: 'pants', part: 'body' };
        group.add(rightLeg);

        // Waistband
        const waistGeometry = new THREE.CylinderGeometry(0.4, 0.4, 0.08, 32);
        const waistMaterial = new THREE.MeshLambertMaterial({ 
            color: options.waistColor || material.color 
        });
        const waist = new THREE.Mesh(waistGeometry, waistMaterial);
        waist.position.y = 0.05;
        waist.castShadow = true;
        waist.userData = { pieceType: 'pants', part: 'waist' };
        group.add(waist);

        // Belt loops
        for (let i = 0; i < 4; i++) {
            const loopGeometry = new THREE.BoxGeometry(0.02, 0.05, 0.02);
            const loopMaterial = new THREE.MeshLambertMaterial({ color: 0x8B4513 });
            const loop = new THREE.Mesh(loopGeometry, loopMaterial);
            loop.position.set(-0.15 + (i * 0.1), 0.08, 0.4);
            group.add(loop);
        }

        group.userData = { 
            type: 'pants', 
            selectable: true,
            positions: {
                leftLeg: { x: -0.15, y: -0.1, z: 0.15 },
                rightLeg: { x: 0.15, y: -0.1, z: 0.15 },
                waist: { x: 0, y: 0.05, z: 0.4 }
            }
        };
        return group;
    }

    createShorts(group, material, options) {
        // Similar to pants but shorter
        const legGeometry = new THREE.CylinderGeometry(0.15, 0.18, 0.4, 16);
        const leftLeg = new THREE.Mesh(legGeometry, material);
        leftLeg.position.set(-0.2, -0.2, 0);
        leftLeg.userData = { pieceType: 'shorts', part: 'body' };
        group.add(leftLeg);

        const rightLeg = new THREE.Mesh(legGeometry, material);
        rightLeg.position.set(0.2, -0.2, 0);
        rightLeg.userData = { pieceType: 'shorts', part: 'body' };
        group.add(rightLeg);

        const waistGeometry = new THREE.CylinderGeometry(0.5, 0.5, 0.1, 32);
        const waistMaterial = new THREE.MeshLambertMaterial({ 
            color: options.waistColor || material.color 
        });
        const waist = new THREE.Mesh(waistGeometry, waistMaterial);
        waist.position.y = 0.1;
        waist.userData = { pieceType: 'shorts', part: 'waist' };
        group.add(waist);

        group.userData = { type: 'shorts', selectable: true };
        return group;
    }

    createJacket(group, material, options) {
        // Jacket body
        const bodyGeometry = new THREE.CylinderGeometry(0.48, 0.52, 0.9, 32);
        const body = new THREE.Mesh(bodyGeometry, material);
        body.position.y = 0.25;
        body.userData = { pieceType: 'jacket', part: 'body' };
        group.add(body);

        // Jacket sleeves (longer than shirt)
        const sleeveGeometry = new THREE.CylinderGeometry(0.13, 0.16, 0.7, 16);
        const sleeveMaterial = new THREE.MeshLambertMaterial({ 
            color: options.sleeveColor || material.color 
        });
        
        const leftSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        leftSleeve.position.set(-0.7, 0.25, 0);
        leftSleeve.rotation.z = Math.PI / 8;
        leftSleeve.userData = { pieceType: 'jacket', part: 'sleeves' };
        group.add(leftSleeve);

        const rightSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        rightSleeve.position.set(0.7, 0.25, 0);
        rightSleeve.rotation.z = -Math.PI / 8;
        rightSleeve.userData = { pieceType: 'jacket', part: 'sleeves' };
        group.add(rightSleeve);

        group.userData = { type: 'jacket', selectable: true };
        return group;
    }

    createShoes(group, material, options) {
        // Left shoe
        const shoeGeometry = new THREE.BoxGeometry(0.3, 0.15, 0.6);
        const leftShoe = new THREE.Mesh(shoeGeometry, material);
        leftShoe.position.set(-0.2, -1.0, 0.1);
        leftShoe.rotation.x = Math.PI / 12;
        leftShoe.userData = { pieceType: 'shoes', part: 'body' };
        group.add(leftShoe);

        // Right shoe
        const rightShoe = new THREE.Mesh(shoeGeometry, material);
        rightShoe.position.set(0.2, -1.0, 0.1);
        rightShoe.rotation.x = Math.PI / 12;
        rightShoe.userData = { pieceType: 'shoes', part: 'body' };
        group.add(rightShoe);

        // Shoe soles
        const soleGeometry = new THREE.BoxGeometry(0.32, 0.05, 0.62);
        const soleMaterial = new THREE.MeshLambertMaterial({ 
            color: options.soleColor || 0x2c3e50 
        });
        
        const leftSole = new THREE.Mesh(soleGeometry, soleMaterial);
        leftSole.position.set(-0.2, -1.08, 0.1);
        leftSole.rotation.x = Math.PI / 12;
        leftSole.userData = { pieceType: 'shoes', part: 'sole' };
        group.add(leftSole);

        const rightSole = new THREE.Mesh(soleGeometry, soleMaterial);
        rightSole.position.set(0.2, -1.08, 0.1);
        rightSole.rotation.x = Math.PI / 12;
        rightSole.userData = { pieceType: 'shoes', part: 'sole' };
        group.add(rightSole);

        group.userData = { type: 'shoes', selectable: true };
        return group;
    }

    createSocks(group, material, options) {
        // Left sock
        const sockGeometry = new THREE.CylinderGeometry(0.08, 0.1, 0.3, 16);
        const leftSock = new THREE.Mesh(sockGeometry, material);
        leftSock.position.set(-0.15, -0.9, 0.05);
        leftSock.rotation.x = Math.PI / 12;
        leftSock.castShadow = true;
        leftSock.userData = { pieceType: 'socks', part: 'body' };
        group.add(leftSock);

        // Right sock
        const rightSock = new THREE.Mesh(sockGeometry, material);
        rightSock.position.set(0.15, -0.9, 0.05);
        rightSock.rotation.x = Math.PI / 12;
        rightSock.castShadow = true;
        rightSock.userData = { pieceType: 'socks', part: 'body' };
        group.add(rightSock);

        // Sock cuffs
        const cuffGeometry = new THREE.CylinderGeometry(0.09, 0.11, 0.05, 16);
        const cuffMaterial = new THREE.MeshLambertMaterial({ 
            color: options.cuffColor || material.color 
        });
        
        const leftCuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        leftCuff.position.set(-0.15, -0.75, 0.05);
        leftCuff.rotation.x = Math.PI / 12;
        leftCuff.userData = { pieceType: 'socks', part: 'cuff' };
        group.add(leftCuff);

        const rightCuff = new THREE.Mesh(cuffGeometry, cuffMaterial);
        rightCuff.position.set(0.15, -0.75, 0.05);
        rightCuff.rotation.x = Math.PI / 12;
        rightCuff.userData = { pieceType: 'socks', part: 'cuff' };
        group.add(rightCuff);

        group.userData = { 
            type: 'socks', 
            selectable: true,
            positions: {
                leftSock: { x: -0.15, y: -0.9, z: 0.1 },
                rightSock: { x: 0.15, y: -0.9, z: 0.1 }
            }
        };
        return group;
    }

    removeClothingPiece(pieceType) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            this.scene.remove(piece);
            this.clothingPieces.delete(pieceType);
        }
    }

    updateClothingPieceColor(pieceType, color, part = 'body') {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            piece.traverse((child) => {
                if (child.isMesh) {
                    // Check if this mesh matches the specific part we want to color
                    if (!part || child.userData.part === part) {
                        child.material.color.setHex(color.replace('#', '0x'));
                    }
                }
            });
        }
    }

    updateClothingPiecePattern(pieceType, pattern) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            piece.traverse((child) => {
                if (child.isMesh) {
                    // Update material based on pattern
                    switch (pattern) {
                        case 'solid':
                            child.material.map = null;
                            break;
                        case 'stripes':
                            child.material.map = this.createStripesTexture();
                            break;
                        case 'dots':
                            child.material.map = this.createDotsTexture();
                            break;
                        case 'gradient':
                            child.material.map = this.createGradientTexture();
                            break;
                    }
                    child.material.needsUpdate = true;
                }
            });
        }
    }

    createStripesTexture() {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = 64;
        canvas.height = 64;
        
        context.fillStyle = '#ffffff';
        context.fillRect(0, 0, 64, 64);
        
        context.fillStyle = '#000000';
        for (let i = 0; i < 64; i += 8) {
            context.fillRect(i, 0, 4, 64);
        }
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(4, 4);
        return texture;
    }

    createDotsTexture() {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = 64;
        canvas.height = 64;
        
        context.fillStyle = '#ffffff';
        context.fillRect(0, 0, 64, 64);
        
        context.fillStyle = '#000000';
        for (let x = 0; x < 64; x += 8) {
            for (let y = 0; y < 64; y += 8) {
                context.beginPath();
                context.arc(x + 4, y + 4, 2, 0, Math.PI * 2);
                context.fill();
            }
        }
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(4, 4);
        return texture;
    }

    createGradientTexture() {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = 64;
        canvas.height = 64;
        
        const gradient = context.createLinearGradient(0, 0, 64, 64);
        gradient.addColorStop(0, '#667eea');
        gradient.addColorStop(1, '#764ba2');
        
        context.fillStyle = gradient;
        context.fillRect(0, 0, 64, 64);
        
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        return texture;
    }

    addLogo(logoUrl, options = {}) {
        const loader = new THREE.TextureLoader();
        loader.load(logoUrl, (texture) => {
            const size = options.size || 0.15;
            const logoGeometry = new THREE.PlaneGeometry(size, size);
            const logoMaterial = new THREE.MeshLambertMaterial({ 
                map: texture, 
                transparent: true,
                alphaTest: 0.1
            });
            const logo = new THREE.Mesh(logoGeometry, logoMaterial);
            
            // Get position based on piece and location
            const position = this.getLogoPosition(options.pieceType, options.location);
            logo.position.set(position.x, position.y, position.z);
            
            // Apply rotation if needed
            if (options.rotation) {
                logo.rotation.set(options.rotation.x, options.rotation.y, options.rotation.z);
            }
            
            logo.userData = { 
                type: 'logo', 
                selectable: true,
                pieceType: options.pieceType,
                location: options.location,
                size: size
            };
            
            this.scene.add(logo);
            return logo;
        });
    }

    getLogoPosition(pieceType, location) {
        const positions = {
            'shirt': {
                'front': { x: 0, y: 0.5, z: 0.42 },
                'back': { x: 0, y: 0.5, z: -0.42 },
                'leftSleeve': { x: -0.6, y: 0.4, z: 0.12 },
                'rightSleeve': { x: 0.6, y: 0.4, z: 0.12 },
                'collar': { x: 0, y: 0.8, z: 0.4 }
            },
            'pants': {
                'leftLeg': { x: -0.15, y: -0.1, z: 0.15 },
                'rightLeg': { x: 0.15, y: -0.1, z: 0.15 },
                'waist': { x: 0, y: 0.05, z: 0.4 }
            },
            'shorts': {
                'leftLeg': { x: -0.15, y: -0.05, z: 0.15 },
                'rightLeg': { x: 0.15, y: -0.05, z: 0.15 },
                'waist': { x: 0, y: 0.05, z: 0.4 }
            },
            'socks': {
                'leftSock': { x: -0.15, y: -0.9, z: 0.1 },
                'rightSock': { x: 0.15, y: -0.9, z: 0.1 }
            }
        };
        
        return positions[pieceType]?.[location] || { x: 0, y: 0.5, z: 0.5 };
    }

    addText(text, options = {}) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        const size = options.size || 0.2;
        const fontSize = options.fontSize || 24;
        const color = options.color || '#000000';
        const backgroundColor = options.backgroundColor || 'transparent';
        
        canvas.width = 512;
        canvas.height = 128;
        
        // Set background
        if (backgroundColor !== 'transparent') {
            context.fillStyle = backgroundColor;
            context.fillRect(0, 0, canvas.width, canvas.height);
        }
        
        // Set text properties
        context.fillStyle = color;
        context.font = `${fontSize}px Arial`;
        context.textAlign = 'center';
        context.textBaseline = 'middle';
        
        // Add text stroke if specified
        if (options.strokeColor) {
            context.strokeStyle = options.strokeColor;
            context.lineWidth = options.strokeWidth || 2;
            context.strokeText(text, canvas.width / 2, canvas.height / 2);
        }
        
        context.fillText(text, canvas.width / 2, canvas.height / 2);
        
        const texture = new THREE.CanvasTexture(canvas);
        const textGeometry = new THREE.PlaneGeometry(size, size * 0.25);
        const textMaterial = new THREE.MeshLambertMaterial({ 
            map: texture, 
            transparent: true,
            alphaTest: 0.1
        });
        const textMesh = new THREE.Mesh(textGeometry, textMaterial);
        
        // Get position based on piece and location
        const position = this.getTextPosition(options.pieceType, options.location);
        textMesh.position.set(position.x, position.y, position.z);
        
        // Apply rotation if needed
        if (options.rotation) {
            textMesh.rotation.set(options.rotation.x, options.rotation.y, options.rotation.z);
        }
        
        textMesh.userData = { 
            type: 'text', 
            selectable: true,
            pieceType: options.pieceType,
            location: options.location,
            text: text,
            size: size
        };
        
        this.scene.add(textMesh);
        return textMesh;
    }

    getTextPosition(pieceType, location) {
        const positions = {
            'shirt': {
                'front': { x: 0, y: 0.3, z: 0.42 },
                'back': { x: 0, y: 0.3, z: -0.42 },
                'leftSleeve': { x: -0.6, y: 0.4, z: 0.12 },
                'rightSleeve': { x: 0.6, y: 0.4, z: 0.12 },
                'collar': { x: 0, y: 0.8, z: 0.4 }
            },
            'pants': {
                'leftLeg': { x: -0.15, y: -0.1, z: 0.15 },
                'rightLeg': { x: 0.15, y: -0.1, z: 0.15 },
                'waist': { x: 0, y: 0.05, z: 0.4 }
            },
            'socks': {
                'leftSock': { x: -0.15, y: -0.9, z: 0.1 },
                'rightSock': { x: 0.15, y: -0.9, z: 0.1 }
            }
        };
        
        return positions[pieceType]?.[location] || { x: 0, y: 0.3, z: 0.5 };
    }

    selectPiece(piece) {
        if (this.selectedPiece) {
            this.selectedPiece.material.emissive.setHex(0x000000);
        }
        
        this.selectedPiece = piece;
        if (piece && piece.material) {
            piece.material.emissive.setHex(0x333333);
        }
    }

    rotateModel(deltaX, deltaY) {
        if (this.model) {
            this.model.rotation.y += deltaX * 0.01;
            this.model.rotation.x += deltaY * 0.01;
        }
    }

    zoomModel(delta) {
        this.zoom += delta * 0.01;
        this.zoom = Math.max(0.5, Math.min(3, this.zoom));
        
        if (this.camera) {
            this.camera.position.z = 5 / this.zoom;
        }
    }

    resetView() {
        this.rotation = { x: 0, y: 0, z: 0 };
        this.zoom = 1;
        
        if (this.model) {
            this.model.rotation.set(0, 0, 0);
        }
        
        if (this.camera) {
            this.camera.position.set(0, 0, 5);
        }
    }

    // Event handlers
    onMouseDown(event) {
        this.isRotating = true;
        this.mousePosition.x = event.clientX;
        this.mousePosition.y = event.clientY;
    }

    onMouseMove(event) {
        if (this.isRotating) {
            const deltaX = event.clientX - this.mousePosition.x;
            const deltaY = event.clientY - this.mousePosition.y;
            this.rotateModel(deltaX, deltaY);
            this.mousePosition.x = event.clientX;
            this.mousePosition.y = event.clientY;
        }
    }

    onMouseUp(event) {
        this.isRotating = false;
    }

    onWheel(event) {
        event.preventDefault();
        const delta = event.deltaY > 0 ? 1 : -1;
        this.zoomModel(delta);
    }

    onTouchStart(event) {
        if (event.touches.length === 1) {
            this.isRotating = true;
            this.mousePosition.x = event.touches[0].clientX;
            this.mousePosition.y = event.touches[0].clientY;
        }
    }

    onTouchMove(event) {
        if (this.isRotating && event.touches.length === 1) {
            const deltaX = event.touches[0].clientX - this.mousePosition.x;
            const deltaY = event.touches[0].clientY - this.mousePosition.y;
            this.rotateModel(deltaX, deltaY);
            this.mousePosition.x = event.touches[0].clientX;
            this.mousePosition.y = event.touches[0].clientY;
        }
    }

    onTouchEnd(event) {
        this.isRotating = false;
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        
        if (this.renderer && this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
        }
    }

    resize() {
        if (!this.container || !this.camera || !this.renderer) return;
        
        const width = this.container.clientWidth;
        const height = this.container.clientHeight;
        
        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(width, height);
        
        console.log('3D Viewer resized to:', width, 'x', height);
    }

    dispose() {
        if (this.renderer) {
            this.renderer.dispose();
        }
        
        this.clothingPieces.clear();
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.model = null;
    }
}

// Export for use in other modules
window.Design3DViewer = Design3DViewer;
