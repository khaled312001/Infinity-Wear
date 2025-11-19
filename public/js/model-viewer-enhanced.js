/**
 * Enhanced 3D Model Viewer with better mannequin
 */

class EnhancedModelViewer {
    constructor(containerId) {
        this.containerId = containerId;
        this.container = document.getElementById(containerId);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.mannequin = null;
        this.clothingMeshes = {};
        this.autoRotate = false;
        this.init();
    }

    init() {
        if (!this.container) {
            console.error('Container not found:', this.containerId);
            return;
        }

        this.setupScene();
        this.setupCamera();
        this.setupRenderer();
        this.setupLights();
        this.setupControls();
        this.createEnhancedMannequin();
        this.animate();
        this.addHelperButtons();
    }

    setupScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0xf3f4f6);
        
        // Add fog for depth
        this.scene.fog = new THREE.Fog(0xf3f4f6, 5, 15);
    }

    setupCamera() {
        const aspect = this.container.clientWidth / this.container.clientHeight;
        this.camera = new THREE.PerspectiveCamera(45, aspect, 0.1, 100);
        this.camera.position.set(0, 1.6, 4);
        this.camera.lookAt(0, 1, 0);
    }

    setupRenderer() {
        this.renderer = new THREE.WebGLRenderer({ 
            antialias: true,
            alpha: true
        });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.container.appendChild(this.renderer.domElement);
    }

    setupLights() {
        // Ambient light
        const ambient = new THREE.AmbientLight(0xffffff, 0.6);
        this.scene.add(ambient);

        // Main directional light
        const mainLight = new THREE.DirectionalLight(0xffffff, 0.8);
        mainLight.position.set(5, 10, 5);
        mainLight.castShadow = true;
        mainLight.shadow.mapSize.width = 2048;
        mainLight.shadow.mapSize.height = 2048;
        mainLight.shadow.camera.near = 0.5;
        mainLight.shadow.camera.far = 50;
        this.scene.add(mainLight);

        // Fill light
        const fillLight = new THREE.DirectionalLight(0xffffff, 0.3);
        fillLight.position.set(-5, 5, -5);
        this.scene.add(fillLight);

        // Back light for rim lighting
        const backLight = new THREE.DirectionalLight(0xffffff, 0.4);
        backLight.position.set(0, 5, -5);
        this.scene.add(backLight);
    }

    setupControls() {
        if (typeof THREE.OrbitControls !== 'undefined') {
            this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
            this.controls.enableDamping = true;
            this.controls.dampingFactor = 0.05;
            this.controls.minDistance = 2;
            this.controls.maxDistance = 8;
            this.controls.maxPolarAngle = Math.PI / 2 + 0.2;
            this.controls.target.set(0, 1, 0);
            this.controls.update();
        }
    }

    createEnhancedMannequin() {
        this.mannequin = new THREE.Group();

        // Body parts materials
        const skinMaterial = new THREE.MeshPhongMaterial({ 
            color: 0xf5deb3,
            shininess: 5
        });

        const defaultClothMaterial = new THREE.MeshPhongMaterial({ 
            color: 0xe0e0e0,
            shininess: 10
        });

        // Head
        const headGeometry = new THREE.SphereGeometry(0.18, 16, 16);
        const head = new THREE.Mesh(headGeometry, skinMaterial);
        head.position.y = 1.7;
        head.castShadow = true;
        this.mannequin.add(head);

        // Neck
        const neckGeometry = new THREE.CylinderGeometry(0.08, 0.1, 0.15, 8);
        const neck = new THREE.Mesh(neckGeometry, skinMaterial);
        neck.position.y = 1.52;
        neck.castShadow = true;
        this.mannequin.add(neck);

        // Torso (shirt area)
        const torsoGeometry = new THREE.CylinderGeometry(0.25, 0.3, 0.8, 12);
        const torso = new THREE.Mesh(torsoGeometry, defaultClothMaterial.clone());
        torso.position.y = 1;
        torso.castShadow = true;
        torso.userData.type = 'shirt';
        this.mannequin.add(torso);
        this.clothingMeshes.shirt = torso;

        // Shoulders
        const shoulderGeometry = new THREE.SphereGeometry(0.12, 12, 12);
        
        const leftShoulder = new THREE.Mesh(shoulderGeometry, defaultClothMaterial.clone());
        leftShoulder.position.set(-0.37, 1.3, 0);
        leftShoulder.castShadow = true;
        this.mannequin.add(leftShoulder);

        const rightShoulder = new THREE.Mesh(shoulderGeometry, defaultClothMaterial.clone());
        rightShoulder.position.set(0.37, 1.3, 0);
        rightShoulder.castShadow = true;
        this.mannequin.add(rightShoulder);

        // Arms
        const armGeometry = new THREE.CylinderGeometry(0.06, 0.055, 0.7, 8);
        
        const leftArm = new THREE.Mesh(armGeometry, skinMaterial);
        leftArm.position.set(-0.37, 0.85, 0);
        leftArm.rotation.z = 0.1;
        leftArm.castShadow = true;
        this.mannequin.add(leftArm);

        const rightArm = new THREE.Mesh(armGeometry, skinMaterial);
        rightArm.position.set(0.37, 0.85, 0);
        rightArm.rotation.z = -0.1;
        rightArm.castShadow = true;
        this.mannequin.add(rightArm);

        // Hands
        const handGeometry = new THREE.SphereGeometry(0.07, 8, 8);
        
        const leftHand = new THREE.Mesh(handGeometry, skinMaterial);
        leftHand.position.set(-0.42, 0.5, 0);
        leftHand.castShadow = true;
        this.mannequin.add(leftHand);

        const rightHand = new THREE.Mesh(handGeometry, skinMaterial);
        rightHand.position.set(0.42, 0.5, 0);
        rightHand.castShadow = true;
        this.mannequin.add(rightHand);

        // Hips (shorts/pants area)
        const hipsGeometry = new THREE.CylinderGeometry(0.3, 0.25, 0.3, 12);
        const hips = new THREE.Mesh(hipsGeometry, defaultClothMaterial.clone());
        hips.position.y = 0.45;
        hips.castShadow = true;
        hips.userData.type = 'shorts';
        this.mannequin.add(hips);
        this.clothingMeshes.shorts = hips;
        this.clothingMeshes.pants = hips;

        // Legs (pants area)
        const legGeometry = new THREE.CylinderGeometry(0.1, 0.08, 0.85, 10);
        
        const leftLeg = new THREE.Mesh(legGeometry, defaultClothMaterial.clone());
        leftLeg.position.set(-0.12, -0.15, 0);
        leftLeg.castShadow = true;
        leftLeg.userData.type = 'pants';
        this.mannequin.add(leftLeg);
        this.clothingMeshes.leftLeg = leftLeg;

        const rightLeg = new THREE.Mesh(legGeometry, defaultClothMaterial.clone());
        rightLeg.position.set(0.12, -0.15, 0);
        rightLeg.castShadow = true;
        rightLeg.userData.type = 'pants';
        this.mannequin.add(rightLeg);
        this.clothingMeshes.rightLeg = rightLeg;

        // Feet (shoes area)
        const footGeometry = new THREE.BoxGeometry(0.12, 0.08, 0.2);
        
        const leftFoot = new THREE.Mesh(footGeometry, new THREE.MeshPhongMaterial({ color: 0x333333 }));
        leftFoot.position.set(-0.12, -0.6, 0.05);
        leftFoot.castShadow = true;
        leftFoot.userData.type = 'shoes';
        this.mannequin.add(leftFoot);
        this.clothingMeshes.leftShoe = leftFoot;

        const rightFoot = new THREE.Mesh(footGeometry, new THREE.MeshPhongMaterial({ color: 0x333333 }));
        rightFoot.position.set(0.12, -0.6, 0.05);
        rightFoot.castShadow = true;
        rightFoot.userData.type = 'shoes';
        this.mannequin.add(rightFoot);
        this.clothingMeshes.rightShoe = rightFoot;

        // Ground plane
        const planeGeometry = new THREE.CircleGeometry(5, 32);
        const planeMaterial = new THREE.ShadowMaterial({ opacity: 0.2 });
        const plane = new THREE.Mesh(planeGeometry, planeMaterial);
        plane.rotation.x = -Math.PI / 2;
        plane.position.y = -0.7;
        plane.receiveShadow = true;
        this.mannequin.add(plane);

        this.scene.add(this.mannequin);
    }

    updateClothingColor(piece, color) {
        const mesh = this.clothingMeshes[piece];
        if (mesh && mesh.material) {
            mesh.material.color.set(color);
            mesh.material.needsUpdate = true;
        }

        // Update related pieces
        if (piece === 'shorts' || piece === 'pants') {
            ['leftLeg', 'rightLeg'].forEach(leg => {
                const legMesh = this.clothingMeshes[leg];
                if (legMesh && legMesh.material) {
                    legMesh.material.color.set(color);
                    legMesh.material.needsUpdate = true;
                }
            });
        }

        if (piece === 'shoes') {
            ['leftShoe', 'rightShoe'].forEach(shoe => {
                const shoeMesh = this.clothingMeshes[shoe];
                if (shoeMesh && shoeMesh.material) {
                    shoeMesh.material.color.set(color);
                    shoeMesh.material.needsUpdate = true;
                }
            });
        }
    }

    rotate(degrees) {
        if (this.mannequin) {
            this.mannequin.rotation.y += THREE.MathUtils.degToRad(degrees);
        }
    }

    zoom(factor) {
        if (this.camera) {
            const newDistance = this.camera.position.length() * factor;
            if (newDistance >= 2 && newDistance <= 8) {
                this.camera.position.multiplyScalar(factor);
            }
        }
    }

    reset() {
        if (this.camera && this.controls) {
            this.camera.position.set(0, 1.6, 4);
            this.camera.lookAt(0, 1, 0);
            this.controls.target.set(0, 1, 0);
            this.controls.update();
        }
        if (this.mannequin) {
            this.mannequin.rotation.set(0, 0, 0);
        }
    }

    toggleAutoRotate() {
        this.autoRotate = !this.autoRotate;
        return this.autoRotate;
    }

    addHelperButtons() {
        // Add screenshot button
        const screenshotBtn = document.createElement('button');
        screenshotBtn.className = 'screenshot-btn';
        screenshotBtn.innerHTML = '<i class="fas fa-camera"></i> التقاط صورة';
        screenshotBtn.onclick = () => this.takeScreenshot();
        this.container.appendChild(screenshotBtn);

        // Add auto-rotate toggle
        const autoRotateBtn = document.createElement('button');
        autoRotateBtn.className = 'auto-rotate-toggle';
        autoRotateBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
        autoRotateBtn.onclick = () => {
            const isActive = this.toggleAutoRotate();
            autoRotateBtn.classList.toggle('active', isActive);
        };
        this.container.appendChild(autoRotateBtn);
    }

    takeScreenshot() {
        if (this.renderer) {
            const imgData = this.renderer.domElement.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'infinity-wear-design.png';
            link.href = imgData;
            link.click();
        }
    }

    animate() {
        requestAnimationFrame(() => this.animate());

        if (this.controls) {
            this.controls.update();
        }

        if (this.autoRotate && this.mannequin) {
            this.mannequin.rotation.y += 0.005;
        }

        if (this.renderer && this.scene && this.camera) {
            this.renderer.render(this.scene, this.camera);
        }
    }

    onWindowResize() {
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
        if (this.controls) {
            this.controls.dispose();
        }
        // Clean up geometries and materials
        this.scene.traverse((object) => {
            if (object.geometry) {
                object.geometry.dispose();
            }
            if (object.material) {
                if (Array.isArray(object.material)) {
                    object.material.forEach(material => material.dispose());
                } else {
                    object.material.dispose();
                }
            }
        });
    }
}

// Make it globally available
window.EnhancedModelViewer = EnhancedModelViewer;

