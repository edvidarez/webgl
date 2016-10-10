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

<script id="2d-vertex-shader" type="notjs">
attribute vec3 vertexColor;
attribute vec3 vertexPosition;
varying vec3 vertexColorVF;
void main()
{
	vertexColorVF = vertexColor;
	gl_Position = vec4(vertexPosition,1);
	
}
</script>
 


<script id="2d-fragment-shader" type="notjs">
#version 100
varying highp vec3 vertexColorVF;
uniform highp vec2 position;
void main()
{
	highp float d = 2.4/position.x;
	highp float i = gl_FragCoord.x;
	highp float j = gl_FragCoord.y;
	highp vec2 x =vec2((-1.2+ (i*d)),(-1.2 + (j*d)));
	highp vec2 y =vec2(-0.74543,0.11301);
	highp vec3 color;
	highp vec3  gray;
	highp float count = 0.0;
	for (int i = 0; i <128; i++)
	{
		if(length(x)<=2.0)
		{
			x=vec2((x.x*x.x  - x.y*x.y),(2.0*x.x*x.y));
			x=x+y;
			count = count + 1.0;
		}
	}
	if(length(x) <=2.0)
	{
		gray=vec3(0,0,0);
	}
	else
	{
		if(count>64.0)
		{
			color = vec3(1.0,0.07,0.0029);
			gray = color * (count/128.0);
		}
		else
		{
			color = vec3(0.0/255.0,0.0/255.0,177.0/255.0);
			gray = color *(1.0- count/128.0);
		}	
	}	
	gl_FragColor= vec4(gray,1.0);

}
</script>


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
var program;
var gl;
function initShaders(){
	var canvas = document.getElementById("canvas");
	gl = canvas.getContext("webgl");
	

	if(!gl){
		alert("no WebGL for you");
	}
	var vertexShaderSource = document.getElementById("2d-vertex-shader").text;
    var fragmentShaderSource = document.getElementById("2d-fragment-shader").text;
    

    var vertexShader = createShader(gl, gl.VERTEX_SHADER, vertexShaderSource);
    var fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, fragmentShaderSource);
   

    //crea el programa con el vertex y el fragment shader
    program = createProgram(gl, vertexShader, fragmentShader);
    //localizacion
    positionAttributeLocation = gl.getAttribLocation(program, "vertexPosition");
    colorAttributeLocation = gl.getAttribLocation(program, "vertexColor");
    positionXYLoc = gl.getUniformLocation(program,"position");
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
    gl.drawArrays(primitiveType, offset, count);
 }

 //MAIN
	
	

    initShaders();
    createShape();
    display();


   
	









</script>
</html>