<?php

class Rss {
    /*     * *************Declaring Variables*************** */

    public $title = array();
    public $image = array();
    
    public $whole = '<html><body>';
    public $description="";
	public $sub=array();
	public $link="";
        public $url="";
      
    //public $ses_id=session_id();
    /*     * ********************************************** */

    public function validateFeed($sFeedURL) {
      
        $sValidator = 'http://feedvalidator.org/check.cgi?url=';

        if ($sValidationResponse = @file_get_contents($sValidator . urlencode($sFeedURL))) {
            if (stristr($sValidationResponse, 'This is a valid RSS feed') !== false) {
                
           $matches=array();
           $myURL = $sValidator.$sFeedURL;
if (preg_match(
        '/<title>(.+)<\/title>/',
        file_get_contents($myURL),$matches) 
    && isset($matches[1] ))
   $title=$matches[1];
else
   $title = "Not Found";
   
  
   $url=substr($title,23);
   
                 return array(true,$url);
              
            } else {
                return array(false,"");
            }
        } else {
            return false;
        }
    }

    public function readFeed($url) {
       // $xml = simplexml_load_file($url);
        //$xmlString = file_get_contents($url);
        $xml = new SimpleXMLElement($url,null,true);
        $doc = new DOMDocument();
        //Read XML feed
        for ($i = 0; $i < 10; $i++) {
            if (empty($xml->channel->item[$i]->title)) {
                break;
            }
            $title[$i] = $xml->channel->item[$i]->title;
           
            $title[$i] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $title[$i]);
          

            $title[$i] = htmlspecialchars($title[$i], ENT_QUOTES);
            $content = $xml->channel->item[$i]->children("content", true);
            $description=$xml->channel->item[$i]->description;
                
// $description[$i] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $description[$i]);
           //$description[$i] = htmlspecialchars($description[$i], ENT_QUOTES);
			$sub[$i]=substr($description,0,150);
			$link[$i]=$xml->channel->item[$i]->link;
                         $link[$i] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $link[$i]);
                         $link[$i] = htmlspecialchars($link[$i], ENT_QUOTES);
           
                         @$doc->loadHTML($content);
            $tags = $doc->documentElement->getElementsByTagName('img');

            if ($tags->length == 0) { //If no image is found


                $image[$i] = "images/noimage.gif";
            }

            foreach ($tags as $tag) {
                $image[$i] = $tag->getAttribute('src');

                break;
            }
        }

          

        return array($title,$image,$sub,$link);
    }
public function resizeImage($title,$image)
{
       $unique=  uniqid();
      $folder_path='images/thumbnails/';
    // set up basic connection
$conn_id = ftp_connect('freetzi.com');

// login with username and password
$login_result = ftp_login($conn_id,'readthefeed.coolpage.biz','deepak5306');

// try to create the directory $dir
//$dir=ftp_mkdir($conn_id, 'images/thumbnails/'.$unique.'/');
 ftp_chmod($conn_id, 0777, $folder_path);

// close the connection
ftp_close($conn_id);
   
 
  
    $finalimage=array();
    $size=sizeof($title);
    for($i=0;$i<$size;$i++)
    {
		 if($image[$i]=='images/noimage.gif')
        {
             $finalimage[$i]=$image[$i];
        }
				else{
    $image[$i]=str_replace("https", "http", $image[$i]);
   // echo $image[$i];
    $imagesize=getimagesize($image[$i]);
    $type=$imagesize['mime'];
    $image_width=$imagesize[0];
    $image_height=$imagesize[1];
    $new_width=150;
    $new_height=150;
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
             if($type == "image/jpeg") {
		
		$old_image=imagecreatefromjpeg($image[$i]);
	       }
               elseif($type == "image/png") {
		
		$old_image = imagecreatefrompng($image[$i]);
        	} elseif($type == "image/gif"){
	
		$old_image = imagecreatefromgif($image[$i]);
	        }
                imagecopyresized($new_image,$old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
        
         if($type == "image/jpeg") {
               
                 imagejpeg($new_image,$folder_path.$unique.'_'.$i.'.jpeg',100);  
                 $finalimage[$i]=$folder_path.$unique.'_'.$i.'.jpeg';
								 
                  $fp = fopen( $finalimage[$i], 'r'); 
                 ftp_fput($conn_id, $finalimage[$i], $fp, FTP_BINARY); 
               
              
	} else if($type == "image/png"){
		
		      
                 imagepng($new_image,$folder_path.$unique.'_'.$i.'.png',9);
                   $finalimage[$i]=$folder_path.$unique.'_'.$i.'.png';
									 
                   $fp = fopen( $finalimage[$i], 'r'); 
                 ftp_fput($conn_id,  $finalimage[$i], $fp, FTP_BINARY); 
               
             
	}
	else
	{
                  
		  
                 imagegif($new_image,$folder_path.$unique.'_'.$i.'.gif'); 
                 $finalimage[$i]=$folder_path.$unique.'_'.$i.'.gif';
								
                  $fp = fopen( $finalimage[$i], 'r'); 
                 ftp_fput($conn_id,  $finalimage[$i], $fp, FTP_BINARY); 
               
       
	}
  }
  
}

 $whole = '<html><body>';
        for ($i = 0; $i < $size; $i++) {
            //combinig data for pdf
            $whole = $whole . '<table style="page-break-after: always;"><tr><td><h2>' . $title[$i] . '</h2></td></tr><tr><td><img src="'.$finalimage[$i].'" /></td></tr></table>';
      
            //saving images in a file
            
 
            }
        $whole.="</body></html>";
        
        
    return array($whole,$finalimage);
}
function recursiveDelete($directory)
{

$handle = ftp_connect('freetzi.com');

// login with username and password
ftp_login($handle,'readthefeed.coolpage.biz','deepak5306');
# here we attempt to delete the file/directory
ftp_chdir($handle, $directory);
$files = ftp_nlist($handle, ".");
foreach ($files as $file)
{
    ftp_delete($handle, $file);
} 
  
}

}
?>