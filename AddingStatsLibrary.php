<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Adding Stats Library</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
        <!-- --------------------------------------------------------------- -->
        <script type="text/javascript" src="assets/lib/stats.js/stats.min.js"></script>
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

            (function main() {

                let scene = new THREE.Scene();
                let renderer = window.WebGLRenderingContext ? new THREE.WebGLRenderer() : new THREE.CanvasRenderer();
                let light = new THREE.AmbientLight(0xffffff);
                let camera = null;
                let myObject = null;
                
                // -------------------------------------------------------------
                let stats = null;
                // -------------------------------------------------------------

                function initScene() {
                    renderer.setSize(window.innerWidth, window.innerHeight);
                    document.getElementById("webgl-container").appendChild(renderer.domElement);
                    scene.add(light);

                    camera = new THREE.PerspectiveCamera(
                                35,
                                window.innerWidth / window.innerHeight,
                                1,
                                1000
                            );

                    camera.position.z = 100;
                    scene.add(camera);

                    myObject = new THREE.Mesh(
                                new THREE.TorusGeometry( 10, 3, 16, 100 ),
                                new THREE.MeshBasicMaterial({ color: 0x6297F5 })
                            );

                    myObject.name = "torus";
                    scene.add(myObject);
                    
                    // -------------------------------------------------------------
                    stats = new Stats();
                    stats.setMode(0);
                    
                    stats.domElement.style.position = "absolute";
                    stats.domElement.style.left = "50px";
                    stats.domElement.style.top = "50px";
                    document.body.appendChild(stats.domElement);
                    // -------------------------------------------------------------

                    render();
                }

                function render() {
                    myObject.rotation.y += 0.01;

                    renderer.render(scene, camera);
                    requestAnimationFrame(render);
                    
                    // -------------------------------------------------------------
                    stats.update();
                    // -------------------------------------------------------------
                }

                window.onload = initScene;

                return {
                    scene: scene
                }

            }) ();
        </script>
        
        <script src="assets/js/app.js"></script>
    </body>
</html>
