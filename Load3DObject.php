<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loading a 3D Object (Collada)</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
        <!-- --------------------------------------------------------------- -->
        <!-- You can find this on "three.js-master\examples\js\loaders\ColladaLoader.js" -->
        <script type="text/javascript" src="assets/lib/three.js/ColladaLoader.js"></script>
        <!-- --------------------------------------------------------------- -->
        <script type="text/javascript" src="assets/lib/stats.js/stats.min.js"></script>
        
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
                let stats = null;
                
                // -------------------------------------------------------------
                let myObject = null;
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

                    camera.position.z = 200;
                    scene.add(camera);
                    
                    // -------------------------------------------------------------
                    let loader = new THREE.ColladaLoader();
                    loader.options.convertUpAxis = true;
                    
                    loader.load(
                        // Load resources
                        "assets/models/monster.dae",
                
                        // After the resource has loaded
                        function(collada) {
                            myObject = collada.scene;
                            scene.add(myObject);

                            stats = new Stats();
                            stats.setMode(0);

                            stats.domElement.style.position = "absolute";
                            stats.domElement.style.left = "50px";
                            stats.domElement.style.top = "50px";
                            document.body.appendChild(stats.domElement);

                            render();
                        }
                    );
                    // -------------------------------------------------------------
                }

                function render() {
                    myObject.rotation.y += 0.01;

                    renderer.render(scene, camera);
                    requestAnimationFrame(render);
                    
                    stats.update();
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
