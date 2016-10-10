attribute vec3 vertexColor;
attribute vec3 vertexPosition;
varying vec3 vertexColorVF;
void main()
{
	vertexColorVF = vertexColor;
	gl_Position = vec4(vertexPosition,1);
	
}