/**
 * Realistic Human Avatar Creator
 * Creates a detailed 3D human model with realistic proportions
 */

export function createRealisticHuman(scene) {
    const humanGroup = new THREE.Group();
    humanGroup.name = 'realisticHuman';

    // Materials
    const skinMaterial = new THREE.MeshStandardMaterial({
        color: 0xffd5b4,
        roughness: 0.6,
        metalness: 0.05,
        envMapIntensity: 0.5
    });

    const hairMaterial = new THREE.MeshStandardMaterial({
        color: 0x3d2817,
        roughness: 0.9,
        metalness: 0.1
    });

    // Head with detailed features
    const headGroup = new THREE.Group();
    
    // Main head
    const headGeo = new THREE.SphereGeometry(0.25, 32, 32);
    const head = new THREE.Mesh(headGeo, skinMaterial);
    head.scale.set(1, 1.15, 0.95);
    head.position.y = 1.55;
    head.castShadow = true;
    headGroup.add(head);

    // Face details
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
    const neckGeo = new THREE.CylinderGeometry(0.1, 0.12, 0.25, 16);
    const neck = new THREE.Mesh(neckGeo, skinMaterial);
    neck.position.y = 1.3;
    neck.castShadow = true;
    humanGroup.add(neck);

    // Torso - more anatomical
    const torsoGeo = new THREE.CylinderGeometry(0.38, 0.42, 0.7, 32);
    const torso = new THREE.Mesh(torsoGeo, skinMaterial);
    torso.position.y = 0.7;
    torso.scale.set(1, 1, 0.7);
    torso.castShadow = true;
    torso.receiveShadow = true;
    humanGroup.add(torso);

    // Chest detail
    const chestGeo = new THREE.SphereGeometry(0.4, 32, 32, 0, Math.PI * 2, 0, Math.PI / 2);
    const chest = new THREE.Mesh(chestGeo, skinMaterial);
    chest.position.y = 0.9;
    chest.position.z = 0.05;
    chest.rotation.x = -Math.PI / 12;
    chest.castShadow = true;
    humanGroup.add(chest);

    // Waist
    const waistGeo = new THREE.CylinderGeometry(0.35, 0.38, 0.3, 32);
    const waist = new THREE.Mesh(waistGeo, skinMaterial);
    waist.position.y = 0.2;
    waist.scale.set(1, 1, 0.65);
    waist.castShadow = true;
    humanGroup.add(waist);

    // Shoulders
    createShoulder(humanGroup, -0.52, skinMaterial);
    createShoulder(humanGroup, 0.52, skinMaterial);

    // Arms
    createArm(humanGroup, -0.6, skinMaterial, true);
    createArm(humanGroup, 0.6, skinMaterial, false);

    // Hips
    const hipsGeo = new THREE.CylinderGeometry(0.38, 0.42, 0.25, 32);
    const hips = new THREE.Mesh(hipsGeo, skinMaterial);
    hips.position.y = 0.05;
    hips.scale.set(1, 1, 0.6);
    hips.castShadow = true;
    humanGroup.add(hips);

    // Legs
    createLeg(humanGroup, -0.2, skinMaterial);
    createLeg(humanGroup, 0.2, skinMaterial);

    // Feet
    createFoot(humanGroup, -0.2, skinMaterial);
    createFoot(humanGroup, 0.2, skinMaterial);

    humanGroup.position.y = 0.1;
    
    return humanGroup;
}

function createShoulder(parent, xOffset, material) {
    const shoulderGeo = new THREE.SphereGeometry(0.15, 16, 16);
    const shoulder = new THREE.Mesh(shoulderGeo, material);
    shoulder.position.set(xOffset, 0.95, 0);
    shoulder.castShadow = true;
    parent.add(shoulder);
}

