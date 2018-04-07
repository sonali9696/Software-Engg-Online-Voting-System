<?php
    session_start();
    require('../connection.php');
    if(empty($_SESSION['admin_id'])){
      header("location:access-denied.php");
    } 
    $mysqli = new mysqli("localhost", "root", "", "poll");
    $result = $mysqli->query("SELECT * FROM tbmembers WHERE voter_status = '0'");
    //or die("There are no records to display ... \n" . mysqli_error()); 
    if (mysqli_num_rows($result)<1){
        $result = null;
    }
?>


<?php
if (isset($_POST['Submit']))
{

    $newCandidateName = addslashes( $_POST['name'] ); //prevents types of SQL injection
    $newCandidatePosition = addslashes( $_POST['position'] ); //prevents types of SQL injection
    

    $sql = $mysqli->query( "INSERT INTO tbCandidates(candidate_name,candidate_position) VALUES ('$newCandidateName','$newCandidatePosition')" )
            or die("Could not insert candidate at the moment". mysqli_error() );

    // redirect back to candidates
     header("Location: candidates.php");
    }
?>

<?php
    // check if the 'id' variable is set in URL
     if (isset($_GET['id']))
     {

       // get id value
       $id = $_GET['id'];
       $status =$_GET['status'];
	   $type =$_GET['type'];
	   if($type == 'candi')
	   {
		   $mysqli->query( "UPDATE tbmembers SET candi_status='$status' WHERE member_id='$id'");
	   }
	   else if($type == 'voter')
	   {
		   $mysqli->query( "UPDATE tbmembers SET voter_status='$status' WHERE member_id='$id'");
	   }
	   
       if($status==1)
            header("Location: candidates.php?approval=success");
        else
            header("Location: candidates.php?approval=denied");
     
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

<script language="JavaScript" src="js/user.js">
</script>

</head>
<body id="top">


<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    
    <div id="logo" class="fl_left">
      <h1><a href="index.php">ONLINE VOTING</a></h1>
    </div>
    
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li><a href="admin.php">Home</a></li>
        <li class="active"><a class="drop" href="#">Admin Panel Pages</a>
          <ul>
           <!--  <li><a href="manage-admins.php">Manage Admin</a></li>
            <li><a href="positions.php">Manage Positions</a></li> -->
            <li><a href="elections.php">Elections</a></li>
            <li><a href="candidates.php">Approve Users</a></li>
            <li class="active"><a href="results.php">Results</a></li>
          </ul>
        </li>
        
        <!-- <li><a href="http://localhost/online_voting/index.php">Voter Panel</a></li> -->
        <li><a href="logout.php">Logout</a></li>

      </ul>
    </nav>
    
  </header>
</div>

<div >
<hr>
<table border="0" width="620" align="center">
<CAPTION><h3>AVAILABLE VOTERS FOR APPROVAL</h3></CAPTION>
<tr>
<th>Voter ID</th>
<th>Voter Name</th>
<th>Voter Email</th>
</tr>

<?php
    //loop through all table rows
    while ($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['voter_id']."</td>";
    echo "<td>" . $row['first_name'].' '.$row['last_name']."</td>";
    echo "<td>" . $row['email']."</td>";
    echo '<td style="color:#000000"><a href="candidates.php?id=' . $row['member_id'] . '&status=1&type=voter">Approve Voter</a></td>';
    echo '<td style="color:#000000"><a href="candidates.php?id=' . $row['member_id'] . '&status=-1&type=voter">Deny Voter</a></td>';
	echo "</tr>";
    }
?>

</table>

<hr>
<table border="1" width="620" align="center">
<CAPTION><h3>AVAILABLE CANDIDATES FOR APPROVAL</h3></CAPTION>
<tr>
<th>Candidate Name</th>
<th>Candidate Email</th>
<th>Voter ID</th>
<th>Voter ID Image</th>
</tr>

<?php
	

			$result = $mysqli->query("SELECT * FROM tbmembers WHERE candi_status = '0' AND is_candidate = '1'");
   //or die("There are no records to display ... \n" . mysqli_error()); 
    if (mysqli_num_rows($result)<1){
        $result = null;
    }
    //loop through all table rows
    while ($row= mysqli_fetch_array($result)){
		$curr_member = $row['member_id'];
	$sql2="SELECT * from candidate where member_id='$curr_member'";	
	$result2 = $mysqli->query($sql2);
    $count=mysqli_num_rows($result2);
      
		$fileName = "default";
	    if($count == 1){
          $user = mysqli_fetch_assoc($result2);
		  $fileName = $user['file_name'];
	    }
	
		
	echo "<tr>";
    echo "<td style='color:#000000'>" . $row['first_name'].' '.$row['last_name']."</td>";
    echo "<td style='color:#000000'>" . $row['email']."</td>";
	echo "<td style='color:#000000'>" . $row['voter_id']."</td>";
	echo "<td style='color:#000000'><a href='../" . $fileName  . "'>View</a></td>";
    echo '<td style="color:#000000"><a href="candidates.php?id=' . $row['member_id'] . '&status=1&type=candi">Approve Candidate</a></td>';
    echo '<td style="color:#000000"><a href="candidates.php?id=' . $row['member_id'] . '&status=-1&type=candi">Deny Candidate</a></td>';
	echo "</tr>";
    }
    mysqli_free_result($result);
    mysqli_close($mysqli);

?>

</table>
	<?php
	if($_GET['approval'] == 'success')
	{?>
		<h4 align="center">Approved</h4>
		<?php
	}
	?>
	<?php
	if($_GET['approval'] == 'denied')
	{?>
		<h4 align="center">Denied</h4>
		<?php
	}?>
<hr>
</div>


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








