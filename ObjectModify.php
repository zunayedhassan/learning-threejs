<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Object Modify</title>
        
        <script type="text/javascript" src="assets/lib/three.js/three.min.js"></script>
        
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
                let box = null;

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

                    box = new THREE.Mesh(
                                new THREE.BoxGeometry(20, 20, 20),
                                new THREE.MeshBasicMaterial({ color: 0x6297F5 })
                            );

                    box.name = "box";
                    scene.add(box);
                    
                    //----------------------------------------------------------
                    
                    /* Position */
                    box.position.x += 20;
                    box.position.set(0, 0, 15);
                    // box.position = new THREE.Vector3(0, 0, 0);
                    
                    /* Scale */
                    box.scale.x = 2;
                    
                    /* Rotation */
                    box.rotation.x = 20;
                    
                    //----------------------------------------------------------

                    render();
                }

                function render() {
                    box.rotation.y += 0.01;

                    renderer.render(scene, camera);
                    requestAnimationFrame(render);
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
