<div class="row">
    <br><br>
    <div class="col-sm-offset-1 col-sm-10">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title pull-left"><b>Schedules List</b></h3>
                <button class="btn btn-warning btn-sm pull-right" onclick="openAddScheduleModal()">Add New Schedule</button>
            </div>
            <div class="panel-body">
                <table id="schedulesTable" class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Batch</th>
                            <th>Day of Week</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $schedulesResult = mysqli_query($con, "
                            SELECT
                                s.id,
                                b.name,
                                s.day_of_week,
                                s.start_time,
                                s.end_time
                            FROM schedules s
                            JOIN batches b ON s.batch_id = b.id
                        ");
                        while ($scheduleRow = mysqli_fetch_assoc($schedulesResult)) {
                            echo "<tr>
                                    <td>{$scheduleRow['id']}</td>
                                    <td>{$scheduleRow['name']}</td>
                                    <td>{$scheduleRow['day_of_week']}</td>
                                    <td>{$scheduleRow['start_time']}</td>
                                    <td>{$scheduleRow['end_time']}</td>
                                    <td>
                                        <button class='btn btn-info btn-sm' onclick='openEditScheduleModal(" . json_encode($scheduleRow) . ")'>Edit</button>
                                        <a href='?page=manage_schedules&delete={$scheduleRow['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this schedule?\")'>Delete</a>
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

<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="scheduleModalTitle">Add/Edit Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="schedule_id" id="schedule_id">
                    <div class="form-group">
                        <label>Batch</label>
                        <select name="batch_id" id="batch_id" class="form-control" required>
                            <option value="">Select Batch</option>
                            <?php
                            $batchesResult = mysqli_query($con, "SELECT id, name FROM batches");
                            while ($batch = mysqli_fetch_assoc($batchesResult)) {
                                echo "<option value='{$batch['id']}'>{$batch['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Day of Week</label>
                        <select name="day_of_week" id="day_of_week" class="form-control">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_schedule" id="addScheduleBtn" class="btn btn-success">Add</button>
                    <button type="submit" name="update_schedule" id="updateScheduleBtn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php

if (isset($_POST['add_schedule'])) {
    $batch_id = $_POST['batch_id'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    // INSTRUCTOR ID REMOVED FROM INSERT QUERY
    mysqli_query($con, "INSERT INTO schedules (batch_id, day_of_week, start_time, end_time)
                        VALUES ('$batch_id', '$day_of_week', '$start_time', '$end_time')");
    echo "<script>window.location='index.php?page=manage_schedules';</script>";
}

if (isset($_POST['update_schedule'])) {
    $id = $_POST['schedule_id'];
    $batch_id = $_POST['batch_id'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    // INSTRUCTOR ID REMOVED FROM UPDATE QUERY
    mysqli_query($con, "UPDATE schedules SET batch_id='$batch_id', day_of_week='$day_of_week', start_time='$start_time', end_time='$end_time' WHERE id='$id'");
    echo "<script>window.location='index.php?page=manage_schedules';</script>";
}

// Handle Delete Schedule
if (isset($_GET['delete']) && isset($_GET['page']) && $_GET['page'] === 'manage_schedules') {
    $id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM schedules WHERE id='$id'");
    echo "<script>window.location='index.php?page=manage_schedules';</script>";
}

?>