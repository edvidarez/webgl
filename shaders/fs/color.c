varying highp vec3 vertexColorVF;
void main()
{
	gl_FragColor= vec4(vertexColorVF,1);
}