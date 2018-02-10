<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>รายงานภาพรวม</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <section class="content">
      <!-- row -->
      <div class="row">
          <div class="col-lg-6 col-md-12">
              <div class="panel panel-yellow">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-12 text-right">
                              <div class="huge"><?php echo $get_orders_today['count'] ?></div>
                              <div>ใบสั่งซื้อวันนี้</div>
                          </div>
                      </div>
                  </div>

              </div>
          </div>
          <div class="col-lg-6 col-md-12">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-xs-12 text-right">
                              <div class="huge"><span ng-bind="<?php if ($get_orders_today['total'] > 0) {
                                  echo $get_orders_today['total'];
                              }else { echo 0; } ?>"></span></div>
                              <div>ยอดซื้อวันนี้</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- /.row -->
      <!-- row -->
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> สถานะใบสั่งซื้อ</h3>
                  </div>
                  <div class="panel-body">
                      <div class="list-group">
                      <?php foreach ($get_order_status as $value): ?>
                              <a href="<?php echo base_url('orders') ?>" class="list-group-item">
                                  <span class="badge"><?php echo $value['count'] ?></span>
                                  <?php echo $value['name'] ?>
                              </a>
                      <?php endforeach ?>
                      </div>
                  </div>
              </div>
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> ใบสั่งซื้อล่าสุด</h3>
                  </div>
                  <div class="panel-body">
                      <div class="box-body table-responsive no-padding">
                          <table class="table table-bordered table-hover table-striped">
                              <thead>
                                  <tr>
                                      <th>Order #</th>
                                      <th>Order Date</th>
                                      <th>Amount</th>
                                  </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($get_orders as $value): ?>
                                  <tr>
                                      <td><?php echo $value['id'] ?>
                                      <td><?php echo date("d-m-Y H:i", strtotime($value['date']));?></td>
                                      <td><strong ng-bind="<?php echo $value['total'];?> | currency:'฿':0"></strong></td>
                                      <td><a class="btn btn-xs btn-info" href="<?php echo base_url('orders/edit/'.$value['id']) ?>" role="button"><i class="fa fa-eye"></i></a></td>
                                  </tr>
                              <?php endforeach ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- /.row -->
    </section>
</div>
