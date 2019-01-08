<?php
class Tools
{
	public static function redirectTo($querystring = '')
	{
		$url = '';
		if (strpos($querystring, 'http://') === false && strpos($querystring, 'https://') === false)
		{
			$url .= _WEB_PATH_;
			$querystring = self::getPageLink($querystring);
		}

		if($querystring != '')
			$url .= $querystring;

		header("Location: ".$url);
		die;
	}

	public static function getRandomId($numchars = 8, $type = "alphanumeric")
	{
		$numeric = "0,1,2,3,4,5,6,7,8,9";
		$alphabetic = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";

		if($type == "numeric")
			$char_str = $numeric;
		else if($type == "alphabetic")
			$char_str = $alphabetic;
		else
			$char_str = $numeric.",".$alphabetic;

		$chars = explode(',', $char_str);
		$randid='';

		for($i=0; $i<$numchars;$i++)
		  $randid.=$chars[rand(0,count($chars)-1)];

		return $randid;
	}

 	public static function isValidPassword($password)
	{
		if(preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{7,}$/',$password))
			return true;
		else
			return false;
	}

	public static function getPageLink($url)
	{
		$page_url = $url;

		$url_parts = preg_split('#\?#i', $url, 2);

		if(isset($url_parts[1]) and $url_parts[1] != "")
		{
			$token = self::getPageToken($url);
			$page_url .= "&token=".$token;
		}

		return $page_url;
	}

	public static function validatePageToken()
	{
		global $uriobj;

		$page_url = $uriobj->page_url();

		$url_parts = preg_split('#\?#i', $page_url, 2);

		if(!isset($url_parts[1]) or $url_parts[1] == "")
			return true;

		if(!isset($_GET['token']) or $_GET['token'] == "")
			return false;

		$token = $_GET['token'];
		$token_str = "&token=".$token;

		$url = str_replace($token_str, "", $page_url);

		$page_token = self::getPageToken($url);

		if($page_token == $token)
			return true;

		return false;
	}

}
