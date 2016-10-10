<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div align="center" vertical-align: middle>
<canvas id="canvas" width="1000px" height="1000px"></canvas>
</div>
</body>
<script type="text/javascript">
    // our shaders base path
loadShaders.base = "shaders/";

// our shaders loader
function loadShaders(gl, shaders, callback) {
    function onreadystatechange() {
        var xhr = this,
            i = xhr.i
        ;
        if (xhr.readyState == 4) {
            shaders[i] = gl.createShader(
                shaders[i].slice(0, 2) == "fs" ? gl.FRAGMENT_SHADER : gl.VERTEX_SHADER
            );
            gl.shaderSource(shaders[i], xhr.responseText);
            gl.compileShader(shaders[i]);
            if (!gl.getShaderParameter(shaders[i], gl.COMPILE_STATUS))
                throw gl.getShaderInfoLog(shaders[i])
            ;
            !--length && typeof callback == "function" && callback(shaders);
        }
    }
    for (var
        shaders = [].concat(shaders),
        asynchronous = !!callback,
        i = shaders.length,
        length = i,
        xhr;
        i--;
    ) {
        (xhr = new XMLHttpRequest).i = i;
        xhr.open("get", loadShaders.base + shaders[i] + ".c", asynchronous);
        if (asynchronous) {
            xhr.onreadystatechange = onreadystatechange;
        }
        xhr.send(null);
        onreadystatechange.call(xhr);
    }
    return shaders;
}

var positionAttributeLocation;
var colorAttributeLocation;
var positionXYLoc;
var program;
var gl;
var shaders;
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
function initShaders(){
    var canvas = document.getElementById("canvas");
    gl = canvas.getContext("webgl");
    

    if(!gl){
        alert("no WebGL for you");
    }
   

    var vertexShader = createShader(gl, gl.VERTEX_SHADER, shaders[0]);
    var fragmentShader = createShader(gl, gl.FRAGMENT_SHADER, shaders[1]);
   

    //crea el programa con el vertex y el fragment shader
    program = createProgram(gl, vertexShader, fragmentShader);
    //localizacion
    positionAttributeLocation = gl.getAttribLocation(program, "vertexPosition");
    colorAttributeLocation = gl.getAttribLocation(program, "vertexColor");
    positionXYLoc = gl.getUniformLocation(program,"position");
 }
    var canvas = document.getElementById("canvas");
    gl = canvas.getContext("webgl");

// synch, more shaders
 shaders = loadShaders(gl, [
    "fs/julia_color",
    "vs/color_position"
]);
initShaders();  
</script>
</html>