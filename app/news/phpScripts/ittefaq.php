<?php 
require 'simple_html_dom.php';

// Retrieve the DOM from a given URL
$siteUrl = "http://www.ittefaq.com.bd";

//$html = file_get_html($siteUrl, false, $context);
$html = str_get_html(file_get_contents($siteUrl));

$allLink = array();
$AllContent = array();

// for new links
foreach($html->find('.menuNewsHl2_Lead a')  as $e)
{
	$pos = $e->href;
	$FullLink1= "http://www.ittefaq.com.bd/".$pos;
	array_push($allLink, $FullLink1);
}	


foreach($html->find('.menuNewsHl2_MenuNewsTop4 a')  as $e)
{
	$pos = $e->href;
	//var_dump($pos);
	$FullLink2= "http://www.ittefaq.com.bd/".$pos;
	array_push($allLink, $FullLink2);
}

foreach($html->find('.mostViewPanel a')  as $e)
{
	$pos = $e->href;
	$FullLink3= "http://www.ittefaq.com.bd/".$pos;
	array_push($allLink, $FullLink3);
}	


foreach($html->find('.menuNewsHl2_top3 a')  as $e)
{
	$pos = $e->href;
	$FullLink4= "http://www.ittefaq.com.bd/".$pos;
	array_push($allLink, $FullLink4);
}	

$allLink = array_unique($allLink);
foreach($allLink as $e)
{
	echo $e."<br>";
}

//for each single post

$counter = 1;
//$$link="";
foreach ($allLink as $link)
{
	

	$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// don't want to polute your output
	//curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	curl_setopt($ch, CURLOPT_URL, $link);
	$result=curl_exec($ch);

	$singlePost = new simple_html_dom();
	$singlePost->load($result);


	//$singlePost = str_get_html(file_get_contents($link), false, $context);

	//the title
	$title = $singlePost->find('.detailsNewsHl2');
	foreach($title as $elemet2)
	{
		$newsTitle=$elemet2->plaintext;
		$newsTitle= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
		echo $newsTitle."<br>";
		//echo $newsTitle."<br>";
		//echo $title;
		$newsTitle=base64_encode($newsTitle);
		
		
	}

	//news image
	$image = $singlePost->find('.lazy');
	$Ztest=count($image);
	if ($Ztest>0)
		{
			foreach($image as $elemet4)
			{
				$pic=$elemet4->src;
				$pic= "http://www.ittefaq.com.bd/".$pic;
				//echo $pic."<br>";
				$pic=base64_encode($pic);
				break;
			}
		}
	else
		{
			//echo "img/flyerBDHolder.jpg";
			$pic=base64_encode("img/flyerBDHolder.jpg");
			
		}

	//news detail

	$detail = $singlePost->find('.detailsNewsDtl');
	//$txt="";
	foreach($detail as $elemet3)
	{
		$txt=$elemet3->plaintext;
		//$txt.=$dtl;
	}

	//echo $txt."<br>";
	$txt=preg_replace("/&#?[a-z0-9]{2,8};/i","", $txt);
	
	$txt=base64_encode($txt);
	$temparr= array('url'=>$link, 'id'=>$counter, 'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;
		//echo $link.' OK<br>';
}

$fp = fopen('ittefaq.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
echo "<h1>Update Completed</h1>";

?>