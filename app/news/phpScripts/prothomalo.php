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

    	$title = $singlePost->find('.title_container h1');


        $newTitle = base64_encode($title[0]->plaintext); //because " find('.title_container h1') " returns an array
        //var_dump($newTitle);

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
        $txt= base64_encode($detail[0]->plaintext);
        //var_dump($txt);
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

/*$fp2 = fopen('prothomAlo.json', 'r');
//fwrite($fp,json_encode(utf8json($AllContent)));
$vv = fread($fp2,filesize('prothomAlo.json'));
$obj1=json_decode($vv);

echo base64_decode($obj1[0]->title);
echo "<br>";
echo base64_decode($obj1[0]->newsImage);
echo "<br>";
echo base64_decode($obj1[0]->detail);
echo "<br>";
fclose($fp2);*/
//json_encode(utf8json($dataArray));


/*echo $temparr['title'];
echo $temparr['newsImage'];
echo "<br>";
echo $temparr['detail'];

//var_dump($temparr);
*/
//var_dump($AllContent);



//$hell =serialize($temparr);





/*$json = json_encode($temparr);    
$fp = fopen('prothomAlo.json', 'w');
//var_dump($json);
//fwrite($fp, json_encode($temparr));
$s = file_put_contents('prothomAlo.json');
echo json_encode($s);
file_put_contents('prothomAlo.json',json_encode($temparr));
fclose($fp);
*/

?>
