<?php
    session_start();
    require('connection.php');
 $mysqli = new mysqli("localhost", "root", "", "poll");
    //If your session isn't valid, it returns you to the login screen for protection
    if(empty($_SESSION['candidate_id']) || empty($_SESSION['member_id'])){
	 	header("location:access-denied.php");
	}
    //retrive voter details from the tbmembers table
    $result= $mysqli->query("SELECT * FROM tbmembers WHERE member_id = '$_SESSION[member_id]'")
    or die("There are no records to display ... \n" . mysqli_error()); 
    if (mysqli_num_rows($result)<1){
        $result = null;
    }
    $row = mysqli_fetch_array($result);
    if($row)
     {
         // get data from db
         $stdId = $row['member_id'];
         $firstName = $row['first_name'];
         $lastName = $row['last_name'];
         $email = $row['email'];
         $voter_id = $row['voter_id'];
         $is_candidate = $row['is_candidate'];
         $candi_status = $row['candi_status'];
		 $sql = "SELECT c.milestones FROM candidate c, tbmembers t WHERE c.member_id = '$_SESSION[member_id]' AND t.member_id = c.member_id";
		 $result2= $mysqli->query($sql);
		 $row2 = mysqli_fetch_array($result2);
		 if($row2)
		 {
			$milestones = $row2['milestones'];
		 }
     }
?>

<?php
    // updating sql query
    if (isset($_POST['update'])){
        $myId = addslashes( $_GET[id]);
        $myFirstName = addslashes( $_POST['firstname'] ); //prevents types of SQL injection
        $myLastName = addslashes( $_POST['lastname'] ); //prevents types of SQL injection
        $myEmail = $_POST['email'];
        $myPassword = $_POST['password'];
        $myVoterid = $_POST['voter_id'];

        $newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash

        $sql = $mysqli->query( "UPDATE tbmembers SET first_name='$myFirstName', last_name='$myLastName', email='$myEmail', voter_id = '$myVoterid', password='$newpass' WHERE member_id = '$myId'" )
                or die( mysqli_error() );

        // redirect back to profile
         header("Location: manage-profile-candidate.php");
    }
?>



<?php
    // check if the 'id' variable is set in URL
     if (isset($_GET['milestones']))
     {

       // get id value
       $milestones = $_GET['milestones'];
  
         $result =  $mysqli->query("UPDATE candidate SET milestones='$milestones' WHERE member_id = '$_SESSION[member_id]'")
         or die("The candidate does not exist ... \n"); 
         // redirect back to candidates
         header("Location: manage-profile-candidate.php");
     
     }
	 else if (isset($_GET['id']))
     {

       // get id value
       $id = $_GET['id'];
  
         $result =  $mysqli->query("UPDATE tbmembers SET is_candidate = '1' WHERE member_id='$id'")
         or die("The candidate does not exist ... \n"); 
         // redirect back to candidates
         header("Location: manage-profile-candidate.php");
     
     }
     
     else if (isset($_GET['election_id']))
     {

       // get id value
       $election_id = $_GET['election_id'];
  
         $result =   $mysqli->query( "INSERT INTO tbcandidates(candidate_id, election_id) VALUES ('$_SESSION[member_id]','$election_id')" )
         or die("The candidate does not exist ... \n"); 
         // redirect back to candidates
         header("Location: manage-profile-candidate.php");
     
     }
     else
     // do nothing   
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
        <li class="active"><a href="candidate.php">Home</a></li>
        <li><a class="drop" href="#">Candidate Panel</a>
          <ul>
            <li><a href="votecandidate.php">Vote</a></li>
            <li><a href="manage-profile-candidate.php">Update Milestones</a></li>
			<li><a href="electionResultsCandidate.php">Election Results</a></li>
			<li><a href="candidateRegisterElection.php">Register in Election</a></li>
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
    <h2 class="font-x3 uppercase btmspace-80 underlined"> Mention those Awesome <a href="#">Milestones</a></h2>
    <ul class="nospace group">
        <blockquote>
            <table border="0" width="620" align="center">
            <CAPTION><h3>MY PROFILE</h3></CAPTION>
            <form>
            <br>
            <tr><td></td><td></td></tr>
            <tr>
                <td style="color:#000000" width="100%"; >Id:</td>
                <td style="color:#000000"; ><?php echo $stdId; ?></td>
            </tr>
            <tr>

                <td style="color:#000000"; >First Name:</td>
                <td style="color:#000000"; ><?php echo $firstName; ?></td>
            </tr>
            <tr>
                <td style="color:#000000"; >Last Name:</td>
                <td style="color:#000000"; ><?php echo $lastName; ?></td>
            </tr>
            <tr>
                <td style="color:#000000"; >Email:</td>
                <td style="color:#000000"; ><?php echo $email; ?></td>
            </tr>
            <tr>
                <td style="color:#000000"; >Voter Id:</td>
                <td style="color:#000000"; ><?php echo $voter_id; ?></td>
            </tr>
            <tr>
                <td style="color:#000000"; >Password:</td>
                <td style="color:#000000"; >Encrypted</td>
            </tr>
            <tr>
                <td style="color:#000000"; >Candidate Status:</td>
                <?php
                  if($is_candidate == 0){
  echo '<td style="color:#000000";><a href="manage-profile-candidate.php?id=' . $row['member_id'].'">Register as Candidate</a></td>';
                  }
                  else if($candi_status == 1){
                    echo '<td style="color:#000000";>You are a candidate</td>';

                  }
                  else if($candi_status == 0){
                    echo '<td style="color:#000000";>Approval pending from admin</td>';
                  }
                ?>
            </tr>
             <?php if($candi_status == 1){ ?>
            <tr>
                <td style="color:#000000"; >Milestones:</td>
                <td style="color:#000000"; >
                   <form action="manage-profile-candidate.php" method="GET">
                   <textarea style="color:#000000"; font-weight:bold;" name="milestones" maxlength="5000" rows="4" cols="50" minlength="1"><?php echo $milestones;?></textarea>
                   <input type="submit" value="Submit your milestones">
                   </form>
                </td>
            </tr>
          <?php } ?>
            </table>
                  <hr>

            </form>

        </blockquote>
      
      
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


