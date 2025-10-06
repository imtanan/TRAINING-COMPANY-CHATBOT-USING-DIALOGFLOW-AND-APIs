<?php include 'header.php'; ?>

<div class="container mt-5" style="min-height: 75vh;">
    <div class="row">

        <div class="offset-sm-3 col-sm-6">
        <?php if (isset($_GET['msg'])) { ?>
                <div class="alert alert-danger">
                    <strong><?= $_GET['msg'] ?></strong>
                </div>
            <?php } ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5">Login Form</h5>
                    <form action="" method="POST">
                    <div class="form-group">
                        <label><b>Email</b></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                    </div><br>
                    <div class="form-group">
                        <label><b>Password</b></label>
                        <input type="password" name="password" class="form-control" maxlength="10"
                                placeholder="Enter Password" required>
                    </div><br>
                    <div class="form-group">
                        <label><b>User Type</b></label>
                        <select name="uType" class="form-control" required>
                                <option value="" selected disabled>Select User Type</option>
                                <option value="students">Student</option>
                                <option value="teachers">Teacher</option>
                                <option value="admins">Admin</option>
                            </select>
                    </div><br>
                    <button type="submit" class="btn btn-sm btn-primary ml-5" name="Login"> Login
                </button>
                    </form>
                    <a href="register.php">Register here</a>
                </div>
                <?php

            if (isset($_GET['error']))
            {
              echo "<font color='red'><span class='glyphicon glyphicon-remove-sign '></span> ".@$_GET['error'];
            }
            if (isset($_POST['Login'])) {
              $email = $_POST['email'];
              $password = $_POST['password'];
              $uType = $_POST['uType'];


              $result = mysqli_query($con, "SELECT * from $uType where email='$email' and password='$password'");
              $count = mysqli_num_rows($result);
              $user = mysqli_fetch_array($result);


              if($count > 0)
              {
                  $_SESSION['IS_LOGIN'] = "true";
                  $_SESSION['USER_ID'] = $user['ID'];
                  $_SESSION['USER_NAME'] = $user['name'];
                  $_SESSION['USER_TYPE'] = $uType;
                  echo "<script> window.location.href='$uType'; </script>";
              }
              else
              {
              echo "<script> window.location.href='login.php?msg=Email Or Password not correct'; </script>";
             }
           }
           ?>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>

