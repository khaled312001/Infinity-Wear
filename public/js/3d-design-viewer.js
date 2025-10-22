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
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        
        this.container.appendChild(this.renderer.domElement);
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
        // Create a basic human figure using geometric shapes
        const humanGroup = new THREE.Group();

        // Head
        const headGeometry = new THREE.SphereGeometry(0.3, 32, 32);
        const headMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        const head = new THREE.Mesh(headGeometry, headMaterial);
        head.position.y = 1.5;
        humanGroup.add(head);

        // Body
        const bodyGeometry = new THREE.CylinderGeometry(0.4, 0.5, 1.2, 32);
        const bodyMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
        body.position.y = 0.3;
        humanGroup.add(body);

        // Arms
        const armGeometry = new THREE.CylinderGeometry(0.1, 0.12, 0.8, 16);
        const armMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        
        const leftArm = new THREE.Mesh(armGeometry, armMaterial);
        leftArm.position.set(-0.6, 0.3, 0);
        leftArm.rotation.z = Math.PI / 4;
        humanGroup.add(leftArm);

        const rightArm = new THREE.Mesh(armGeometry, armMaterial);
        rightArm.position.set(0.6, 0.3, 0);
        rightArm.rotation.z = -Math.PI / 4;
        humanGroup.add(rightArm);

        // Legs
        const legGeometry = new THREE.CylinderGeometry(0.12, 0.15, 1.0, 16);
        const legMaterial = new THREE.MeshLambertMaterial({ color: 0xffdbac });
        
        const leftLeg = new THREE.Mesh(legGeometry, legMaterial);
        leftLeg.position.set(-0.2, -0.8, 0);
        humanGroup.add(leftLeg);

        const rightLeg = new THREE.Mesh(legGeometry, legMaterial);
        rightLeg.position.set(0.2, -0.8, 0);
        humanGroup.add(rightLeg);

        this.model = humanGroup;
        this.scene.add(this.model);
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
            default:
                return null;
        }
    }

    createShirt(group, material, options) {
        // Shirt body
        const bodyGeometry = new THREE.CylinderGeometry(0.45, 0.5, 0.8, 32);
        const body = new THREE.Mesh(bodyGeometry, material);
        body.position.y = 0.2;
        group.add(body);

        // Sleeves
        const sleeveGeometry = new THREE.CylinderGeometry(0.12, 0.15, 0.6, 16);
        const sleeveMaterial = new THREE.MeshLambertMaterial({ color: material.color });
        
        const leftSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        leftSleeve.position.set(-0.65, 0.2, 0);
        leftSleeve.rotation.z = Math.PI / 6;
        group.add(leftSleeve);

        const rightSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        rightSleeve.position.set(0.65, 0.2, 0);
        rightSleeve.rotation.z = -Math.PI / 6;
        group.add(rightSleeve);

        group.userData = { type: 'shirt', selectable: true };
        return group;
    }

    createPants(group, material, options) {
        // Left leg
        const legGeometry = new THREE.CylinderGeometry(0.15, 0.18, 0.8, 16);
        const leftLeg = new THREE.Mesh(legGeometry, material);
        leftLeg.position.set(-0.2, -0.4, 0);
        group.add(leftLeg);

        // Right leg
        const rightLeg = new THREE.Mesh(legGeometry, material);
        rightLeg.position.set(0.2, -0.4, 0);
        group.add(rightLeg);

        // Waistband
        const waistGeometry = new THREE.CylinderGeometry(0.5, 0.5, 0.1, 32);
        const waistMaterial = new THREE.MeshLambertMaterial({ color: material.color });
        const waist = new THREE.Mesh(waistGeometry, waistMaterial);
        waist.position.y = 0.1;
        group.add(waist);

        group.userData = { type: 'pants', selectable: true };
        return group;
    }

    createShorts(group, material, options) {
        // Similar to pants but shorter
        const legGeometry = new THREE.CylinderGeometry(0.15, 0.18, 0.4, 16);
        const leftLeg = new THREE.Mesh(legGeometry, material);
        leftLeg.position.set(-0.2, -0.2, 0);
        group.add(leftLeg);

        const rightLeg = new THREE.Mesh(legGeometry, material);
        rightLeg.position.set(0.2, -0.2, 0);
        group.add(rightLeg);

        const waistGeometry = new THREE.CylinderGeometry(0.5, 0.5, 0.1, 32);
        const waistMaterial = new THREE.MeshLambertMaterial({ color: material.color });
        const waist = new THREE.Mesh(waistGeometry, waistMaterial);
        waist.position.y = 0.1;
        group.add(waist);

        group.userData = { type: 'shorts', selectable: true };
        return group;
    }

    createJacket(group, material, options) {
        // Jacket body
        const bodyGeometry = new THREE.CylinderGeometry(0.48, 0.52, 0.9, 32);
        const body = new THREE.Mesh(bodyGeometry, material);
        body.position.y = 0.25;
        group.add(body);

        // Jacket sleeves (longer than shirt)
        const sleeveGeometry = new THREE.CylinderGeometry(0.13, 0.16, 0.7, 16);
        const sleeveMaterial = new THREE.MeshLambertMaterial({ color: material.color });
        
        const leftSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        leftSleeve.position.set(-0.7, 0.25, 0);
        leftSleeve.rotation.z = Math.PI / 8;
        group.add(leftSleeve);

        const rightSleeve = new THREE.Mesh(sleeveGeometry, sleeveMaterial);
        rightSleeve.position.set(0.7, 0.25, 0);
        rightSleeve.rotation.z = -Math.PI / 8;
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
        group.add(leftShoe);

        // Right shoe
        const rightShoe = new THREE.Mesh(shoeGeometry, material);
        rightShoe.position.set(0.2, -1.0, 0.1);
        rightShoe.rotation.x = Math.PI / 12;
        group.add(rightShoe);

        group.userData = { type: 'shoes', selectable: true };
        return group;
    }

    removeClothingPiece(pieceType) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            this.scene.remove(piece);
            this.clothingPieces.delete(pieceType);
        }
    }

    updateClothingPieceColor(pieceType, color) {
        const piece = this.clothingPieces.get(pieceType);
        if (piece) {
            piece.traverse((child) => {
                if (child.isMesh) {
                    child.material.color.setHex(color);
                }
            });
        }
    }

    addLogo(logoUrl, position = { x: 0, y: 0.5, z: 0.5 }) {
        const loader = new THREE.TextureLoader();
        loader.load(logoUrl, (texture) => {
            const logoGeometry = new THREE.PlaneGeometry(0.3, 0.3);
            const logoMaterial = new THREE.MeshLambertMaterial({ 
                map: texture, 
                transparent: true 
            });
            const logo = new THREE.Mesh(logoGeometry, logoMaterial);
            logo.position.set(position.x, position.y, position.z);
            logo.userData = { type: 'logo', selectable: false };
            this.scene.add(logo);
        });
    }

    addText(text, position = { x: 0, y: 0.3, z: 0.5 }) {
        const loader = new THREE.FontLoader();
        // For now, we'll use a simple plane with text texture
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = 256;
        canvas.height = 64;
        
        context.fillStyle = '#000000';
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.fillStyle = '#ffffff';
        context.font = '24px Arial';
        context.textAlign = 'center';
        context.fillText(text, canvas.width / 2, canvas.height / 2 + 8);
        
        const texture = new THREE.CanvasTexture(canvas);
        const textGeometry = new THREE.PlaneGeometry(0.4, 0.1);
        const textMaterial = new THREE.MeshLambertMaterial({ 
            map: texture, 
            transparent: true 
        });
        const textMesh = new THREE.Mesh(textGeometry, textMaterial);
        textMesh.position.set(position.x, position.y, position.z);
        textMesh.userData = { type: 'text', selectable: false };
        this.scene.add(textMesh);
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
        if (this.container && this.camera && this.renderer) {
            const width = this.container.clientWidth;
            const height = this.container.clientHeight;
            
            this.camera.aspect = width / height;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(width, height);
        }
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
