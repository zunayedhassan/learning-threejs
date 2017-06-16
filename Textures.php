<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Light and Shadow</title>
        
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

            (function main() {

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
                                new THREE.BoxGeometry(20, 20, 20),
                                new THREE.MeshBasicMaterial({ map: THREE.ImageUtils.loadTexture("assets/textures/crate.jpg") })
//                                new THREE.MeshBasicMaterial({ map: THREE.ImageUtils.loadTexture("assets/textures/crate.jpg"), color: '#FF0000' })
                            );
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

                window.onload = initScene;

                return {
                    scene: scene
                }

            }) ();
        </script>
        
        <script src="assets/js/app.js"></script>
    </body>
</html>
