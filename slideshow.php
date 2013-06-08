<!DOCTYPE html>
<html> 
    <script type='text/javascript' src='js/jquery.js'></script>
    <?php
    session_start();

    $title = json_decode($_SESSION['title']);
    
    for ($i = 0; $i < sizeof($title); $i++) 
    {
        $title[$i] = utf8_decode($title[$i]);
    }

    $image = json_decode($_SESSION['image']);
    $htmlData = $_SESSION['htmlData'];
   
    ?>


    <head> 
        <!-- for metro ui-->
      
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
         <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/prettify.css">
        <link rel="stylesheet" type="text/css" href="css/metro.css">
        <link rel="stylesheet" type="text/css" href="css/site.css">

        <script type="text/javascript" src="lib/js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="lib/js/jquery.transit.js"></script>
        <script type="text/javascript" src="lib/js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="lib/js/jquery.scrollTo.js"></script>
        <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="lib/js/prettify.js"></script>
        <script type="text/javascript" src="lib/js/metro.js"></script>
        <script type="text/javascript" src="lib/js/site.js"></script>
        <script type="text/javascript" src="lib/js/google-analytics.js"></script>     

        <!-- for metro ui-->

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" > 
        <title>Rss Feed Reader</title> 
        <!--///////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //		Styles
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////--> 
        <link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 

        <style>
            body {
                background-color:  #FFFFFF;
                margin: 0;
                padding: 0;
            }
            #back_to_camera {

                clear: both;
                display: block;
                height: 80px;
                line-height: 40px;
                padding: 20px;
            }
            .fluid_container {
                margin: 0 auto;
                max-width: 1000px;
                width: 90%;
            }
        </style>

        <!--///////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //		Scripts
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////--> 

        <script type='text/javascript' src='lib/js/jquery.min.js'></script>
        <script type='text/javascript' src='lib/js/jquery.mobile.customized.min.js'></script>
        <script type='text/javascript' src='lib/js/jquery.easing.1.3.js'></script> 
        <script type='text/javascript' src='lib/js/camera.min.js'></script> 


        <script>
              
            jQuery(function(){
	          height:30% 
                jQuery('#camera_random').camera({
                  
                    thumbnails: true,
                    fx: 'simpleFade',
                    hover:false
                   
                });
           
            });
			
        </script>


    </head>
    <?php include("header.html");
    ?>
         
    
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="container" style="margin-left:40%;margin-right: 30%;">
                   <a href="generatePDF.php"><button type="button" name="fat-btn" id="fat-btn" class="btn btn-primary container span2" data-loading-text="Downloading...">Download</button></a>
                </div>
            <br>

            <div id="slideshow" class="fluid_container">
                <div class="camera_wrap camera_black_skin" id="camera_random" >
                    
                    <?php
                    $size = sizeof($title);
                    for ($i = 0; $i < $size; $i++) {
                        echo '<div class="cameraSlide topToBottom" data-src="'.$image[$i].'">
			<div class="camera_caption moveFromLeft">
                    ' . $title[$i] . '<em> </em>
                </div>
              </div>';
                    }
                    ?>
                </div><!-- #camera_random -->
            </div><!-- .fluid_container -->
           
           
            
            <div style="clear:both; display:block; height:100px"></div>	

        </div>
    </div>
    

</html>