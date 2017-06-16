<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Collusion Detection</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
        
        <style>
            #webgl-container {
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <nav><a href="index.php">Go Back</a></nav>
        <h1 id="result">Use [LEFT ARROW] or [RIGHT ARROW]</h1>
        <div id="webgl-container"></div>
        
        <script type="text/javascript">
            "use strict";

            let scene = new THREE.Scene();
            let renderer = window.WebGLRenderingContext ? new THREE.WebGLRenderer() : new THREE.CanvasRenderer();
            let light = new THREE.DirectionalLight(0xffffff);
            let camera = null;
            let box1 = null;
            let box2 = null;

            function initScene() {
                renderer.setSize(window.innerWidth, window.innerHeight);
                renderer.shadowMapEnabled = true; 
                document.getElementById("webgl-container").appendChild(renderer.domElement);
                light.castShadow = true;  
                light.shadowMapWidth = 2048; 
                light.shadowMapHeight = 2048; 
                light.position.z = 100;
                scene.add(light);

                camera = new THREE.PerspectiveCamera(
                            35,
                            window.innerWidth / window.innerHeight,
                            1,
                            1000
                        );

                camera.position.z = 100;
                scene.add(camera);

                box1 = new THREE.Mesh(
                            new THREE.BoxGeometry(20, 20, 20),
                            new THREE.MeshStandardMaterial({ color: 0xFF0000 })
                        );
                box1.name = "box 1";
                box1.castShadow = true; 
                box1.position.x -= 15;
                scene.add(box1);
                
                box2 = new THREE.Mesh(
                            new THREE.BoxGeometry(20, 20, 20),
                            new THREE.MeshStandardMaterial({ color: 0x00FF00 })
                        );
                box2.name = "box 2";
                box2.castShadow = true; 
                box2.position.x += 15;
                scene.add(box2);

                render();
            }

            function render() {
                renderer.render(scene, camera);
                requestAnimationFrame(render);
            }
            
            function checkKey(event) {
                let left      = 37;
                let right     = 39;
                let increment = 1;

                if (event.keyCode === left) {
                    box1.position.x -= increment;
                }
                else if (event.keyCode === right) {
                    box1.position.x += increment;
                }
                
                // -----------------------------------------------------------------
                checkForCollusion();
                // -----------------------------------------------------------------
            }
            
            // -----------------------------------------------------------------
            function checkForCollusion() {
                let box1Position = new THREE.Box3().setFromObject(box1);
                let box2Position = new THREE.Box3().setFromObject(box2);
                
                let result = "";
                
                if (box1Position.isIntersectionBox(box2Position)) {
                    result = "Touching";
                }
                else {
                    result = "Not Touching";
                }
                
                document.getElementById("result").innerHTML = result;
                console.log(result);
            }
            // -----------------------------------------------------------------

            (function main() {
                window.onload = initScene;
                window.addEventListener("keydown", checkKey);

                return {
                    scene: scene
                }

            }) ();
        </script>
        
        <script src="assets/js/app.js"></script>
    </body>
</html>
