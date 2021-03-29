<?php
	function f_temp_clean()
	{
		if(isset($_COOKIE['temp']))setcookie("temp","",time()-3600);
		return;
	}
	function f_counter_visits($act)
	{
		
		if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			switch($act)
			{
				case('show'):
				{
					$res=mysqli_query($db,"SELECT * FROM visit_counter");
					$row=mysqli_fetch_array($res);
					return $row['count'];
					break;
				}
				case('add'):
				{
					$res=mysqli_query($db,"SELECT * FROM visit_counter");
					$row=mysqli_fetch_array($res);
					$count=$row['count'];
					$count++;
					mysqli_query($db,"UPDATE visit_counter SET count='".$count."' WHERE count='".$row['count']."'");
					break;
				}
			}
		}
		else echo("<br>DB not connected<br>");
	}
	function f_user_group()
	{
		if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			$res=mysqli_query($db,"SELECT usergroup FROM users WHERE auth='".$_COOKIE['key']."'");
			$row=mysqli_fetch_array($res);
			mysqli_close($db);
			return($row['usergroup']);
		}
		else echo("<br>DB not connected<br>");
	}
	function f_user_name()
	{
		if(isset($_COOKIE['key'])==false)
		{
			//setcookie("user","Гость");
			return("Гость");
		}
		else
		{
			if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
			{
				mysqli_query($db,"SET NAMES utf8_general_ci");
				$db->set_charset("utf8_general_ci");
				$res=mysqli_query($db,"SELECT user FROM users WHERE auth='".$_COOKIE['key']."'");
				if($res==false)
				{
					mysqli_close($db);
					return("Гость");
				}
				else
				{
					mysqli_close($db);
					$row=mysqli_fetch_array($res);
					return($row['user']);
				}
				/*
				$coin=false;
				do
				{
					$row=mysqli_fetch_array($res);
					if($_COOKIE['user']==$row['user'])$coin=true;
				}
				while(($coin==false)&&($row));
				if(($coin==true)&&($row['auth']==$_COOKIE["key"]))echo($_COOKIE["user"]);
				else
				{
					setcookie("user","Гость");
					echo("Гость");
				}
				mysqli_close($db);*/
			}
			else echo("<br>DB not connected<br>");
		}	
	}
	echo(f_user_name());
	f_counter_visits('add');
?>