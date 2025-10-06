<div class="row" style="margin-top: -12px !important">
    <div style="background: #201D1D; padding-right: 15px; height: 45px; line-height: 45px;">
        <div class="col-sm-4">
            <button type="button" class="btn btn-sm hvr-bounce-to-right" data-toggle="modal" data-target="#StdModal">Add New Student</button>
        </div>
        <div class="col-sm-4">
            <?php
            if (isset($_GET['msg'])) { ?>
                <div class="alert alert-danger" style="padding: 0; text-align: center;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><?= $_GET['msg'] ?></strong>
                </div>
            <?php } ?>
        </div>
        <div class="col-sm-4"><span class="title pull-right">Student's Management</span></div>
    </div>
    <div class="modal fade" id="StdModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Student</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Student Name</label>
                                <input type="hidden" name="ID" value="0" id="S_ID">
                                <input type="text" name="name" class="form-control" placeholder="Enter Student Name" id="sname">
                            </div>
                            <div class="col-sm-4">
                                <label>Father Name</label>
                                <input type="text" name="fname" class="form-control" placeholder="Enter Father Name" id="sfname">
                            </div>
                            <div class="col-sm-4">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" id="semail">
                            </div>
                        </div><br>
                        <div class="form-group">
                            <label>Profile Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="col-sm-2">
                                <label>Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" placeholder="Enter Student Address" id="saddress">
                            </div>
                        </div><br><br><br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Contact No</label>
                                <input type="text" name="cellNo" class="form-control" placeholder="Enter Contact No" id="scell">
                            </div>
                            <div class="col-sm-12">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" id="spass">
                            </div><br>
                        </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <input type="submit" name="addStudent" value="Add Student" class="btn btn-success" id="sbtn">
                    </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Enroll">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Enroll to Course</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <input type="hidden" name="s_id" id="e_id">
                        <div class="form-group">
                            <label>Select Course</label>
                            <select name="c_id" class="form-control" required="required">
                                <option value="" disabled selected>Select Course</option>
                                <?php
                                $qry = mysqli_query($con, "SELECT * FROM courses");
                                while ($crs = mysqli_fetch_array($qry)) {
                                    echo "<option value='$crs[ID]'>$crs[title] ($crs[section])</option>";
                                } ?>
                            </select>
                        </div>
                        <button name="Enroll" type="submit" class="btn btn-primary btn-sm pull-right">Enroll</button>
                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12" style="margin-top: 5%">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($con, "SELECT * FROM students");
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                    <td>$row[name]</td>
                    <td>$row[fName]</td>
                    <td>$row[email]</td>
                    <td>$row[address]</td>
                    <td>$row[cellNo]</td>
                    <td>
                        <a href='#' ID='$row[ID]' name='$row[name]' fname='$row[fName]' email='$row[email]' address='$row[address]' cell='$row[cellNo]' class='btn btn-info btn-xs Std_Update'><span class='glyphicon glyphicon-edit'></span></a>
                        <a href='#' ID='$row[ID]' class='btn btn-success btn-xs enroll'><span class='glyphicon glyphicon-plus'></span></a>
                        <a href='index.php?page=student_report&ID=$row[ID]' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-list'></span></a>
                        <a href='index.php?page=manage_students&Delete=Yes&ID=$row[ID]' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span></a>
                    </td>
                </tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>
<?php
if (isset($_POST['addStudent'])) {
    $ID = $_POST['ID'];
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cellNo = $_POST['cellNo'];
    $password = $_POST['password'];
    $time = time();
    $image = $_FILES['image']['name'];
    $tmp_img = $_FILES['image']['tmp_name'];

    if ($image != "") {
        $parts = explode(".", $image);
        $imgName = $time . "." . $parts[1];
        move_uploaded_file($tmp_img, "../assets/profile_images/$imgName");
    }
    if ($ID > 0) {
        if ($image != "") {
            $query = "UPDATE students SET name ='$name', fName = '$fname', email = '$email',  image = '$imgName', address = '$address', cellNo = '$cellNo', password = '$password' WHERE ID = '$ID'";
            $msg = "Record Updated";
        } else {
            $query = "UPDATE students SET name ='$name', fName = '$fname', email = '$email', address = '$address', cellNo = '$cellNo',  password = '$password' WHERE ID = '$ID'";
            $msg = "Record Updated";
        }
    } else {
        $query = "INSERT INTO students SET name ='$name', fName = '$fname', email = '$email', image = '$imgName', address = '$address', cellNo = '$cellNo',  password = '$password'";
        $msg = "Record Inserted";
    }


    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>
window.location='index.php?page=manage_students&msg=$msg';
</script>";
    } else {
        echo "Error" . mysqli_error($con);
    }
}
if (isset($_POST['Enroll'])) {
    $S_ID = $_POST['s_id'];
    $C_ID = $_POST['c_id'];
    if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM course_enroll WHERE S_ID = '$S_ID' AND C_ID = '$C_ID'")) > 0) {
        echo "<script>
window.location='index.php?page=manage_students&msg=Already Enrolled';
</script>";
    } else {


        $qry = mysqli_query($con, "INSERT INTO course_enroll SET S_ID = '$S_ID', C_ID = '$C_ID'");
        if ($qry) {
            echo "<script>
window.location='index.php?page=manage_students&msg=Student Enrolled';
</script>";
        } else {
            echo "Error" . mysqli_error($con);
        }
    }
}
if (isset($_GET['Delete'])) {
    $ID = $_GET['ID'];
    $result = mysqli_query($con, "DELETE FROM students WHERE ID = '$ID'");
    if ($result) {
        echo "<script>
window.location='index.php?page=manage_students&msg=Record Deleted';
</script>";
    }
}
?>