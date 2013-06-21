<!DOCTYPE html>
<?php include("header.html"); ?>
 <html>
    <?php
    session_start();

    $title = json_decode($_SESSION['title']);
    $GLOBALS['size']=sizeof($title);
    for ($i = 0; $i < $GLOBALS['size']; $i++) 
    {
        $title[$i] = utf8_decode($title[$i]);
    }

    $image = json_decode($_SESSION['image']);
    $htmlData = $_SESSION['htmlData'];
  
    ?>
     <head>
           <script type='text/javascript' src='lib/js/jquery.js'></script>
           
             <script type='text/javascript' src='lib/js/jquery.anythingslider.min.js'></script>
           
      
      
          
           <script type="text/javascript" src="lib/js/bootstrap.js"></script>
          
           
         
            
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
            <link rel="stylesheet" type="text/css" href="css/anythingslider.css">
     
<style>

 #slider {
  width: 600px;
  height: 350px;
  list-style: none;
 }
</style>
<script>
    $(document).ready(function(){
		
                          $('#slider') // Demo 2 code, using FX base effects
  .anythingSlider({
   resizeContents      : false
  /* navigationFormatter : function(i, panel){
    return ['', '', '', '', '', ''][i - 1];
   }*/
  })
  .anythingSliderFx({
    // base FX definitions
    // '.selector' : [ 'effect(s)', 'size', 'time', 'easing' ]
    // 'size', 'time' and 'easing' are optional parameters, but must be kept in order if added
    '.quoteSlide:first > *' : [ 'grow', '24px', '400', 'easeInOutCirc' ],
    '.quoteSlide:last'      : [ 'top', '500px', '400', 'easeOutElastic' ],
    '.expand'               : [ 'expand', '10%', '400', 'easeOutBounce' ],
    '.textSlide h3'         : [ 'top fade', '200px', '500', 'easeOutBounce' ],
    '.textSlide img,.fade'  : [ 'fade' ],
    '.textSlide li'         : [ 'listLR' ]
  });
                         
                          });
   
 
</script>

</head>
 <div class="container" style="margin-left:35%;margin-right:10%;padding-top:3%">
                   <a href="generatePDF.php"><button type="button" name="fat-btn" id="fat-btn" class="btn btn-primary container span2" data-loading-text="Downloading...">Download</button></a>
        <a href="FeedsList.php" style="margin-left:32%;padding-top:3%"><button type="button" class="btn btn-primary container span2">Back</button></a>
            <br>      
        
        </div><br><br>
<div>
  <ul id="slider" > 
 <?php 
  for($i=0;$i<$GLOBALS['size'];$i++){  ?>
  
        <li class="panel1">
    <!-- Note this caption is before the image, all others it is after -->
    <div class="textSlide">
    
    <img style="padding:40px;" src="<?php echo $image[$i] ?>" alt="" />
    <div class="caption-bottom"><b><?php echo $title[$i]; ?></b></div>
    </div>
  
        </li>
  
	<?php } ?>     
   </ul>
   </div>
</body>
      </html>
