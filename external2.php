<!DOCTYPE html>
<html>
<head>
	<title>WebGL</title>
</head>  
<script src="http://webglfundamentals.org/webgl/resources/webgl-utils.js"></script>
<script src="http://webglfundamentals.org/webgl/resources/webgl-lessons-helper.js"></script>
<script src="jquery.js"></script>
<body>
<div align="center" vertical-align: middle>
<canvas id="canvas" width="1000px" height="1000px"></canvas>
</div>
</body>
<div id="div1"></div>

<script id="2d-vertex-shader" type="notjs"></script>
<script id="2d-fragment-shader" type="notjs"></script>


<script type="text/javascript">
var fragment_shader;
function createShader(gl, type, source) {
    var shader = gl.createShader(type);
    gl.shaderSource(shader, source);
   //console.log(source);
    gl.compileShader(shader);
    var success = gl.getShaderParameter(shader, gl.COMPILE_STATUS);
    if (success) {
      return shader;
    }
     
    console.log(gl.getShaderInfoLog(shader));
    gl.deleteShader(shader);
    
}
function createProgram(gl, vertexShader, fragmentShader) {
  var program = gl.createProgram();
  gl.attachShader(program, vertexShader);
  gl.attachShader(program, fragmentShader);
  gl.linkProgram(program);
  var success = gl.getProgramParameter(program, gl.LINK_STATUS);
  if (success) {
    return program;
  }
 
  console.log(gl.getProgramInfoLog(program));
  gl.deleteProgram(program);
}
var positionAttributeLocation;
var colorAttributeLocation;
var positionXYLoc;
var deltaLoc;
var program;
var gl;
var delta =-0.050;
var direccion=1;
function initShaders(){
	var canvas = document.getElementById("canvas");
	gl = canvas.getContext("webgl");
	if(!gl){
		alert("no WebGL for you");
	}
    var vertexShaderSource = document.getElementById("2d-vertex-shader").text;
    var fragmentShaderSource = document.getElementById("2d-fragment-shader").text;
    
   
    	var  vertexShader = createShader(gl, gl.VERTEX_SHADER, vertexShaderSource);
   		var  fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, fragmentShaderSource);
   
   
   

    //crea el programa con el vertex y el fragment shader
    program = createProgram(gl, vertexShader, fragmentShader);
    //localizacion
    positionAttributeLocation = gl.getAttribLocation(program, "vertexPosition");
    colorAttributeLocation = gl.getAttribLocation(program, "vertexColor");
    positionXYLoc = gl.getUniformLocation(program,"position");
    deltaLoc = gl.getUniformLocation(program,"delta");
 }
 function createShape(){
 	 var positions = [ 		-1.0,  1.0, 0.0,
		             	 	-1.0, -1.0, 0.0,
					         1.0, 1.0, 0.0,
							 1.0,-1.0,0.0
	];

	var colors =[
							1.0, 0.0, 0.0,
							0.0, 1.0, 0.0,
							0.0, 0.0, 1.0,
							0.0, 0.0, 1.0
];
	var positionsXY =[0.0,0.0];
    var positionBuffer = gl.createBuffer();
    var colorBuffer = gl.createBuffer();
    //crea y seleciona el buffer
    gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer); 
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(positions), gl.STATIC_DRAW);
    gl.enableVertexAttribArray(positionAttributeLocation);
    gl.vertexAttribPointer(positionAttributeLocation, 3,gl.FLOAT,false,0,0);


    gl.bindBuffer(gl.ARRAY_BUFFER,colorBuffer);
    gl.bufferData(gl.ARRAY_BUFFER,new Float32Array(colors),gl.STATIC_DRAW);
    gl.enableVertexAttribArray(colorAttributeLocation);
    gl.vertexAttribPointer(colorAttributeLocation, 3,gl.FLOAT,false,0,0);

 }
 function display()
 {

	//webglUtils.resizeCanvasToDisplaySize(gl.canvas);
	gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);
	gl.clearColor(0, 0, 0, 1);
	//glClearColor(0.85, 0.85, 0.85, 1.0);
	gl.clear(gl.COLOR_BUFFER_BIT);
	gl.useProgram(program);
	
	var primitiveType = gl.TRIANGLE_STRIP;
    var offset = 0;
    var count = 4;
    gl.uniform2f(positionXYLoc,gl.canvas.width,gl.canvas.height);
    gl.uniform1f(deltaLoc,delta);
    gl.drawArrays(primitiveType, offset, count);
    if(delta>0.02)
    	direccion =-1;
    if (delta < -0.050)
    	direccion =1;
    delta=delta+.0001*direccion;
    console.log(delta);
     requestAnimationFrame(display);
 }

 //MAIN
	
	
$(document).ready(function(){
	 $.ajax({async:false,url: "shaders/vs/color_position.c", success: function(result){

        $("#2d-vertex-shader").html(result);
    }});
    $.ajax({async:false,url: "shaders/fs/julia_color.c", success: function(result){
    	
        $("#2d-fragment-shader").html(result);
        	initShaders();
        	
    }});
  createShape();
  display();
  requestAnimationFrame(display);
});
   
   // three 2d points

   
	









</script>
</html>