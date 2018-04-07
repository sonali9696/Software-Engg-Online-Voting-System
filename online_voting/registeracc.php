
<!DOCTYPE html>

<html>
<head>
<title>online voting</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<!-- <link href="css/user_styles.css" rel="stylesheet" type="text/css" /> -->
<script language="JavaScript" src="js/user.js">
</script>

</head>
<body id="top">
<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div id="logo" class="fl_left">
      <h1><a href="index.php">ONLINE VOTING</a></h1>
    </div>
    <!-- ################################################################################################ -->
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="admin/index.php">Admin</a></li>
        <li><a class="drop" href="#">Voter Panel</a>
          <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="registeracc.php">Registration</a></li>
            
          </ul>
        </li>
        
		<li><a class="drop" href="#">Candidate Panel</a>
          <ul>
            <li><a href="candidatelogin.php">Login</a></li>
            <li><a href="candidateregister.php">Registration</a></li>
            
          </ul>
        </li>
		
      </ul>
    </nav>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/background1.jpg');">
  <section id="testimonials" class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <h2 class="font-x3 uppercase btmspace-80 underlined"> Voter <a href="#">Registration</a></h2>
    <ul class="nospace group">
      <li class="one_half">
        <blockquote>


<div  >
  <?php
  	require('connection.php');
    $mysqli = new mysqli("localhost", "root", "", "poll");
  	//Process
  	if (isset($_POST['submit']))
  	{

  		$myFirstName = addslashes( $_POST['firstname'] ); //prevents types of SQL injection
  		$myLastName = addslashes( $_POST['lastname'] ); //prevents types of SQL injection
  		$myEmail = $_POST['email'];
  		$myPassword = $_POST['password'];
  		$myVoterid = $_POST['voter_id'];

  		$newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash


      $sql="SELECT * FROM tbmembers WHERE voter_id='$myVoterid'" or die(mysqli_error());
      $result= $mysqli->query($sql) or die(mysqli_error());

      // Checking table row
      $count=mysqli_num_rows($result);
      // If username and password is a match, the count will be 1

      if($count>0){
        die( "This Voter Id is linked to some other account.<br><br>Try again <a href=\"registeracc.php\">Register</a>" );
      }
	  else
	  {
		$sql = "INSERT INTO tbMembers(first_name, last_name, email, voter_id, password) VALUES ('$myFirstName','$myLastName', '$myEmail','$myVoterid', '$newpass')";
		$result= $mysqli->query($sql) or die(mysqli_error());
		die("You have registered for an account.Please wait for an admin to approve it. <a href='registeracc.php'>Register</a> or <a href='login.php'>Login</a>");
	
	  }
  	}
  	echo "<center><h3>Register an account by filling in the needed information below:</h3></center>";
  ?>
</div> 
		<table style="background-color:powderblue;" width="300" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form name="form1" method="post" action="registeracc.php" onSubmit="return registerValidate(this)">
<td>
<table style="background-color:powderblue;" width="100%" border="0" cellpadding="3" cellspacing="1" >
	<tr>
	<td style="color:#000000"; width="120" >First Name</td>
	<td style="color:#000000"; width="6">:</td>
	<td style="color:#000000"; width="294"><input name="firstname" type="text" ></td>
	</tr>

	<tr>
	<td style="color:#000000"; width="120" >Last Name</td>
	<td style="color:#000000"; width="6">:</td>
	<td style="color:#000000"; width="294"><input name="lastname" type="text" ></td>
	</tr>

	<tr>
	<td style="color:#000000"; width="150" >Email</td>
	<td style="color:#000000"; width="6">:</td>
	<td style="color:#000000"; width="294"><input name="email" type="text" ></td>
	</tr>

	<tr>
	<td style="color:#000000"; width="120" >Voter Id</td>
	<td style="color:#000000"; width="6">:</td>
	<td style="color:#000000"; width="294"><input name="voter_id" type="text" ></td>
	</tr>

	<tr>
	<td style="color:#000000"; >Password</td>
	<td style="color:#000000"; >:</td>
	<td style="color:#000000"; ><input name="password" type="password" ></td>
	</tr>

	<tr>
	<td style="color:#000000"; >Confirm Password</td>
	<td style="color:#000000"; >:</td>
	<td style="color:#000000"; ><input name="ConfirmPassword" type="password" ></td>
	</tr>

	<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td style="color:#000000";><input type="submit" name="submit" value="Register Account"></td>
	</tr>

</table>
</td>
</form>
</tr>
</table>

<center>
<br>Already have an account? <a href="login.php"><b>Login Here</b></a>
</center>



        </blockquote>
      
      </li>
    </ul>
    <!-- ################################################################################################ -->
  </section>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="one_third first">
      <h6 class="title">Address</h6>
      <ul class="nospace linklist contact">
        <li><i class="fa fa-map-marker"></i>
          <address>
         
          <p>
          Name        : Ms. Sonali Agrawal <br>
          University  : NIT Rourkela <br>
          Batch       : 2018 <br>
          Dept        : CSE <br>
          </p>
          </address>
        </li>
      </ul>
    </div>

    <div class="one_third">
      <h6 class="title">Phone</h6>
      <ul class="nospace linklist contact">
       
        <li><i class="fa fa-phone"></i> +91 9438372535<br>
          +91 7978918951</li>


      </ul>
    </div>

    <div class="one_third">
      <h6 class="title">Email</h6>
      <ul class="nospace linklist contact">
        
        <li><i class="fa fa-envelope-o"></i> sonali9696@gmail.com </li>

      </ul>
    </div>


    <!-- ################################################################################################ -->
  </footer>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Ms. Sonali Agrawal</a></p>
    <p class="fl_right">Developed for <a target="_blank" href="http://www.os-templates.com/" title="Free Website Templates">Software Engineering Lab</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<!-- IE9 Placeholder Support -->
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<!-- / IE9 Placeholder Support -->
</body>
</html>

