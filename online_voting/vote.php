<?php
    session_start();
    require('connection.php');
 $mysqli = new mysqli("localhost", "root", "", "poll");
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
        <li><a href="voter.php">Home</a></li>
        <li class="active"><a class="drop" href="#">Voter Pages</a>
          <ul>
            <li class="active"><a href="vote.php">Vote</a></li>
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

<?php 
  if (isset($_GET['id']))
  {
      $id = $_GET['id'];
      $voter_id =$_SESSION['member_id'];
      $candidate_id = $_GET['candidate_id'];
      $mysqli->query( "INSERT INTO tbvote(voter_id,election_id,candidate_id) VALUES ('$voter_id','$id', '$candidate_id')")
      or die("The candidate does not exist ... \n"); 
      echo '<script>Voted Successfully</script>';
      header("Location: vote.php");
  }

?>

<div class="wrapper bgded overlay" style="background-image:url('images/demo/backgrounds/background1.jpg');">
  <section id="testimonials" class="hoc container clear"> 
    <!-- ################################################################################################ -->
    <center>
	<h2 class="font-x3 uppercase btmspace-70 underlined">  <a href="#">Vote</a></h2>
	</center>
    <ul class="nospace group">
      <li class="" style="margin-right: 300px">
            <table border="0" width="100%" align="center" style="margin-left: 100px;margin-top: 50px">
            <CAPTION><h3>ONGOING ELECTIONS</h3></CAPTION>
            <th>Election ID</th>
            <th>Election Name</th>
            <th>Election Registration End Date</th>
            <th>Election Start Date</th>
            <th>Election End Date</th>
            </tr>
            <?php
            $result = $mysqli->query("SELECT * FROM tbelections WHERE status = 'S'");
                while ($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td style='color:#0000ff'>" . $row['election_id']."</td>";
                    echo "<td style='color:#0000ff'>" . $row['election_name']."</td>";
                    echo "<td style='color:#0000ff'>" . $row['reg_date']."</td>";
                    echo "<td style='color:#0000ff'>" . $row['start_date']."</td>";
                    echo "<td style='color:#0000ff'>" . $row['end_date']."</td>";
                    echo '<td style="color:#0000ff"><a href="vote.php?election_id=' . $row['election_id'] . '">Vote in this election</a></td>';
                    echo "</tr>";
                
                }
            ?>
            </table>
    <?php
    // check if the 'id' variable is set in URL
     if (isset($_GET['election_id']))
     {
       // get id value
       $id = $_GET['election_id'];
       $voter_id = $_SESSION['member_id'];
       $result = $mysqli->query("SELECT * FROM tbvote WHERE election_id = '$id' AND voter_id=' $voter_id'");
       $count=mysqli_num_rows($result);
       if($count!=0){
          echo '<script>alert("You have already voted in this election");</script>';
          die();
       }
       $result = $mysqli->query("SELECT * FROM tbcandidates WHERE election_id = '$id'");
       $count=mysqli_num_rows($result);
       if($count==0){
          echo '<script>alert("There are no registered candidates this election");</script>';
          die();
       }
       ?>
       <table border="0" width="100%" align="center" style="margin-left: 100px;margin-top: 50px">
            <CAPTION><h3>CANDIDATES IN THE ELECTION</h3></CAPTION>
            <th>Election ID</th>
            <th>Candidate ID</th>
            <th>Voter Name</th>
            <th>Voter Milestones</th>
            </tr>

            <?php
                //loop through all table rows
                while ($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td style='color:#0000ff'>" . $row['election_id']."</td>";
                    echo "<td style='color:#0000ff'>" . $row['candidate_id']."</td>";
                    $candid =$row['candidate_id'];
                    $res = $mysqli->query("SELECT * FROM tbmembers WHERE member_id = '$candid'");
                    while ($r = mysqli_fetch_array($res)){
                          echo "<td style='color:#0000ff'>" . $r['first_name'].' '. $r['last_name']."</td>";
                          echo "<td style='color:#0000ff;white-space: pre-line'>" . $r['milestones']."</td>";
                    }
                    echo '<td style="color:#0000ff"><a href="vote.php?id='. $row['election_id'] . '&candidate_id='.$row['candidate_id'].'">Vote</a></td>';
                    echo "</tr>";
                }
            ?>
            </table>
         <?php
         $result =  $mysqli->query("UPDATE tbmembers SET is_candidate = '1' WHERE member_id='$id'")
         or die("The candidate does not exist ... \n"); 
         // redirect back to candidates
         //header("Location: manage-profile.php");
     
     }
     else
     // do nothing   
?>
      </li>
      <li class="one_half">

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



