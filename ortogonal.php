<!DOCTYPE html>
<html>
<head>
	<title>WebGL</title>
</head>  
<script src="http://webglfundamentals.org/webgl/resources/webgl-utils.js"></script>
<script src="http://webglfundamentals.org/webgl/resources/webgl-lessons-helper.js"></script>
<script src="jquery.js"></script>
<script type="text/javascript" src="Mat4.js"></script>
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
var vertexBuffer;
var positionBuffer;
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
var vertexPosLoc,vertexColLoc,modelMatrixLoc,projMatrixLoc;
var program;
var gl;
function initShaders()
{	var canvas = document.getElementById("canvas");
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
   
    vertexPosLoc   = gl.getAttribLocation(program, "vertexPosition");
    vertexColLoc   = gl.getAttribLocation(program, "vertexColor");
    modelMatrixLoc = gl.getUniformLocation(program, "modelMatrix");
    projMatrixLoc  = gl.getUniformLocation(program, "projMatrix");
 }
 function createShape(){
    var squarePos = [ -2, -1,  3, //0
                    -2,  1,  3,//1
                     2, -1,  3,//2
                     2,  1,  3,//3


                     2, -1,  3,
                     2,  1,  3,
                     2, -1, -3,                 
                     2,  2, -3,


                     2,  1,  3,
                    -2,  1,  3,
                     2,  2, -3,
                    -2,  2, -3,

                    -2, -1, -3,
                    -2,  2, -3,
                    -2, -1,  3,
                    -2,  1,  3,



              -2,2,-3,
              -2,-1,-3,

              2,2,-3,
              2,-1,-3,

              -2,-1,-3,
              -2,-1,3,
              2,-1,-3,
              2,-1,3



  ];

  var squareCol= [ 0,  1,  0,
                   0,  1,  0,
                   0,  1,  0,
                   0,  1,  0,

               1,  0,  0,
               1,  0,  0,
               1,  0,  0,
               1,  0,  0,

               0,  0,  1,
               0,  0,  1,
               0,  0,  1,
               0,  0,  1,

               1,  0,  1,
               1,  0,  1,
               1,  0,  1,
               1,  0,  1,

               0,1,1,
               0,1,1,
               0,1,1,
               0,1,1,

               1,1,0,
               1,1,0,
               1,1,0,
               1,1,0

  ];

  var squareIndex = [  0,  1,  2,  3, 3,4,
                          4,  5,  6,  7, 7, 8,
                          8,  9, 10, 11, 11,12,
                         12, 13, 14, 15, 15,16,
                 16, 17, 18, 19, 19,20,
                 20,21,22,23,24,24
  ];

  positionBuffer = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer); 
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(squarePos), gl.STATIC_DRAW);
  gl.enableVertexAttribArray(vertexPosLoc);
  gl.vertexAttribPointer(vertexPosLoc, 3,gl.FLOAT,false,0,0);

  var colorBuffer = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER,colorBuffer);
  gl.bufferData(gl.ARRAY_BUFFER,new Float32Array(squareCol),gl.STATIC_DRAW);
  gl.enableVertexAttribArray(vertexColLoc);
  gl.vertexAttribPointer(vertexColLoc, 3,gl.FLOAT,false,0,0);



  vertexBuffer = gl.createBuffer();
  gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER,vertexBuffer);
  gl.bufferData(gl.ELEMENT_ARRAY_BUFFER,new Uint16Array(squareIndex),gl.STATIC_DRAW);
  
  gl.enable(gl.CULL_FACE);
  gl.frontFace(gl.CW);
  gl.enable(gl.DEPTH_TEST);

  }
  var angleZ = 45;
 function display()
 {


  var projMat = Mat4();
gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);
  projMat = matrixOrtho(-5,5,-5,5,-5,5);
  var csMat = Mat4();
	gl.clearColor(0, 0.10, 0.25, 1);
	gl.clear(gl.COLOR_BUFFER_BIT| gl.DEPTH_BUFFER_BIT);
	gl.useProgram(program);

 // gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
  gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, vertexBuffer);


  csMat = rotateY (csMat, angleZ++);
  csMat = rotateZ (csMat, angleZ);
  csMat = rotateX (csMat, angleZ);


  gl.uniformMatrix4fv(projMatrixLoc,false, matValues(projMat));
  //console.log(matValues(projMat));
  gl.uniformMatrix4fv(modelMatrixLoc,false, matValues(csMat));
  

  gl.drawElements(gl.TRIANGLE_STRIP,34, gl.UNSIGNED_SHORT, 0);
  //gl.drawArrays(gl.TRIANGLE_STRIP,0,4);
    

     requestAnimationFrame(display);
   
 }

 //MAIN
	
	
$(document).ready(function(){
	 $.ajax({async:false,url: "shaders/vs/projection.c", success: function(result){

        $("#2d-vertex-shader").html(result);
    }});
    $.ajax({async:false,url: "shaders/fs/color.c", success: function(result){
    	
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