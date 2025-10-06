<div style="margin-top: 50px">
  <div class="row">
    <div class="col-sm-4">
      <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">My Courses</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body chart-responsive">
        <div class="small-box bg-aqua" style="height: 180px;">
            <div class="inner"><br><br>
              <h3 class="text-center"><?php  CoursesCount($_SESSION['USER_ID']);  ?></h3>
              <p class="text-center">Total Courses</p>
            </div>
            <<!-- div class="icon">Rs</div> -->
          </div>
      </div>
    </div>
  </div>