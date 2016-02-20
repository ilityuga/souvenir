	cc=0;
	function changeimage()
	{
		if (cc==0) 
			{
				cc=1;
				document.getElementById('myimage').src="img/menu/arrow_down.png"
			}
		else
			{
				cc=0;
				document.getElementById('myimage').src="img/menu/arrow_right.png"
			}
	}