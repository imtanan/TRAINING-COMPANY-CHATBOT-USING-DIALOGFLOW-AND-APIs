$(function () {
  $("#table").DataTable();
  $(".textarea").wysihtml5();


  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false
  });


  $(".Tchr_Update").on('click', function (e) {
    $("#T_ID").val($(this).attr('ID'));
    $("#name").val($(this).attr('name'));
    $("#email").val($(this).attr('email'));
    $("#address").val($(this).attr('address'));
    $("#cellNo").val($(this).attr('cellNo'));
    $("#qual").val($(this).attr('qual'));
    $("#pay").val($(this).attr('pay'));
    $("#tbtn").val("Update Teacher");
    $(".modal-title").html("Update Teacher");
    $("#TchrModal").modal('show');
  });

  $(".Std_Update").on('click', function (e) {
    $("#S_ID").val($(this).attr('ID'));
    $("#sname").val($(this).attr('name'));
    $("#sfname").val($(this).attr('fname'));
    $("#semail").val($(this).attr('email'));
    $("#saddress").val($(this).attr('address'));
    $("#scell").val($(this).attr('cell'));
    $("#spass").val($(this).attr('pass'));
    $("#sbtn").val("Update Student");
    $(".modal-title").html("Update Student");
    $("#StdModal").modal('show');
  });


  $(".enroll").on('click', function (e) {
    $("#e_id").val($(this).attr('ID'));
    $("#Enroll").modal('show');
  });

  $(".PayFee").on('click', function (e) {
    $("#ID").val($(this).attr('ID'));
    $("#fee").val($(this).attr('Fee'));
    $("#C_ID").val($(this).attr('C_ID'));
    $("#FeeModal").modal('show');
  });



  $(".Schedule").on('click', function (e) {
    $("#cid").val($(this).attr('ID'));
    $("#Schedule_Modal").modal('show');
  });



  $(".AddVideo").on('click', function (e) {
    $("#v_cid").val($(this).attr('ID'));
    $("#UploadVideo").modal('show');
  });

  $(".AddMaterial").on('click', function (e) {
    $("#m_cid").val($(this).attr('ID'));
    $("#UploadMaterial").modal('show');
  });


  $(".MarkQuiz").on('click', function (e) {
    $("#sq_id").val($(this).attr('ID'));
    $("#MarkSQModal").modal('show');
  });




});

function openEditModal(course) {
	$('#course_id').val(course.ID);
	$('#title').val(course.title);
	$('#description').val(course.description);
	$('#fee').val(course.fee);
	$('#duration').val(course.duration);
	$('#level').val(course.level);
	$('#mode').val(course.mode);
	$('#certification').val(course.certification);
	$('#modalTitle').text('Edit Course');
	$('#addBtn').hide();
	$('#updateBtn').show();
	$('#courseModal').modal('show');
}

function openAddModal() {
	$('#course_id, #title, #description, #fee, #duration, #level, #mode, #certification').val('');
	$('#modalTitle').text('Add New Course');
	$('#addBtn').show();
	$('#updateBtn').hide();
	$('#courseModal').modal('show');
}


function openBatchAddModal() {
  document.getElementById("modalTitle").innerText = "Add Batch";
  document.getElementById("batch_id").value = "";
  document.getElementById("course_id").value = "";
  document.getElementById("batch_name").value = "";
  document.getElementById("start_date").value = "";
  document.getElementById("end_date").value = "";
  $('#batchModal').modal('show');
}

function openBatchEditModal(data) {
  document.getElementById("modalTitle").innerText = "Edit Batch";
  document.getElementById("batch_id").value = data.id;
  document.getElementById("course_id").value = data.course_id;
  document.getElementById("batch_name").value = data.name;
  document.getElementById("start_date").value = data.start_date;
  document.getElementById("end_date").value = data.end_date;
  $('#batchModal').modal('show');
}


 
    function openAddScheduleModal() {
        $('#schedule_id').val('');
        $('#batch_id').val('');
        $('#day_of_week').val('Monday'); 
        $('#start_time').val('');
        $('#end_time').val('');
        $('#scheduleModalTitle').text('Add New Schedule');
        $('#addScheduleBtn').show();
        $('#updateScheduleBtn').hide();
        $('#scheduleModal').modal('show');
    }

    function openEditScheduleModal(scheduleData) {
        $('#schedule_id').val(scheduleData.id);
        $('#batch_id').val(scheduleData.batch_id);
        $('#day_of_week').val(scheduleData.day_of_week);
        $('#start_time').val(scheduleData.start_time);
        $('#end_time').val(scheduleData.end_time);
        $('#scheduleModalTitle').text('Edit Schedule');
        $('#addScheduleBtn').hide();
        $('#updateScheduleBtn').show();
        $('#scheduleModal').modal('show');
    }
