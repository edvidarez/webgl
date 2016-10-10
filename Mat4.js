function Mat4() {
	var M = new Array(4);
	var i,j;
	for (i = 0; i < 4; i++)
	{
	    M[i] = new Array(4);
	    for (j = 0; j < 4; j++)
	    {
	        M[i][j] =0;
	        if(i==j)
	        	M[i][j]=1;
	    }
	}
	return M;

}
function matValues(M)
{
	var a = new Array;
	var i,j,k=0;
	for (i = 0; i < 4; i++)
	{
	    for (j = 0; j < 4; j++)
	    {
	        a[k++]=M[i][j];
	    }
	}
	//console.log(typeof a);
	return a;
	
}

function mMult(m1,m2)
{
	var c,r,k;
	var M = Mat4();
	for(c = 0; c < 4; c ++) 
	{
		for(r = 0; r < 4; r ++) 
		{
			var sum = 0;
			for(k = 0; k < 4; k ++) 
			{
				sum += m1[k][r] * m2[c][k];
			}
			M[c][r] = sum;
		}
	}
	return M;
}
function mPrint(m){
	var r, c;
	console.log(" ---------------------\n");
	for(r = 0; r < 4; r ++) {
		console.log(m[r]);
	}
	console.log(" ---------------------\n");
	return 0;
}
function toRadians(r)
{
	return r* 3.141592 / 180.0;
}

function matrixOrtho(left,right,bottom,top,near,far)
{
	M = Mat4();
	M[0][0]= 2/(right - left);
	M[0][3]=(-right - left)/(right - left);
	M[1][1]=2/(top - bottom);
	M[1][3]=(-top - bottom)/(top - bottom);
	M[2][2]= 2/(near - far);
	M[2][3]=(-near - far)/(near - far);
	return M;
}
function matrixPerspective(fovy,aspect,near,far)
{
	var M = Mat4();
	var angle = Math.tan(toRadians(fovy/2));
	M[0][0] = 1 /(aspect * angle);
	M[1][1] = 1/angle;
	M[2][2] = (near + far) / (near-far);
	M[2][3] = (-2 * near * far) /(near -far);
	M[3][2] = -1;
	M[3][3] = 0;
	return M;
}
function translate(M,tx,ty,tz)
{
	var MI = Mat4();
	MI[0][3] = tx;
	MI[1][3] = ty;	
	MI[2][3] = tz;
	mPrint(MI);
	return mMult(M,MI);
}

function rotateX(M,angle)
{
	var rad = toRadians(angle);
	var Mx = Mat4();
	Mx[1][1] = Math.cos(rad);
	Mx[1][2] = -Math.sin(rad);
	Mx[2][1] = Math.sin(rad);
	Mx[2][2] = Math.cos(rad);
	return mMult(M,Mx);
}
function rotateY(M,angle)
{
	var rad = toRadians(angle);
	var My = Mat4();
	My[0][0] = Math.cos(rad);
	My[0][2] = Math.sin(rad);
	My[2][0] = -Math.sin(rad);
	My[2][2] = Math.cos(rad);
	return mMult(M,My);
}
function rotateZ(M,angle){
	var rad = toRadians(angle);
	var Mz = Mat4();
	Mz[0][0] = Math.cos(rad);
	Mz[0][1] = -Math.sin(rad);
	Mz[1][0] = Math.sin(rad);
	Mz[1][1] = Math.cos(rad);
	return mMult(M,Mz);
}

function scale(M,sx,sy,sz)
{
	var Ms = Mat4();
	Ms[0][0] = sx;
	Ms[1][1] = sy;
	Ms[2][2] = sz;
	return mMult(M,Ms);
}

/*var M = Mat4();
M = translate(M,5,3,0);
mPrint(M);

M = rotateZ(M,45);
mPrint(M);
M = rotateZ(M,-45);
mPrint(M);
M = translate(M,-5,-3,0);
mPrint(M);*/