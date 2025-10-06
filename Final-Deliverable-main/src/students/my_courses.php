<div class="row">



	<div class="modal fade" id="FeeModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Pay Fee</h4>
				</div>
				<div class="modal-body">
					<form action="" method="POST">
						<div class="form-group">
							<label for="">Fee</label>
							<input type="hidden" name="ID" id="ID">
							<input type="text" class="form-control" name="fee" id="fee" readonly>
							<input type="hidden" name="C_ID" id="C_ID">
						</div>
						<div class="form-group">
							<label for="">Easypaisa/Jazzcash Account No</label>
							<input type="number" class="form-control" name="number" placeholder="Account No" required>
						</div>
						<div class="form-group">
							<label for="">Pin</label>
							<input type="number" class="form-control" name="pin" placeholder="Account Pin" required>
						</div>
						<button type="submit" name="Pay" class="btn btn-primary">Pay</button>
					</form>

				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-offset-2 col-sm-8">

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="panel-title">My Courses</h2>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped">
					<tr>
						<th>ID</th>
						<th>Course Title</th>
						<th>Course Wesbite</th>
					</tr>


					<?php
					$SID = $_SESSION['USER_ID'];
					$i = 1;

					$result = mysqli_query($con, "SELECT * FROM course_enroll AS CE INNER JOIN courses AS C ON CE.C_ID = C.ID WHERE S_ID = '$SID'");
					while ($row = mysqli_fetch_array($result)) {
						echo "<tr>
					<td>$i</td>
					<td>$row[title]</td>";
						if ($row['fee_status'] == "Not Paid") {
							echo "<td><a href='#' ID='$row[0]' Fee='$row[fee]' C_ID='$row[C_ID]' class='btn btn-sm btn-warning PayFee'>Pay Fee</a></td>";
						} else {
							echo "<td><a href='index.php?page=course_website&C_ID=$row[C_ID]&title=$row[title]' class='btn btn-info'>Course Wesbite</a></td>";
						}


						echo "</tr>";
						$i++;
					} ?>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
	if (isset($_POST['Pay'])) {
		$ID = $_POST['ID'];
		$C_ID = $_POST['C_ID'];
		$amount = $_POST['fee'];
		$Qry = mysqli_query($con, "UPDATE course_enroll SET fee_status = 'Paid' WHERE ID = '$ID'");
		if ($Qry) {
			mysqli_query($con, "INSERT INTO transactions SET S_ID = '$SID', C_ID = '$C_ID', amount = '$amount'");
			echo "<script> window.location.href='index.php?page=my_courses'; </script>";
		}
	}
?>

