<div class="row" style="margin-top: -12px !important">
	<div style="background: #201D1D; padding-right: 15px; height: 45px; line-height: 45px;">
		<div class="col-sm-4"> <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#AnnouncModal">Make an Announcement</button></div>
		<div class="col-sm-4" style="color: green; font-weight: bold;"><?=@$_GET['msg']?></div>
		<div class="col-sm-4"><span class="title pull-right">Announcement Management</span></div>
	</div>
	  
	  <div class="modal fade" id="AnnouncModal">
	  	<div class="modal-dialog">
	  		<div class="modal-content">
	  			<div class="modal-header">
	  				<h4 class="modal-title">Make an Announcement</h4>
	  			</div>
	  			<div class="modal-body">
	  				<form action="" method="POST">
	  				
	  					<div class="form-group">
	  						<label for="">Title</label>
	  						<input type="text" class="form-control" name="title" placeholder="Title">
	  					</div>
	  					<div class="form-group">
	  						<textarea name="message" class="form-control textarea" rows="3" required="required"></textarea>
	  					</div>
	  					<button type="submit" name="addAnnouncement" class="btn btn-primary pull-right">Make Announcement</button><br><br>
	  				</form>
	  			</div>
	  		</div>
	  	</div>
	  </div>
</div>


	<div class="row" style="margin-top: 5%">
     <div class="col-sm-12">
         <table id="table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            	<th>ID</th>
                <th>Title</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            $result = mysqli_query($con, "SELECT * FROM announcements");

            while ($row = mysqli_fetch_array($result)) {
                 echo "<tr>
                         <td>$i</td>
                         <td>$row[title]</td>
                         <td>$row[message]</td>
                         <td>$row[_date]</td>
                         <td>
                         	<a href='index.php?page=make_announcement&Delete=Yes&ID=$row[ID]' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span></a>
                         	</td>
                 </tr>";
                 $i++;
             } ?>

        </tbody>
    </table>
     </div>   
    </div>


<?php 


if (isset($_POST['addAnnouncement'])) {

	$title = $_POST['title'];
	$message = $_POST['message'];
	$date = date("d F, Y");

	$qry = mysqli_query($con, "INSERT into announcements SET title = '$title', message = '$message', _to = 'All', _date = '$date'");
	if ($qry) {
		echo "<script>
					window.location='index.php?page=make_announcement&msg=Announcement Added';
				</script>";
	} else {
		echo "Error";
	}
	

	

 	
 }

 if (isset($_GET['Delete'])) {
		$ID = $_GET['ID'];

		$result = mysqli_query($con, "DELETE FROM announcements WHERE ID = '$ID'");

		if ($result) {
			echo "<script>
					window.location='index.php?page=make_announcement&msg=Record Delete';
				</script>";
		}
	}



	 ?>