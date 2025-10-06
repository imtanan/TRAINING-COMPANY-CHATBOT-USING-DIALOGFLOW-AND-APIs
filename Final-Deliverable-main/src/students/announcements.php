<div class="container">
      

    <div class="row" style="background-color: #ececec">
      
      <div class="col-sm-offset-3 col-sm-6">
        <table id="table" class="table table-hover table-bordered table-striped">
          <thead style="display: none;">
            <tr>
              <th>Title</th>
            </tr>
          </thead>
          <tbody><br><br>
            <?php 
                  $to = "S".$_SESSION['USER_ID'];
                  $S_ID = $_SESSION['USER_ID'];

                  $CID = "";
                  $query = mysqli_query($con, "SELECT * FROM course_enroll WHERE S_ID = '$S_ID'");
                  while ($ce = mysqli_fetch_array($query)) {
                    $C_ID = "C".$ce['C_ID'];
                    $CID .= " OR _to = '" . $C_ID . "'";
                } 

                $qry = mysqli_query($con, "SELECT * FROM announcements WHERE _to = 'All' OR _to = '$to' $CID  ORDER BY _date ASC");
                  while ($anc = mysqli_fetch_array($qry)) {
                     echo "<tr>";

                     if ($anc['_to'] != "All" AND $anc['seen'] == "0") { ?>
                       <td><a href="#" target="_black" onclick='OpenWindow("read_notif.php?id=<?=$anc['ID']?>")' style="font-size: 13pt; font-weight: bold;"><?=$anc['title']?> <img src="../assets/icons/icon_new.gif" alt=""></a><br>
                              <span class='pull-right'><?=$anc['_date']?></span></td>

                      <?php 
                    }
                     else{ ?>
                      <td><a href="#" target="_black" onclick='OpenWindow("read_notif.php?id=<?=$anc['ID']?>")' style="font-size: 13pt; font-weight: bold;"><?=$anc['title']?></a><br>
                              <span class='pull-right'><?=$anc['_date']?></span></td>

                    <?php }
                      echo" </tr>";
                   
                   }
                ?>
            
          </tbody>
        </table>
       </div>
     </div>
   </div>