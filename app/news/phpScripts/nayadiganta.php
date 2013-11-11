	<?php 
	include("simple_html_dom.php");

	// Retrieve the DOM from a given URL
	//$html = file_get_html('http://dailynayadiganta.com');
	//$c = 0;
	$allLink = array();
	$AllContent = array();


	// Find all "A" tags and print their HREFs

	// Find all SPAN tags that have a class of "myClass"
	try {		
		$html = file_get_html('http://www.dailynayadiganta.com/welcome/page/2');
		foreach($html->find(".span8 a")  as $e){
			$pos = $e->href;
			array_push($allLink, $pos);
		}
	} catch (Exception $e) {
			echo 'error all link fetch '. $e;		
	}
	$allLink = array_unique($allLink);
	print_r($allLink);


	/*
	$html = file_get_html('http://www.dailynayadiganta.com/welcome/page/3');
	foreach($html->find(".span8 a")  as $e){
		$pos = $e->href;
		array_push($allLink, $pos);
	}
	$html = file_get_html('http://www.dailynayadiganta.com/welcome/page/4');
	foreach($html->find(".span8 a")  as $e){
		$pos = $e->href;
		array_push($allLink, $pos);
	}
	$html = file_get_html('http://www.dailynayadiganta.com/welcome/page/8');
	foreach($html->find(".span8 a")  as $e){
		$pos = $e->href;
		array_push($allLink, $pos);
	}*/


	$counter = 1;
	//exit();
	//header
	foreach ($allLink as $link) {
		try {
			$singlePost = file_get_html($link);		
			foreach($singlePost->find('div.newscontent') as $article) {
			    $item['id']  		   = $counter;
			    $item['title']     = $article->find('h3', 0)->plaintext;
			    $item['newsImage'] = $article->find('div.span5 img', 0)->src;
			    $item['detail'] 	 = $article->find('div.content', 0)->plaintext;
			   /* $item['id']    		 = base64_encode($item['id']);
			    $item['title']     = base64_encode($item['title']);
			    $item['newsImage'] = base64_encode($item['newsImage']);
			    $item['detail']    = base64_encode($item['detail']);*/
			    $AllContent[] 		 = $item;
			}	
			//$html->set_callback('customParsing');
		} catch (Exception $e) {
			echo 'error single link fetch '. $e;			
		}
	}
	print_r($AllContent);

	//the title
		/*try {
			$title = $singlePost->find("h3");
			//foreach($title as $elemet2){
				$newsTitle=base64_encode($title[0]->innertext);
				//echo $newsTitle."<br>";
				//break;
			//}
		} catch (Exception $e) {
			echo 'error title fetch '. $e;
		}
		
	
	//Single post image
		try {
			$image = $singlePost->find(".span5 img");
			$Ztest=count($image);
			if ($Ztest>0)
			{
				foreach($image as $elemet4)
				{
					$pic=base64_encode($elemet4->src);
				//echo $pic."<br>";
				break;
				}
			}
			else
			{
				$pic=base64_encode("img/flyerBDHolder.jpg");
				//echo $pic."<br>";
			}
		} catch (Exception $e) {
			echo 'error image fetch '. $e;			
		}
		

	//the detail
		try {
			$detail = $singlePost->find('.content');
			foreach($detail as $elemet3){
				$txt=base64_encode($elemet3->plaintext);
			//echo $txt;
			}
		} catch (Exception $e) {
			echo 'error detail fetch '. $e;	
		}
		
		$temparr= array('id' => $counter,'title' => $newsTitle, 'newsImage'=>$pic, 'detail'=>$txt);
		array_push($AllContent, $temparr);
		echo $counter.' '.$link.' OK<br>';
		$counter++;*/
		//break;
	//}
	/*function customParsing($element){
		if ($element->tag=='h3')
      return $element->innertext;
	}*/
	/*$fp = fopen('nayaDiganta.json', 'w');
	fwrite($fp,json_encode($AllContent));
	fclose($fp);*/

	?>