<?php
session_start();
if(isset($_POST['person'])){
   $_SESSION['person']  =  strtoupper(  $_POST['person']) ;
};
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Fight</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>


<div style="border: 3px solid  #212555;text-align: center; color:#2E472A;">
<img src="Img/player1.jpg" class="hero" /> </br>
<a href="index.php"><button id="playAgain"> Play Again</button> </a>
<h3 style="text-width:30px;"> Hello, Knight <?php echo $_SESSION['person'];?>! </h3>



<div >
    <form method="POST" action="app.php">
        <input type="hidden" name="shield" value="<?php echo $_SESSION['person'];?>" >
        <button type="submit" name="use_shield" value=""  id="firstButton"  > Use magic Shield</button>
    </form>
<h4 style="text-width:30px;"> Stimulation Started!</h4>


</div>

<?php include 'classes.php';?>
</body>
</html>






