<div class="row">
    <div class="col-sm-12" style="margin-top: 5%">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center"><b>Course Registrations</b></h3>
            </div>
            <div class="panel-body">
                <table id="table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $result = mysqli_query($con, "SELECT * FROM course_registrations");
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>
                    <td>$i</td>
                    <td>$row[student_name]</td>
                    <td>$row[student_email]</td>
                    <td>$row[course_name]</td>
                    <td>$row[registered_on]</td>
                    <td>
                        <a href='index.php?page=course_registrations&Delete=Yes&ID=$row[id]' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span></a>
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


if (isset($_GET['Delete'])) {
    $ID = $_GET['ID'];
    $result = mysqli_query($con, "DELETE FROM course_registrations WHERE id = '$ID'");
    if ($result) {
        echo "<script>
window.location='index.php?page=course_registrations&msg=Record Deleted';
</script>";
    }
}
