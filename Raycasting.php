<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Scene Interaction</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
        <script type="text/javascript" src="assets/lib/stats.js/stats.min.js"></script>
        <script type="text/javascript" src="assets/lib/Projector.js"></script>
        
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
            
            let width = 800;
            let height = 600;
            let scene = new THREE.Scene();
            let renderer = window.WebGLRenderingContext ? new THREE.WebGLRenderer() : new THREE.CanvasRenderer();
            let light = new THREE.DirectionalLight(0xffffff);
            let camera = null;
            let stats = null;
            let myObject = null;
            // -----------------------------------------------------------------
            let raycaster = new THREE.Raycaster();
            let mouse = new THREE.Vector2();
            // -----------------------------------------------------------------

            function initScene() {
                renderer.setSize(width, height);
                renderer.shadowMapEnabled = true; 
                document.getElementById("webgl-container").appendChild(renderer.domElement);
                light.castShadow = true;  
                light.shadowMapWidth = 2048; 
                light.shadowMapHeight = 2048; 
                light.position.z = 100;
                scene.add(light);

                camera = new THREE.PerspectiveCamera(
                            35,
                            width / height,
                            1,
                            1000
                        );

                camera.position.z = 10;
                scene.add(camera);
                
                myObject = new THREE.Mesh(
                        new THREE.TorusGeometry( 10, 3, 16, 100 ),
                        new THREE.MeshStandardMaterial({ color: 0x6297F5, wireframe: false })
                    );

                myObject.name = "torus";
                myObject.castShadow = true;
                scene.add(myObject);

                stats = new Stats();
                stats.setMode(0);

                stats.domElement.style.position = "absolute";
                stats.domElement.style.left = "50px";
                stats.domElement.style.top = "50px";
                document.body.appendChild(stats.domElement);

                render();
            }

            function render() {
                myObject.rotation.y += 0.01;
                
                renderer.render(scene, camera);
                requestAnimationFrame(render);

                stats.update();
            }
            
            // -----------------------------------------------------------------
            // For more info, visit: https://threejs.org/docs/#api/core/Raycaster
            function onDocumentMouseDown(event) {
                mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;
                mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
                
                // update the picking ray with the camera and mouse position
                raycaster.setFromCamera( mouse, camera );

                // calculate objects intersecting the picking ray
                var intersects = raycaster.intersectObjects( scene.children );

                for ( var i = 0; i < intersects.length; i++ ) {
                    intersects[i].object.material.color.setHex(Math.random() * 0xFFFFFF);
                    console.log("intersected");
                }
            }
            
            // -----------------------------------------------------------------

            (function main() {
                window.onload = initScene;
                // -----------------------------------------------------------------
                window.addEventListener("mousedown", onDocumentMouseDown, false);
                // -----------------------------------------------------------------

                return {
                    scene: scene
                }

            }) ();
        </script>
        
        <script src="assets/js/app.js"></script>
    </body>
</html>
