<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Creating a Mesh</title>
        
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
                // -------------------------------------------------------------
                let myObject = null;
                // -------------------------------------------------------------
                let stats = null;

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

                    // -------------------------------------------------------------
                    let triangleGeometry = new THREE.Geometry();
                    triangleGeometry.vertices.push(new THREE.Vector3(0, 1, 0));
                    triangleGeometry.vertices.push(new THREE.Vector3(-1, -1, 0));
                    triangleGeometry.vertices.push(new THREE.Vector3(1, -1, 0));
                    
                    triangleGeometry.faces.push(new THREE.Face3(0, 1, 2));
                    
                    let material = new THREE.MeshBasicMaterial({
                        vertexColors: THREE.VertexColors,
                        side: THREE.DoubleSide
                    });
                    
                    triangleGeometry.faces[0].vertexColors[0] = new THREE.Color(0xFF0000);
                    triangleGeometry.faces[0].vertexColors[1] = new THREE.Color(0x00FF00);
                    triangleGeometry.faces[0].vertexColors[2] = new THREE.Color(0x0000FF);
                    
                    myObject = new THREE.Mesh(triangleGeometry, material);

                    myObject.name = "triangle";
                    scene.add(myObject);
                    
                    
                    myObject.scale.set(8, 8, 8);
                    // -------------------------------------------------------------
                    
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
                    
                    // -------------------------------------------------------------
                    // If you wnt to modify mesh
                    myObject.geometry.dynamic = true;
                    myObject.geometry.vertices[0].x -= 0.001;
                    myObject.geometry.vertices[0].y -= 0.001;
                    myObject.geometry.vertices[0].z -= 0.001;
                    myObject.geometry.verticesNeedUpdate = true;
                    // -------------------------------------------------------------

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
