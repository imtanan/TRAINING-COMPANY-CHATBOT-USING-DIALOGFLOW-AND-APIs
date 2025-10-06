<?php include 'header.php'; ?>

<div class="container mt-5" style="min-height: 75vh;">
    <div class="row">

        <div class="offset-sm-3 col-sm-6">
            <?php if (isset($_GET['msg'])) { ?>
            <div class="alert alert-info">
                <strong><?=$_GET['msg']?></strong>
            </div>
            <?php } ?>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5">Student Registration Form</h5>
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
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-2">
                                <label>Address</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" placeholder="Enter Student Address" id="saddress">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Contact No</label>
                                <input type="text" name="cellNo" class="form-control" placeholder="Enter Contact No" id="scell">
                            </div><br>
                            <div class="col-sm-12">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Enter Password" class="form-control" id="spass">
                            </div><br>
                        </div><br>
                        <button type="submit" class="btn btn-sm btn-primary ml-5" name="Register"> Register
                        </button>
                    </form><br><br>
                    <a href="login.php">Login here...</a><br>
                    <a href="teacher.php">Register as Instructor</a>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>

<?php
if (isset($_POST['Register'])) {
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
        move_uploaded_file($tmp_img, "assets/profile_images/$imgName");
    }
    $query = "INSERT INTO students SET name ='$name', fName = '$fname', email = '$email', image = '$imgName', address = '$address', cellNo = '$cellNo', password = '$password'";

    $result = mysqli_query($con, $query);
    if ($result) {
        echo "<script>
                    window.location='register.php?msg=Registered Successfully';
                </script>";
    } else {
        echo "Error" . mysqli_error($con);
    }
}

?>