function createArm(parent, xOffset, material, isLeft) {
    const sign = isLeft ? -1 : 1;
    
    // Upper arm
    const upperArmGeo = new THREE.CylinderGeometry(0.08, 0.1, 0.45, 16);
    const upperArm = new THREE.Mesh(upperArmGeo, material);
    upperArm.position.set(xOffset, 0.6, 0);
    upperArm.rotation.z = sign * Math.PI / 15;
    upperArm.castShadow = true;
    parent.add(upperArm);

    // Elbow
    const elbowGeo = new THREE.SphereGeometry(0.085, 12, 12);
    const elbow = new THREE.Mesh(elbowGeo, material);
    elbow.position.set(xOffset + (sign * 0.05), 0.35, 0);
    elbow.castShadow = true;
    parent.add(elbow);

    // Lower arm
    const lowerArmGeo = new THREE.CylinderGeometry(0.07, 0.08, 0.4, 16);
    const lowerArm = new THREE.Mesh(lowerArmGeo, material);
    lowerArm.position.set(xOffset + (sign * 0.1), 0.1, 0.05);
    lowerArm.rotation.z = sign * Math.PI / 12;
    lowerArm.castShadow = true;
    parent.add(lowerArm);

    // Hand
    const handGeo = new THREE.SphereGeometry(0.075, 16, 16);
    handGeo.scale(1.2, 1.4, 0.7);
    const hand = new THREE.Mesh(handGeo, material);
    hand.position.set(xOffset + (sign * 0.15), -0.1, 0.08);
    hand.castShadow = true;
    parent.add(hand);

    // Fingers (simplified)
    for (let i = 0; i < 5; i++) {
        const fingerGeo = new THREE.CylinderGeometry(0.008, 0.006, 0.05, 8);
        const finger = new THREE.Mesh(fingerGeo, material);
        finger.position.set(
            xOffset + (sign * 0.15) + (i - 2) * 0.015,
            -0.13,
            0.13
        );
        finger.rotation.x = Math.PI / 6;
        parent.add(finger);
    }
}

function createLeg(parent, xOffset, material) {
    // Upper leg
    const upperLegGeo = new THREE.CylinderGeometry(0.11, 0.13, 0.55, 16);
    const upperLeg = new THREE.Mesh(upperLegGeo, material);
    upperLeg.position.set(xOffset, -0.35, 0);
    upperLeg.castShadow = true;
    parent.add(upperLeg);

    // Knee
    const kneeGeo = new THREE.SphereGeometry(0.11, 12, 12);
    const knee = new THREE.Mesh(kneeGeo, material);
    knee.position.set(xOffset, -0.65, 0);
    knee.castShadow = true;
    parent.add(knee);

    // Lower leg
    const lowerLegGeo = new THREE.CylinderGeometry(0.09, 0.1, 0.55, 16);
    const lowerLeg = new THREE.Mesh(lowerLegGeo, material);
    lowerLeg.position.set(xOffset, -0.95, 0);
    lowerLeg.castShadow = true;
    parent.add(lowerLeg);

    // Ankle
    const ankleGeo = new THREE.SphereGeometry(0.08, 12, 12);
    const ankle = new THREE.Mesh(ankleGeo, material);
    ankle.position.set(xOffset, -1.225, 0);
    ankle.castShadow = true;
    parent.add(ankle);
}

function createFoot(parent, xOffset, material) {
    const footGeo = new THREE.BoxGeometry(0.15, 0.1, 0.3);
    const foot = new THREE.Mesh(footGeo, material);
    foot.position.set(xOffset, -1.28, 0.07);
    foot.castShadow = true;
    foot.receiveShadow = true;
    parent.add(foot);

    // Toes
    for (let i = 0; i < 5; i++) {
        const toeGeo = new THREE.SphereGeometry(0.015, 8, 8);
        toeGeo.scale(1, 0.7, 1.2);
        const toe = new THREE.Mesh(toeGeo, material);
        toe.position.set(
            xOffset + (i - 2) * 0.02,
            -1.32,
            0.2
        );
        parent.add(toe);
    }
}

// Export for use in other modules
if (typeof window !== 'undefined') {
    window.createRealisticHuman = createRealisticHuman;
}

