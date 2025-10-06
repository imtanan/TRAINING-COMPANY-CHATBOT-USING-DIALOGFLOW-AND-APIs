<div class="row">
  <br><br>
  <div class="col-sm-offset-1 col-sm-10">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title pull-left"><b>Batches List</b></h3>
        <button class="btn btn-warning btn-sm pull-right" onclick="openBatchAddModal()">Add New Batch</button>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Course</th>
              <th>Batch Name</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $result = mysqli_query($con, "SELECT batches.*, courses.title AS course_title FROM batches 
                                          JOIN courses ON batches.course_id = courses.ID");
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['course_title']}</td>
                <td>{$row['name']}</td>
                <td>{$row['start_date']}</td>
                <td>{$row['end_date']}</td>
                <td>
                  <button class='btn btn-info btn-sm' onclick='openBatchEditModal(" . json_encode($row) . ")'>Edit</button>
                  <a href='?page=manage_batches&delete_batch={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this batch?\")'>Delete</a>
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

<!-- Batch Modal -->
<div class="modal fade" id="batchModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalTitle">Add/Edit Batch</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="batch_id" id="batch_id">
          <div class="form-group">
            <label>Course</label>
            <select name="course_id" id="course_id" class="form-control" required>
              <option value="">-- Select Course --</option>
              <?php
              $courses = mysqli_query($con, "SELECT * FROM courses");
              while ($c = mysqli_fetch_assoc($courses)) {
                echo "<option value='{$c['ID']}'>{$c['title']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Batch Name</label>
            <input type="text" name="batch_name" id="batch_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
          </div>
          <div class="form-group">
            <label>End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_batch" class="btn btn-success">Add</button>
          <button type="submit" name="update_batch" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php

// Add batch
if (isset($_POST['add_batch'])) {
  $course_id = $_POST['course_id'];
  $name = $_POST['batch_name'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];

  mysqli_query($con, "INSERT INTO batches (course_id, name, start_date, end_date) 
                      VALUES ('$course_id', '$name', '$start_date', '$end_date')");
  echo "<script>window.location='index.php?page=manage_batches';</script>";
}

// Update batch
if (isset($_POST['update_batch'])) {
  $batch_id = $_POST['batch_id'];
  $course_id = $_POST['course_id'];
  $name = $_POST['batch_name'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];

  mysqli_query($con, "UPDATE batches SET course_id='$course_id', name='$name', start_date='$start_date', end_date='$end_date' WHERE id='$batch_id'");
  echo "<script>window.location='index.php?page=manage_batches';</script>";
}

// Delete batch
if (isset($_GET['delete_batch'])) {
  $id = $_GET['delete_batch'];
  mysqli_query($con, "DELETE FROM batches WHERE id='$id'");
  echo "<script>window.location='index.php?page=manage_batches';</script>";
}


?>