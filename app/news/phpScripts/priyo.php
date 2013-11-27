<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html1 = file_get_html('http://blog.priyo.com/');
$html2 = file_get_html('http://blog.priyo.com/?page=1');
$html3 = file_get_html('http://blog.priyo.com/?page=2');

//$c = 0;
$allLink = array();
$AllContent = array();

//link
foreach($html1->find('.title a')  as $e){
	$pos = $e->href;
	$FullLink= "http://blog.priyo.com/".$pos;
    	//$rest = substr($e->href, 0, $pos);
	//echo $rest."<br>";
	array_push($allLink, $FullLink);
    	//echo $FullLink ."<br>";
    	//echo "<br>";
}
foreach($html2->find('.title a')  as $e){
	$pos = $e->href;
	$FullLink= "http://blog.priyo.com/".$pos;
    	//$rest = substr($e->href, 0, $pos);
	//echo $rest."<br>";
	array_push($allLink, $FullLink);
    	//echo $FullLink ."<br>";
    	//echo "<br>";
}
foreach($html3->find('.title a')  as $e){
	$pos = $e->href;
	$FullLink= "http://blog.priyo.com/".$pos;
    	//$rest = substr($e->href, 0, $pos);
	//echo $rest."<br>";
	array_push($allLink, $FullLink);
    	//echo $FullLink ."<br>";
    	//echo "<br>";
}
$allLink = array_unique($allLink);
$counter = 1;
foreach ($allLink as $link)
{
//title
$singlePost = file_get_html($link);

//the title
	$title = $singlePost->find('h1');
	foreach($title as $elemet2)
	{
		$newsTitle=$elemet2->plaintext;
		$newsTitle_beta2= preg_replace("/&#?[a-z0-9]{2,8};/i","", $newsTitle);
		$newsTitle=base64_encode($newsTitle_beta2);
	//echo $newsTitle."<br>";
	}

//news image
	$pic=base64_encode("img/flyerBDHolder.jpg");
	
//detail
	$detail = $singlePost->find('.clearfix p');
	$txt_beta1="";	
	foreach($detail as $elemet3)
	{
		$dtl=$elemet3->plaintext;
		$txt_beta1.=$dtl;
	}
	$pos = strrpos($txt_beta1, "প্রিয়.কম");
	$rest = substr($txt_beta1, 0, $pos);
	$txt_beta2=str_replace( "&nbsp;" , "" , $rest);
	$txt=base64_encode($txt_beta2);
	$temparr= array('url'=>$link, 'id' => $counter,'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
	array_push($AllContent, $temparr);
	$counter++;

}

	//echo $rest;
$fp = fopen('priyo.json', 'w');
fwrite($fp,json_encode($AllContent));
fclose($fp);
	

	
?>