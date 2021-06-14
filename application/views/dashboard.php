
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Resto</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
        if(!empty($success)){
            echo '<div class="alert alert-success">'.$success.'</div>';
        }
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <?php 
            foreach ($resto as $data) {
              echo '<div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>'.$data->nama_resto.'</h4>

                <p>'.$data->lokasi.'</p>
              </div>
              <div class="icon">
                <i class="ion ion-spoon"></i>
                <i class="ion ion-fork" style="padding-right:20px"></i>
              </div>
              <a href="'.base_url().'index.php/main/menu/'.$data->id_resto.'" class="small-box-footer">Order <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>';
            }
          ?>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->