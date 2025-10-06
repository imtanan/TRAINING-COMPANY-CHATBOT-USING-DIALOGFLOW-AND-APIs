<div class="row">
	<br><br>

	<div class="col-sm-offset-1 col-sm-10">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title pull-left"><b>Courses List</b></h3>
				<button class="btn btn-warning btn-sm pull-right" onclick="openAddModal()">Add New Course</button>
			</div>
			<div class="panel-body">

				<table id="table" class="table table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Fee</th>
							<th>Duration</th>
							<th>Level</th>
							<th>Mode</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$result = mysqli_query($con, "SELECT * FROM courses");
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>
              <td>{$row['ID']}</td>
              <td>{$row['title']}</td>
              <td>{$row['fee']}</td>
              <td>{$row['duration']}</td>
              <td>{$row['level']}</td>
              <td>{$row['mode']}</td>
              <td>
                <button class='btn btn-info btn-sm' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button>
                <a href='?page=manage_courses&delete={$row['ID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this course?\")'>Delete</a>
              </td>
            </tr>";
						}
						?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<form method="POST" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h5 class="modal-title" id="modalTitle">Add/Edit Course</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="course_id" id="course_id">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="title" id="title" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea name="description" id="description" class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Fee</label>
						<input type="number" name="fee" id="fee" class="form-control" required>
					</div>
					<div class="form-row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Duration</label>
								<input type="text" name="duration" id="duration" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Level</label>
								<input type="text" name="level" id="level" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Mode</label>
								<select name="mode" id="mode" class="form-control">
									<option value="Online">Online</option>
									<option value="Offline">Offline</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Certification Info</label>
						<textarea name="certification" id="certification" class="form-control" placeholder="e.g., You will receive a certificate of completion."></textarea>
					</div>
					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Image</label>
								<input type="file" name="image" id="image" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Brochure (PDF or Document)</label>
								<input type="file" name="brochure" id="brochure" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="add_course" id="addBtn" class="btn btn-success">Add</button>
					<button type="submit" name="update_course" id="updateBtn" class="btn btn-primary">Update</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php

if (isset($_POST['add_course'])) {
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$fee = $_POST['fee'];
	$duration = $_POST['duration'];
	$level = $_POST['level'];
	$mode = $_POST['mode'];
	$certification = $_POST['certification'];

	$time = time();

	// Image
	$image = $_FILES['image']['name'];
	$tmp_img = $_FILES['image']['tmp_name'];
	$imgName = '';
	if ($image != "") {
		$parts = explode(".", $image);
		$imgName = $time . "_img." . end($parts);
		move_uploaded_file($tmp_img, "../assets/images/$imgName");
	}

	// Brochure
	$brochure = $_FILES['brochure']['name'];
	$tmp_brochure = $_FILES['brochure']['tmp_name'];
	$brochureName = '';
	if ($brochure != "") {
		$parts = explode(".", $brochure);
		$brochureName = $time . "_brochure." . end($parts);
		move_uploaded_file($tmp_brochure, "../assets/brochures/$brochureName");
	}

	mysqli_query($con, "INSERT INTO courses (title, description, image, fee, duration, level, mode, certification, brochure) 
		VALUES ('$title', '$desc', '$imgName', '$fee', '$duration', '$level', '$mode', '$certification', '$brochureName')");
	echo "<script>window.location='index.php?page=manage_courses';</script>";
}


if (isset($_POST['update_course'])) {
	$id = $_POST['course_id'];
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$fee = $_POST['fee'];
	$duration = $_POST['duration'];
	$level = $_POST['level'];
	$mode = $_POST['mode'];
	$certification = $_POST['certification'];

	$img_sql = "";
	if ($_FILES['image']['name']) {
		$image = $_FILES['image']['name'];
		$tmp_img = $_FILES['image']['tmp_name'];
		$imgName = time() . "_img." . end(explode(".", $image));
		move_uploaded_file($tmp_img, "../assets/images/$imgName");
		$img_sql = ", image='$imgName'";
	}

	$brochure_sql = "";
	if ($_FILES['brochure']['name']) {
		$brochure = $_FILES['brochure']['name'];
		$tmp_brochure = $_FILES['brochure']['tmp_name'];
		$brochureName = time() . "_brochure." . end(explode(".", $brochure));
		move_uploaded_file($tmp_brochure, "../assets/brochures/$brochureName");
		$brochure_sql = ", brochure='$brochureName'";
	}

	mysqli_query($con, "UPDATE courses SET title='$title', description='$desc', fee='$fee', duration='$duration', level='$level', mode='$mode', certification='$certification' $img_sql $brochure_sql WHERE ID='$id'");
	echo "<script>window.location='index.php?page=manage_courses';</script>";
}



// Handle Delete
if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	mysqli_query($con, "DELETE FROM courses WHERE ID='$id'");
	echo "<script>window.location='index.php?page=manage_courses';</script>";
}
?>