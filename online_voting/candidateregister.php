
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
    <h2 class="font-x3 uppercase btmspace-80 underlined"> Candidate <a href="#">Registration</a></h2>
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
		$myParty = $_POST['party_name'];
		
		
  		$newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash


      $sql="SELECT * FROM tbmembers WHERE voter_id='$myVoterid'";
      $result= $mysqli->query($sql) or die(mysqli_error());

      // Checking table row
      $count=mysqli_num_rows($result);
      // If username and password is a match, the count will be 1

      if($count>0){
        die( "This Voter Id is linked to some other account.<br><br>Try again <a href=\"candidateregister.php\">Register</a>" );
      }
	    $filename  = basename($_FILES['image']['name']);
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$new       = md5($filename).'.'.$extension;
		$insertname = "uploads/".time()."-{$new}";
		move_uploaded_file($_FILES['image']['tmp_name'], $insertname);
		
		$isCandidate = 1;
  		$sql="INSERT INTO tbmembers(first_name, last_name, email, voter_id, password, is_candidate) VALUES ('$myFirstName','$myLastName', '$myEmail','$myVoterid', '$newpass', '$isCandidate')";
		$result = $mysqli->query($sql)  or die(mysqli_error());
		
		
		
		$result = $mysqli->query("UPDATE `tbmembers` SET `is_candidate` = '1' WHERE `tbmembers`.`voter_id` = '$myVoterid'");
		
		$result = $mysqli->query( "SELECT member_id from tbMembers where voter_id='$myVoterid' and is_candidate='1'" );
        $count=mysqli_num_rows($result);
      
	    $curr_member_id = 1;	
		if($count == 1){
          $user = mysqli_fetch_assoc($result);
		  $curr_member_id = $user['member_id'];
	    }
		
	   
	    $result = $mysqli->query( "SELECT party_id from party where party_name='$myParty'" );
        $count=mysqli_num_rows($result);
      
	    $curr_party_id = 1;
		if($count == 1){
          $user = mysqli_fetch_assoc($result);
		  $curr_party_id = $user['party_id'];
	   }
	   
	   $result = $mysqli->query( "INSERT INTO candidate(member_id, party_id, file_name) VALUES ('$curr_member_id','$curr_party_id','$insertname')" );
	   
	   
		//or die( mysqli_error() );


  	die( "You have registered for an account.Please wait for an admin to approve it.<br><br>Return to, <a href=\"candidatelogin.php\">Login Page </a>" );
  	}
  	echo "<center><h3>Register an account by filling in the needed information below:</h3></center>";
  ?>
</div> 
		<table style="background-color:powderblue;" width="300" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form name="form1" method="post" enctype="multipart/form-data" action="candidateregister.php" onSubmit="return registerValidate(this)">
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
		<td style="color:#000000"; width="40%">Party Name</td>
		<td style="color:#000000"; width="6">:</td>
		<td style="color:#000000"; >
			<select name="party_name" style="width: 94%">
				<?php
					$result = $mysqli->query("SELECT * FROM party WHERE 1");
					while ($row = mysqli_fetch_array($result)){
						echo "<option value='".$row['party_id']."'>".$row['party_name']."</option>";
					}
				?>
			</select>
		</td>
	</tr>


	
	<tr>
	<td style="color:#000000"; width="120" >Voter Id</td>
	<td style="color:#000000"; width="6">:</td>
	<td style="color:#000000"; width="294"><input name="voter_id" type="text" ></td>
	</tr>

	<tr>
		<td style="color:#000000"; >Voter ID Image</td>
		<td style="color:#000000"; >:</td>
		<td style="color:#000000"; ><input type="file" name="image"></td>
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
<br>Already have an account? <a href="candidatelogin.php"><b>Login Here</b></a>
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

