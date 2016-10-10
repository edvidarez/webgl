attribute vec3 vertexColor;
attribute vec3 vertexPosition;
varying vec3 vertexColorVF; 
uniform mat4 modelMatrix;
uniform mat4 projMatrix;
void main()
{
	vertexColorVF=vertexColor;	
	gl_Position = projMatrix*modelMatrix*vec4(vertexPosition,1);
	
}