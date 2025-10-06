<?php global $std; ?>
<div class="row">
	<div class="col-sm-offset-2 col-sm-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title text-center">
					<b>Profile</b>
				</h3>
			</div>
			<div class="panel-body">
				<p align="center">				
					<img src="../assets/profile_images/<?=$std['image']?>" style="height: 100px;" class="img-circle" alt="User Image">
				</p>
				<table class="table table-striped table-bordered">
					<tr>
						<th>Name</th>
						<td><?=$std['name']?></td>
					</tr>
					<tr>
						<th>Father Name</th>
						<td><?=$std['fName']?></td>
					</tr>
					<tr>
						<th>Address</th>
						<td><?=$std['address']?></td>
					</tr>
					<tr>
						<th>Cell No</th>
						<td><?=$std['cellNo']?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>