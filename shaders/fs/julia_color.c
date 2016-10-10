#version 100
varying highp vec3 vertexColorVF;
uniform highp vec2 position;
uniform highp float delta;
void main()
{
	highp float d = 2.4/position.x;
	highp float i = gl_FragCoord.x;
	highp float j = gl_FragCoord.y;
	highp vec2 x =vec2((-1.2+ (i*d)),(-1.2 + (j*d)));
	highp vec2 y =vec2(-0.743543+delta,0.11301-3.0*delta);
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
		gray=vec3(delta*100.0,delta*150.0,delta*80.0);
	}
	else
	{
		if(count>64.0)
		{
			color = vec3(0.50*delta,0.77,0.0029);
			gray = color * (count/128.0);
		}
		else
		{
			color = vec3(delta*100.0,125.0/255.0,177.0/255.0);
			gray = color *(1.0- count/128.0);
		}	
	}	
	gl_FragColor= vec4(gray,1.0);

}