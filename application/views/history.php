<div class="row">
  <div class="col-12">
    <div class="card">
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0" style="height: 300px;">
        <table class="table table-head-fixed">
          <thead>
            <tr>
              <th>No.</th>
              <th>Order On</th>
              <th>Date</th>
              <th>Invoice</th>
            </tr>
          </thead>
          <tbody>
            
              <?php
                $no = 1;
                foreach ($list as $data) {
                  echo '<tr>';
                  echo '<td>'.$no.'</td>';
                  echo '<td>'.$data->nama_resto.'</td>';
                  echo '<td>'.$data->created_at.'</td>';
                  echo '<td>
                          <button class="btn btn-primary detaila" data-toggle="modal" data-target="#dal" orderid="'.$data->id_order.'"> PRINT </button>
                        </td>';
                  echo '</tr>';
                  $no++;
                }
              ?>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
<div id="dal" class="modal fade" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <a href="<?php echo base_url()?>index.php/main/history">
                <button type="button" class="close" data-dismiss="modal" href>&times;</button>
              </a>
              <h4 class="modal-title">Order List</h4>
            </div>
        <div class="modal-body" id="bdy"></div>
        <div class="modal-footer">
        </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
        $(".detaila").click(function(){
            var orderid = $(this).attr("orderid");
            console.log(orderid);;
            $.ajax({
                url: "<?php echo base_url() ?>index.php/main/detail_bill",
                type: "POST",
                data: "hello="+orderid,
                cache: false,
                success: function(data){
                    $('#bdy').html(data);
                    $('#dal').modal("show");    
                }
            })
        });
    });
</script>