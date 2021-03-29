function f_theme_type(type)
{
	let x=document.getElementById('theme_button');
	switch(type)
	{
		case(0)://black
		{	
			x.value="Light Theme";
			for(x=0;x<(document.getElementsByClassName('theme').length);x++)document.getElementsByClassName('theme')[x].style="background-color:#000000";
			for(x=0;x<(document.getElementsByClassName('text').length);x++)document.getElementsByClassName('text')[x].style="color:#FFFFFF";
			for(x=0;x<(document.getElementsByClassName('product').length);x++)document.getElementsByClassName('product')[x].style="border-color:#FFFFFF";
			document.getElementsByClassName('first_backgound')[0].style="background-image: url(img/background_black.jpg)";
			document.getElementsByClassName('second_backgound')[0].style="background-image: url(img/background_black.jpg)";
			x=document.getElementById('user_block');
			x.style.background="#000000";
			if(document.getElementById('feedback_area')!=null)
			{
				x=document.getElementById('feedback_area');
				x.style.background="#000000";
			}
			if(document.getElementById('post_textarea')!=null)
			{
				x=document.getElementById('post_textarea');
				x.style.background="#000000";
			}
			if(document.getElementById('editor_content')!=null)
			{
				x=document.getElementById('editor_content');
				x.style.background="#000000";
			}
			if(document.getElementById('editor_head')!=null)
			{
				x=document.getElementById('editor_head');
				x.style.background="#000000";
			}
			document.cookie="theme=black";
			break;
		}
		case(1)://light
		{
			x.value="Black Theme";
			for(x=0;x<(document.getElementsByClassName('theme').length);x++)document.getElementsByClassName('theme')[x].style="background-color:#FFFFFF";
			for(x=0;x<(document.getElementsByClassName('text').length);x++)document.getElementsByClassName('text')[x].style="color:#000000";
			for(x=0;x<(document.getElementsByClassName('product').length);x++)document.getElementsByClassName('product')[x].style="border-color:#000000";
			document.getElementsByClassName('first_backgound')[0].style="background-image: url(img/background_light.jpg)";
			document.getElementsByClassName('second_backgound')[0].style="background-image: url(img/background_light.jpg)";
			x=document.getElementById('user_block');
			x.style.background="#FFFFFF";
			if(document.getElementById('feedback_area')!=null)
			{
				x=document.getElementById('feedback_area');
				x.style.background="#FFFFFF";
			}
			if(document.getElementById('post_textarea')!=null)
			{
				x=document.getElementById('post_textarea');
				x.style.background="#FFFFFF";
			}
			if(document.getElementById('editor_content')!=null)
			{
				x=document.getElementById('editor_content');
				x.style.background="#FFFFFF";
			}
			if(document.getElementById('editor_head')!=null)
			{
				x=document.getElementById('editor_head');
				x.style.background="#FFFFFF";
			}
			document.cookie="theme=light";
			break;
		}
	}
}
function f_button_theme()
{
	x=document.getElementById('theme_button');
	if(x.value=="Light Theme")f_theme_type(1);
	else f_theme_type(0);
}
function f_get_cookie(cookie_name)
{
  var results=document.cookie.match( '(^|;) ?'+cookie_name+'=([^;]*)(;|$)');
  if (results) return (unescape(results[2]));
  else return null;
}
if(f_get_cookie("theme")=="light")f_theme_type(1);
else f_theme_type(0);