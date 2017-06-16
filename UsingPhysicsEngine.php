<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Physics Engine</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
        <!-- --------------------------------------------------------------- -->
        <script type="text/javascript" src="assets/lib/physi.js"></script>
        <!-- --------------------------------------------------------------- -->
        
        <style>
            #webgl-container {
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <nav><a href="index.php">Go Back</a></nav>
        <div id="webgl-container"></div>
        
        <script type="text/javascript">
            "use strict";

            // -----------------------------------------------------------------
            Physijs.scripts.worker = 'physijs_worker.js';
            Physijs.scripts.ammo = 'ammo.js';

            let scene = new Physijs.Scene();
            // -----------------------------------------------------------------
            let renderer = window.WebGLRenderingContext ? new THREE.WebGLRenderer() : new THREE.CanvasRenderer();
            let light = new THREE.DirectionalLight(0xffffff);
            let camera = null;
            let box = null;

            function initScene() {
                // -----------------------------------------------------------------
                scene.setGravity(0, -50, 0);
                // -----------------------------------------------------------------
                
                renderer.setSize(window.innerWidth, window.innerHeight);
                renderer.shadowMapEnabled = true; 
                document.getElementById("webgl-container").appendChild(renderer.domElement);
                light.castShadow = true;  
                light.shadowMapWidth = 2048; 
                light.shadowMapHeight = 2048; 
                light.position.set(0, 100, 30);
                scene.add(light);

                camera = new THREE.PerspectiveCamera(
                            35,
                            window.innerWidth / window.innerHeight,
                            1,
                            1000
                        );

                camera.position.set(60, 50, 60);
                camera.lookAt(scene.position);
                scene.add(camera);

                // -----------------------------------------------------------------
                let boxMaterial = Physijs.createMaterial(
                            new THREE.MeshStandardMaterial({ color: 0xFF0000 }),
                            0,      // Friction
                            0.8     // Bounciness
                        );

                box = new Physijs.BoxMesh(new THREE.CubeGeometry(15, 15, 15), boxMaterial);
                box.name = "box";
                box.castShadow = true; 
                box.position.y = 40;
                box.rotation.z = 90;
                box.rotation.y = 50;
                scene.add(box);
                
                box.addEventListener("collision", function(otherObject, relativeVelocity, relativeRotation, contactNormal) {
                    if (otherObject.name === "ground") {
                        console.log("The Olympus has fallen");
                    }
                });
                
                let groundMaterial = Physijs.createMaterial(
                            new THREE.MeshStandardMaterial({ color: 0x008888 }),
                            0,        // Friction
                            0.6       // Bounciness
                        );
                
                let ground = new Physijs.BoxMesh(
                            new THREE.CubeGeometry(150, 5, 150),
                            groundMaterial,
                            0
                        );
                
                ground.name = "ground";
                ground.castShadow = true;
                ground.position.y -= 25;
                scene.add(ground);
                
                // -----------------------------------------------------------------

                window.requestAnimationFrame(render);
            }

            function render() {
                // -----------------------------------------------------------------
                scene.simulate();
                // -----------------------------------------------------------------
                
                renderer.render(scene, camera);
                window.requestAnimationFrame(render);
            }

            (function main() {
                window.onload = initScene;

                return {
                    scene: scene
                }

            }) ();
        </script>
        
        <script src="assets/js/app.js"></script>
    </body>
</html>
