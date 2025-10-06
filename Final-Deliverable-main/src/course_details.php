<?php include 'header.php';

if (!isset($_GET['CourseID'])) {
    echo "<script> window.location.href='index.php#courses'; </script>";
} else {
    $Course = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM courses WHERE ID = '$_GET[CourseID]'"));
}


?>

<!-- Courses Start -->
<div class="container-xxl py-5" id="courses">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3"><?= $Course['title'] ?></h6>
        </div>
        <br>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item bg-light">
                    <div class="position-relative overflow-hidden text-center">
                        <img class="img-thmubnail" style="width: 100%;" src="assets/images/<?= $Course['image'] ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <b>Course Description</b><br><?=$Course['description']?><br>
                <table class="table table-bordered table-hover my-2">
                    <tbody>
                        <tr>
                            <th>Duration</th>
                            <td><?= $Course['duration'] ?></td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td><?= $Course['level'] ?></td>
                        </tr>
                        <tr>
                            <th>Mode</th>
                            <td><?= $Course['mode'] ?></td>
                        </tr>
                        <tr>
                            <th>Fee</th>
                            <td><?php echo "Rs " . number_format($Course['fee']) ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row g-4 my-2">
            <b>Certification</b><br><?= $Course['certification'] ?><br>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
    intent="WELCOME"
    chat-title="TrainingCompanyAgent"
    agent-id="86aa346f-ef4c-4fb3-95fe-b8507e942eea"
    language-code="en"
    chat-width="400px"
    chat-height="600px">
</df-messenger>