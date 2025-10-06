<div class="modal fade" id="MCQS">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="panel panel-primary">
			<div class="panel-heading text-center">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>Add MCQS</b> </h2>
				<span class="pull-right">
					<a href="index.php?page=teacher_courses" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
			<div class="panel-body">
				<table>
					<form action="" method="POST">
						<input type="hidden" name="C_ID" value="<?=$_GET['C_ID']?>">
						<tr>
							<b>Question :</b> <input type="text" name="question" class="form-control">
						</tr>
						<tr>
							<b>Option A :</b> <input type="text" name="a" class="form-control">
						</tr>
						<tr>
							<b>Option B :</b> <input type="text" name="b" class="form-control">
						</tr>
						<tr>
							<b>Option C :</b> <input type="text" name="c" class="form-control">
						</tr>
						<tr>
							<b>Option D :</b> <input type="text" name="d" class="form-control">
						</tr>
						<tr>
							<b>Correct Answer :</b> <input type="text" name="correct" class="form-control">
						</tr><br>
						<tr>
							<input type="submit" name="submit" value="Add Question" class="btn btn-success pull-right">
						</tr>
					</form>
				</table>
			</div>
		</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-sm-4"><a class="btn btn-primary" data-toggle="modal" href='#MCQS'>Add MCQS</a></div>
	<div class="col-sm-4">
		<?php 
			if (isset($_GET['msg'])) {
			 	echo'<div class="alert alert-info">
			 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			 		<strong>'.$_GET['msg'].'</strong>
			 	</div>';
			 } ?>
	</div><br><br>
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading as-bg" style="">
				<h2 class="panel-title pull-left" style="margin-top: 5px"><b>MCQS</b> (<?=$_GET['title']?>)</h2>
				<span class="pull-right">
					<a href="index.php?page=teacher_courses" class="btn btn-primary txtBlack btn-sm"><i class="fa fa-arrow-left"></i> Back</a><br>
				</span>
			</div>
			<div class="panel-body">
				<table id="table" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Question</th>
							<th>Option 1</th>
							<th>Option 2</th>
							<th>Option 3</th>
							<th>Option 4</th>
							<th>Correct Answer</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						@$CID = $_GET['C_ID'];
						$i  =1;
							$query = mysqli_query($con, "SELECT * FROM quiz AS Q JOIN options AS O ON Q.ID = O.Q_ID WHERE Q.C_ID = '$CID' ");
							while ($que = mysqli_fetch_array($query)) {
							 	echo "<tr>
							 	          <td>$i</td>
							 	          <td>$que[question]</td>
							 	          <td>$que[op1]</td>
							 	          <td>$que[op2]</td>
							 	          <td>$que[op3]</td>
							 	          <td>$que[op4]</td>
							 	          <td>$que[correct]</td>
							 	          <td>
				                         	<a href='index.php?page=add_mcqs&Delete=Yes&ID=$que[ID]&C_ID=$_GET[C_ID]&title=$_GET[title]' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span></a>
				                         	</td>
							 	          </tr>";
							 	        $i++;
							 } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php 
if (isset($_POST['submit'])) {
    
 	$C_ID = $_POST['C_ID'];
 	$title = $_GET['title'];
 	$question = $_POST['question'];
 	$correct = $_POST['correct'];
 	$a = $_POST['a'];
 	$b = $_POST['b'];
 	$c = $_POST['c'];
 	$d = $_POST['d'];

 	$query = "INSERT INTO quiz SET C_ID = '$C_ID', question = '$question', correct = '$correct'";
 	$result  = mysqli_query($con, $query);

 	if ($result) {
	    $last_id = mysqli_insert_id($con);
	    	$qry = "INSERT INTO options SET Q_ID = '$last_id', op1 = '$a', op2 = '$b', op3 = '$c', op4 = '$d'";
	    	mysqli_query($con, $qry);
	    	echo "<script> window.location.href='index.php?page=add_mcqs&C_ID=$C_ID&title=$title&msg=Question Added';</script>";
		}
 }

 if (isset($_GET['Delete'])) {
		$ID = $_GET['ID'];
		$C_ID = $_GET['C_ID'];
		$title = $_GET['title'];

		$result = mysqli_query($con, "DELETE FROM quiz WHERE ID = '$ID'");

		if ($result) {
			mysqli_query($con, "DELETE FROM options WHERE Q_ID = '$ID'");
			echo "<script> window.location.href='index.php?page=add_mcqs&C_ID=$C_ID&title=$title&msg=Question Deleted';</script>";
		}
	}

  ?>