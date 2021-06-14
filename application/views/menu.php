<div class="card card-primary card-outline">
  <div class="card-body">
    <h4>Menu Resto <?php echo $resto[$this->uri->segment(3)-1]->nama_resto?></h4>
    <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-content-above-foods-tab" data-toggle="pill" href="#custom-content-above-foods" role="tab" aria-controls="custom-content-above-foods" aria-selected="true">Foods</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-content-above-drinks-tab" data-toggle="pill" href="#custom-content-above-drinks" role="tab" aria-controls="custom-content-above-drinks" aria-selected="false">Drinks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-content-above-snacks-tab" data-toggle="pill" href="#custom-content-above-snacks" role="tab" aria-controls="custom-content-above-snacks" aria-selected="false">Snacks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-content-above-order-tab" data-toggle="pill" href="#custom-content-above-order" role="tab" aria-controls="custom-content-above-order" aria-selected="false">Order Lists</a>
      </li>
    </ul>
    <div class="tab-content" id="custom-content-above-tabContent">
      <div class="tab-pane fade show active" id="custom-content-above-foods" role="tabpanel" aria-labelledby="custom-content-above-foods-tab">
          <div class="row">
            <?php
              foreach ($menu as $data) {
                if($data->kategori == 'FOOD'){
                  echo '<div class="col-sm-2">
                          <a href="'.base_url().'uploads/menu/'.$data->foto.'" data-toggle="lightbox" data-title="'.$data->menu.'" data-gallery="gallery" data-max-width="600" data-max-height="600">
                            <img src="'.base_url().'uploads/menu/'.$data->foto.'" class="img-fluid mb-2" style="width:300px; height:200px; object-fit:cover;" alt="'.$data->menu.'"/>
                            <h3><span class="badge badge-primary">'.$data->harga.'</span></h3>
                          </a>
                        </div>';
                }
              }
            ?>
          </div>
      </div>
      <div class="tab-pane fade" id="custom-content-above-drinks" role="tabpanel" aria-labelledby="custom-content-above-drinks-tab">
         <div class="row">
            <?php
              foreach ($menu as $data) {
                if($data->kategori == 'DRINK'){
                  echo '<div class="col-sm-2">
                          <a href="'.base_url().'uploads/menu/'.$data->foto.'" data-toggle="lightbox" data-title="'.$data->menu.'" data-gallery="gallery" data-max-width="600" data-max-height="600">
                            <img src="'.base_url().'uploads/menu/'.$data->foto.'" class="img-fluid mb-2" style="width:300px; height:200px; object-fit:cover;" alt="'.$data->menu.'"/>
                            <h3><span class="badge badge-primary">'.$data->harga.'</span></h3>
                          </a>
                        </div>';
                }
              }
            ?>
          </div>
      </div>
      <div class="tab-pane fade" id="custom-content-above-snacks" role="tabpanel" aria-labelledby="custom-content-above-snacks-tab">
         <div class="row">
            <?php
              foreach ($menu as $data) {
                if($data->kategori == 'SNACK'){
                  echo '<div class="col-sm-2">
                          <a href="'.base_url().'uploads/menu/'.$data->foto.'" data-toggle="lightbox" data-title="'.$data->menu.'" data-gallery="gallery" data-max-width="600" data-max-height="600">
                            <img src="'.base_url().'uploads/menu/'.$data->foto.'" class="img-fluid mb-2" style="width:300px; height:200px; object-fit:cover;" style="width:300px; height:200px; object-fit:cover;" alt="'.$data->menu.'"/>
                            <h3><span class="badge badge-primary">'.$data->harga.'</span></h3>
                          </a>
                        </div>';
                }
              }
            ?>
          </div>
      </div>
      <div class="tab-pane fade" id="custom-content-above-order" role="tabpanel" aria-labelledby="custom-content-above-order-tab">
         <div class="row">
          <?php
          if(!empty($notif)){
              echo '<div class="alert alert-danger">'.$notif.'</div>';
          }
      ?>
          <div class="card-body p-0">
            <form action="<?php echo base_url();?>index.php/main/place_order" method="post" id="formOrder" >
            <input type="number" name="id_cust" value="<?php echo $id->id_user?>" style="display: none;">            
            <input type="number" name="id_resto" value="<?php echo $this->uri->segment(3)?>" style="display: none;">
            <div class="form-group">
              <input class="form-control col-sm-2" type="number" min="0" max="20" name="table" required autofocus placeholder="NO TABLE">
            </div>
            <div class="row orderLists theOrder">
              <div class="form-group col col-xl-8">
                <select class="form-control select2" name="orders[]" id="orders" required>
                  <option selected="" disabled="">Please Select One</option>
                  <?php
                    foreach ($menu as $data) {
                      echo '<option value="'.$data->menu.'">'.$data->menu.'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="form-group col col-md-auto">
                <input type="number" min="1" class="form-control" id="quantity" name="quantity[]" placeholder="Quantity" required>
              </div>
              <div class="form-group col">
                <button type="button" class="btn btn-primary addMenu"><i class="fa fa-plus"></i>Add</button>
              </div>
            </div>
          </form>
          <div class="form-group col">
              <button class="btn btn-success" id="done" data-toggle="modal" data-target="#modal-info">FINISH ORDER</button>
              <!-- <button type="submit" name="submit" value="submit" class="btn btn-outline-light" id="done" form="formOrder">Done Payment</button> -->
            </div>
            <div class="hide orderMenu">
              <div class="row theOrder">
                <div class="form-group col col-xl-8">
                  <select class="form-control" name="orders[]" id="orders" required autofocus>
                    <option selected="" disabled="">Please Select One</option>
                    <?php
                      foreach ($menu as $data) {
                        echo '<option value="'.$data->menu.'">'.$data->menu.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group col col-md-auto">
                  <input type="number" min="1" class="form-control" id="quantity" name="quantity[]" placeholder="Quantity" required>
                </div>
                <div class="form-group col">
                  <button class="btn btn-danger remove"><i class="fa fa-plus"></i>Remove</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card -->
</div>
<!-- /.card -->
<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title">Payment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
            <div class="form-group clearfix justify-content-between">
              <div class="icheck-success d-inline">
                <input type="radio" name="payment_method" value="E-MONEY" id="radioSuccess1">
                <label for="radioSuccess1">
                  E-Money
                </label>
              </div>
              <div class="icheck-success d-inline">
                <input type="radio" name="payment_method" value="BANK" id="radioSuccess2">
                <label for="radioSuccess2">
                  Transfer Bank
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>Virtual Account : </label>
              <input type="number" name="va" disabled="" value="<?php echo $randVA?>">
            </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" value="submit" class="btn btn-outline-light" id="done" form="formOrder">Done Payment</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
$(document).ready(function(){
  $(".addMenu").click(function(){ 
      var html = $(".orderMenu").html();
      $(".orderLists").after(html);
  });
  $("body").on("click",".remove",function(){ 
      $(this).parents(".theOrder").remove();
  });
  $('#the-submit').on('click', function(e) {
      $('#formOrder').submit();
  });
  $('#pay').click(function(){
    $("#done").click();
  });
});
</script>