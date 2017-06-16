<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Scene Interaction</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
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
            
            let scene = new THREE.Scene();
            let renderer = window.WebGLRenderingContext ? new THREE.WebGLRenderer() : new THREE.CanvasRenderer();
            let light = new THREE.DirectionalLight(0xffffff);
            let camera = null;
            let stats = null;
            let myObject = null;

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
                let loader = new THREE.ObjectLoader();

                loader.load(
                    // NOTE: JSON is converted from OBJ to JSON on https://threejs.org/editor/
                    // Load resources
                    "assets/models/model.json",

                    // After the resource has loaded
                    function(obj) {
                        myObject = obj;
                        myObject.castShadow = true;     
                        scene.add(myObject);

                        stats = new Stats();
                        stats.setMode(0);

                        stats.domElement.style.position = "absolute";
                        stats.domElement.style.left = "50px";
                        stats.domElement.style.top = "50px";
                        document.body.appendChild(stats.domElement);

                        render();
                    },

                    // Function called when download progresses
                    function ( xhr ) {
                        console.log( (xhr.loaded / xhr.total * 100) + '% loaded' );
                    },

                    // Function called when download errors
                    function ( xhr ) {
                        console.error( 'An error happened' );
                    }        
                );
            }

            function render() {
                myObject.rotation.y += 0.01;

                renderer.render(scene, camera);
                requestAnimationFrame(render);

                stats.update();
            }

            function checkKey(event) {
                let left      = 37;
                let up        = 38;
                let right     = 39;
                let down      = 40;
                let increment = 1;

                if (event.keyCode === up) {
                    camera.position.z -= increment;
                }
                else if (event.keyCode === down) {
                    camera.position.z += increment;
                }
                else if (event.keyCode === left) {
                    camera.position.x -= increment;
                }
                else if (event.keyCode === right) {
                    camera.position.x += increment;
                }
            }

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
