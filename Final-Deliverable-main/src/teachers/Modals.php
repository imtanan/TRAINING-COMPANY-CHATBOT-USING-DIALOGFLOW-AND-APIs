<div class="modal fade" id="UploadVideo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Upload Video Lecture</h4>
			</div>
			<div class="modal-body">
				<form action="Process_Modal_Requests.php" method="POST" enctype="multipart/form-data">
		 		<label>Title</label>
		 		<input type="hidden" name="CourseID" id="v_cid">
		 		<input type="text" name="title" class="form-control" required><br>
		 		<input type="file" name="video" class="form-control" required><br>
		 		<input type="submit" name="AddVideo" value="Upload Video" class="btn btn-success pull-right">
		 		<br><br>
		 	</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="UploadMaterial">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Upload Helping Material</h4>
			</div>
			<div class="modal-body">
				<form action="Process_Modal_Requests.php" method="POST" enctype="multipart/form-data">
		 		<label>Title</label>
		 		<input type="hidden" name="CourseID"  id="m_cid">
		 		<input type="text" name="title" class="form-control" required><br>
		 		<input type="file" name="material" class="form-control" required><br>
		 		<input type="submit" name="AddMeterial" value="Add Material" class="btn btn-success pull-right">
		 		<br><br>
		 	</form>
			</div>
		</div>
	</div>
</div>