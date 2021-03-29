function f_move_backgound()
{
	if(pos_background<100)
	{
		document.getElementById('first_background').style.width=(pos_background+"%");
		document.getElementById('second_background').style.width=((100-pos_background)+"%");
		pos_background=pos_background+0.1;
	}
	else
	{
		pos_background=0;
		document.getElementById('second_background').style.width="0%";
		document.getElementById('first_background').style.width="100%";
	}
}
//document.getElementById('first_background').style.backgroundColor="#FF0000";
document.getElementById('first_background').style.width="10%";
document.getElementById('second_background').style.width="90%";
let pos_background=10;
let timer=setInterval(f_move_backgound,10);