<?php 
include("simple_html_dom.php");

// Retrieve the DOM from a given URL
$html = file_get_html('http://www.prothom-alo.com/');
//$c = 0;
$allLink = array();
$AllContent = array();


// Find all "A" tags and print their HREFs
	
// Find all SPAN tags that have a class of "myClass"
foreach($html->find('h2.title a') as $e){
    	$pos = strrpos($e->href, "/");
    	$rest = substr($e->href, 0, $pos);
	//echo $rest."<br>";
    	array_push($allLink, $rest);
    }
$allLink = array_unique($allLink);    
$counter = 1;
foreach ($allLink as $links) 
{

    	$singlePost = file_get_html($links);
        //var_dump($singlePost->find('.title_container'));

    	$newsTitle_beta1 = $singlePost->find('.title_container h1');


        $newsTitle_beta2 = $newsTitle_beta1[0]->plaintext;
        $newsTitle_beta3=str_replace ( "&nbsp;" , "" , $newsTitle_beta2);
        $newsTitle=base64_encode($newsTitle_beta3);

        //image section is not showing the src despite having to visible error
        $image = $singlePost->find('.jw_detail_content_holder img');
        $Ztest= count($image);
        if ($Ztest>0)
        {   foreach($image as $element)
            {
            
                $pic = base64_encode($element->src);
               //global $pic;
               //var_dump($pic);
               //echo "<br> ";
               break;
            }
        }

        else
        {

            $pic=base64_encode("img/flyerBDHolder.jpg");

        }
        //echo $image[0]-> src;
        
        //detail news
        $detail = $singlePost->find('.jw_detail_content_holder');
        $txt_beta1= $detail[0]->plaintext;
        $txt_beta2=str_replace ( "&nbsp;" , "" , $txt_beta1);
        $txt=base64_encode($txt_beta2);
        
        $temparr= array('id' => $counter, 'title' => $newTitle, 'newsImage'=>$pic, 'detail'=>$txt);
        //print_r($temparr);
        array_push($AllContent, $temparr);
        $counter++;
        //break;
}

$fp = fopen('prothomAlo.json', 'w');
//fwrite($fp,json_encode(utf8json($AllContent)));
fwrite($fp,json_encode($AllContent));
fclose($fp);


?>
