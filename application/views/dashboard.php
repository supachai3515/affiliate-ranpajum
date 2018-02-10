<div id="page-wrapper" ng-app="myApp">
    <div class="container-fluid" ng-controller="myCtrl">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Dashboard
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $get_orders_today['count'] ?></div>
                                <div>ใบสั่งซื้อวันนี้</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-money fa-fw fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><span ng-bind="<?php echo $get_orders_today['total'];?> | currency:'฿':0"></span></div>
                                <div>ยอดซื้อวันนี้</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
            </div>
            
            <div class="col-lg-3 col-md-6">
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
        <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> สินค้าปกติ</h3>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                        <?php foreach ($get_order_status as $value): ?>
                            <?php if ($value['is_reservations']==0): ?>
                                <a href="<?php echo base_url('orders') ?>" class="list-group-item">
                                    <span class="badge"><?php echo $value['count'] ?></span>
                                    <?php echo $value['name'] ?>
                                </a> 
                            <?php endif ?>
                        <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> ใบสั่งซื้อล่าสุด</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
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
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
