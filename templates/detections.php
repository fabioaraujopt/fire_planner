<?php

echo "last_detections";
echo "coordinates, time, pic in dropdown";
echo "confirm /masks_inspection / not confirm"

?>

<style>
    .fire_confirm{
        cursor:pointer;
    }
</style>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detections</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                               role="grid" aria-describedby="dataTable_info" style="width: 100%; margin-top: 10px">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 57px;">ID
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 57px;">Lat
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="Name: activate to sort column descending"
                                    style="width: 57px;">Lng
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-label="Position: activate to sort column ascending" style="width: 62px;">
                                    Time
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-label="Office: activate to sort column ascending" style="width: 50px;">Confidence
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                    aria-label="Office: activate to sort column ascending" style="width: 50px;">State
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1"
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                          
                            foreach ($conn->query("select * from detection_images INNER JOIN detection_status where detection_images.status=detection_status.status_id") as $row){
                                ?>
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><?php echo $row['detection_id']; ?></td>
                                    <td class="sorting_1"><?php echo $row['center_lat']; ?></td>
                                    <td class="sorting_1"><?php echo $row['center_lng']; ?></td>
                                    <td><?php echo $row['image_time']; ?></td>
                                    <td><?php echo $row['detection_confidence']; ?></td>
                                    <td><?php echo $row['status_name']; ?></td>
                                    <td align="center">
                                        <div href="#" class="btn btn-info btn-circle btn-sm" onclick="detectionImage('/detection_images/<?php echo $row['image_path']; ?>');" style="cursor:pointer;">
                                            <i class="far fa-image"></i>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="detectionImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detection Image</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="display: flex; justify-content: center;">
               <img src="" id="detectedImage" alt="ImageUnavailable" style="max-width:100%">
            </div>
            <div class="modal-footer">
                <form id="fireStatusForm" action="?" method="post">
                    <div  id="2" class="btn btn-success fire_confirm">Confirm Fire</div>
                   
                    <div  id="3" class="btn btn-warning fire_confirm">Review Mask</div>
                   
                    <div  id="4" class="btn btn-danger fire_confirm">False Positive</div>
                    
                    <input type="hidden" id="confirmFirePathInput" value="" name="img_fire_path">
                    <input type="hidden" id="confirmFireInput" value="" name="confirm_fire">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  function detectionImage(path) {
      $("#detectionImageModal").modal('show');
      $("#detectedImage").attr("src", path);
      $("#confirmFirePathInput").val(path);
  }
  
  $(".fire_confirm").on('click',function(){
      $("#confirmFireInput").val(this.id);
      $("#fireStatusForm").submit();
  });
</script>


