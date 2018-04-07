<?php
	require('connection.php');

	session_start();
	//If your session isn't valid, it returns you to the login screen for protection
	if(empty($_SESSION['member_id'])){
	 	header("location:access-denied.php");
	}
?>


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
        <li class="active"><a href="voter.php">Home</a></li>
        <li><a class="drop" href="#">Voter Panel</a>
          <ul>
            <li><a href="vote.php">Vote</a></li>
            <li><a href="manage-profile.php">View profile</a></li>
			<li><a href="viewcandidates.php">View Candidates</a></li>
			<li><a href="viewparties.php">View Parties</a></li>
			<li><a href="electionResults.php">View Election Results</a></li>
          </ul>
        </li>
        
        <li><a href="logout.php">Logout</a></li>
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
    <center>
	<h2 class="font-x3 uppercase btmspace-80 underlined"> View <a href="#">Candidates</a></h2>
    </center>
	<ul class="nospace group">
      <li class="one_half first">
        
      </li>
      
    </ul>
    <!-- ################################################################################################ -->
	

	<table border="0" width="620" align="center">
	<CAPTION><h3>CANDIDATES</h3></CAPTION>
	<tr>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Email</th>
	<th>Party</th>
	<th>Milestones</th>
	</tr>

	<?php
		//loop through all table rows
		$sql = "SELECT * FROM tbmembers WHERE is_candidate = '1' and candi_status = '1'";
		$result = $mysqli->query($sql);
		$count=mysqli_num_rows($result);
		if($count > 0)
		{
			while ($row = mysqli_fetch_array($result)){
				$curr_member = $row['member_id'];
				$sql2 = "SELECT p.party_name FROM party p, tbmembers t, candidate c WHERE p.party_id = c.party_id AND c.member_id = t.member_id AND t.member_id = '$curr_member'";
	
				$result2 = $mysqli->query($sql2);
				$count2=mysqli_num_rows($result2);
				if($count2 > 0)
				{
					$user = mysqli_fetch_assoc($result2);
					$curr_party_name = $user['party_name'];
					$sql3 = "SELECT c.milestones FROM tbmembers t, candidate c WHERE c.member_id = t.member_id AND c.member_id = '$curr_member'";
					$result3 = $mysqli->query($sql3);
					$user2 = mysqli_fetch_assoc($result3);
					$curr_milestones = $user2['milestones'];
					
					echo "<tr>";
					echo "<td style='color:#000000'>" . $row['first_name']."</td>";
					echo "<td style='color:#000000'>" . $row['last_name']."</td>";
					echo "<td style='color:#000000'>" . $row['email']."</td>";
					echo "<td style='color:#000000'>" . $curr_party_name."</td>";
					echo "<td style='color:#000000'>" . $curr_milestones."</td>";
					echo "</tr>";
						
				}
				
				
				
			}
			
			
			
		}
		
	?>

	</table>
	
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


