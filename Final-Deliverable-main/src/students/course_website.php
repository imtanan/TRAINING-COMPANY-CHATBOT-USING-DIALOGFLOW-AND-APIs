<?php $C_ID = $_GET['C_ID'];

$SID = $_SESSION['USER_ID'];

$result = mysqli_query($con, "SELECT * FROM course_enroll AS CE INNER JOIN courses AS C ON CE.C_ID = C.ID WHERE CE.C_ID = '$C_ID' AND S_ID = '$SID'");
$row = mysqli_fetch_array($result);
	if ($row['fee_status'] == "Not Paid") {
		echo "<script> alert('Pay your fee to access course content'); window.location.href='index.php?page=my_courses'; </script>";
	} 
	?>

<div class="row" style="margin-top: -12px !important">
	<div style="background: #201D1D; padding: 10px 10px; padding-right: 15px">
		<?=str_repeat('&nbsp;', 10); ?>
		<button type="button" class="btn btn-primary active"    onclick="Download()">My Files</button>
		<?=str_repeat('&nbsp;', 15); ?>
		<a href="index.php?page=quizzes&C_ID=<?=$C_ID?>&title=<?=$_GET['title']?>" class="btn btn-info">Quiz</a>
		<?=str_repeat('&nbsp;', 15); ?>
		<button type="button" class="btn btn-warning active" onclick="Lectures()">Video Lectures</button>
		<?=str_repeat('&nbsp;', 15); ?>
		<button type="button" class="btn btn-danger active" onclick="LiveClass()">Live Class</button>
		
		<span class="courseTitle pull-right" style="color: #fff; font-weight: bold; font-size: 13pt"><?=$_GET['title']; ?></span>
	</div>
	<div onload="visibility:hidden">
	  <div id="download" style="display:none" class="col-sm-4">
	  	<h2 class="text-center">Course Material</h2>
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>ID</th>
	  			<th>Title</th>
	  			<th>Download</th>
	  		</tr>

	  		<?php 
	  		
	  		$query = mysqli_query($con,"SELECT * FROM course_material WHERE C_ID = '$C_ID'");
	  		$count = mysqli_num_rows($query);
	  		if ($count >0) {
	  		 	while ($row = mysqli_fetch_array($query)) {
	  		 	    echo "<tr>
	  		 			<td>$row[ID]</td>
	  		 			<td>$row[title]</td>
	  		 			<td><a href='../assets/material/$row[material]' class='btn btn-success' download>Download</a></td></tr>";
	  		 	}
	  		 } else {
	  		 	echo "<tr>
	  		 			<td colspan='3' class='text-center'>No Record Found</td>
	  		 		 </tr>";
	  		 } ?>
	  	</table>
	</div>

	<div id="lecture" class="col-sm-8" style="display:none; max-height: 450px; overflow: scroll;">
		<h2 class="text-center">Video Lectures</h2>
		<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>ID</th>
	  			<th>Title</th>
	  			<th>Lecture Video</th>
	  		</tr>

	  		<?php 
	  		$query = mysqli_query($con,"SELECT * FROM course_video WHERE C_ID = '$C_ID'");
	  		$count = mysqli_num_rows($query);
	  		if ($count >0) {
	  		 	while ($row = mysqli_fetch_array($query)) {
	  		 	    echo "<tr>
	  		 			<td>$row[ID]</td>
	  		 			<td>$row[title]</td>
	  		 			<td>
		  		 			<video width='320' height='240' controls>
							  <source src='../assets/videos/$row[video]' type='video/mp4'>
							</video>
						</td>";
	  		 	}
	  		 } else {
	  		 	echo "<tr>
	  		 			<td colspan='3' class='text-center'>No Record Found</td>
	  		 		 </tr>";
	  		 } ?>
	  	</table>
	</div>
	<div id="live_class" class="col-sm-offset-3 col-sm-6" style="display:none">
		<h2 class="text-center">Live Class</h2>
		<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>ID</th>
						<th>Course</th>
						<th>Section</th>
						<th>Scheduled On</th>
						<th>Timing</th>
						<th>Join Class</th>
	  		</tr>

	  		<?php 
	  		$i = 1;
					$qry = mysqli_query($con, "SELECT * from courses AS C JOIN live_classes AS LC ON C.ID = LC.C_ID WHERE LC.C_ID = '$C_ID'");
					$count = mysqli_num_rows($qry);

						while ($row = mysqli_fetch_array($qry)) {
						   

					    echo "<tr>
					    		<td>$i</td>
					    		<td>$row[title]</td>
					    		<td>$row[section]</td>
					    		<td>$row[_date]</td>
					    		<td>$row[_time]</td>";
					    		$date1=date_create($row['_date']);
								$date2=date_create(date('Y-m-d'));
								$diff=date_diff($date1,$date2);
								$chk = $diff->format("%a");
					    		if ($chk > 0) {
					    			echo "<td>--</td>";
					    		} else {
					    			echo "<td><a href='join_class.php' target='_blank' class='btn btn-info btn-sm text-black'>Join</a></td>";
					    		}
					    		
					    		
					    	echo"</tr>";
					    $i++;
						}
			 ?>
	  	</table>
	</div>
</div>
</div>