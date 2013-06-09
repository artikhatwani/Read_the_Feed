<!DOCTYPE html>
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
           <script type="text/javascript" src="lib/js/bootstrap.js"></script>
           <script type="text/javascript" src="lib/js/bootstrap-carousel.js"></script>
           <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap-transition.js"></script>
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
       
        </head>
       
        <div class="container" style="margin-left:35%;margin-right:10%;padding-top:3%">
                   <a href="generatePDF.php"><button type="button" name="fat-btn" id="fat-btn" class="btn btn-primary container span2" data-loading-text="Downloading...">Download</button></a>
        <a href="FeedsList.php" style="margin-left:32%;padding-top:3%"><button type="button" class="btn btn-primary container span2">Back</button></a>
            <br>      
        
        </div>
        
         
        <div class="container thumbnail" style="width:400px;margin-top:5%">
      <div id="myCarousel" class="carousel slide">  
  <!-- Carousel items -->
  
  <div class="carousel-inner">
    <?php for($i=0;$i<$GLOBALS['size'];$i++){ 
      if($i==0){ ?>
    <div class="item active">
        <img style="margin-left: 30%" src="data:image/jpeg;base64,<?php echo $image[$i] ?>" />
    
    <div style="margin-left: 20%" class="corousel-caption">
        <h4><?php echo $title[$i]; ?></h4>
        </div>
   </div>
       <?php }
       else {  ?>
      <div class="item">
        <img style="margin-left: 30%" src="data:image/jpeg;base64,<?php echo $image[$i] ?>" />
    
    <div style="margin-left: 20%" class="corousel-caption">
        <h4><?php echo $title[$i]; ?></h4>
        </div>
   </div> <?php } } ?>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
  <a href="#" id="play"><img src="images/play.jpg" style="margin-left:40%;height:40px;width:40px;"></a>
  <a href="#"> <img id="still" src="images/pause.jpg" style="height:40px;width:50px;"> </a>
</div>  
    </div> 
       <script type="text/javascript">
//         
//          $('.carousel.slide').carousel({
//             interval: false
//              });

$(document).on('mouseleave','.carousel', function(){
  $("#myCarousel").carousel('pause');
});
             $("#still").click(function() {
             $("#myCarousel").carousel('pause');
            
            });
           
            $("#play").click(function() {
             $("#myCarousel").carousel("cycle");
            
            });
           
         </script>      
       
</html>
