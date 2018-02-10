<div class="content-wrapper">
  <section class="content">
    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h4>ประวัติ Serial Number : <span ng-bind="product_serial[0].serial_number"></span></h4>
        </div>
        <div class="modal-body">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>หมายเหตุ</th>
                            <th>วันที่ทำรายการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="value in product_serial">
                            <td><span ng-bind="value.serial_number"></span></td>
                            <td><span ng-bind="value.comment"></span></td>
                            <td><span ng-bind="value.create_date"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>

    <div class="container-fluid box" ng-controller="product_serial">
        <div class="page-header">
            <h1>Serial Number</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหา Serial Number</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form action="<?php echo base_url('product_serial/search');?>" method="POST" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Serial Number">
                        </div>

                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Serial Number</th>
                                    <th>ชื่อ</th>
                                    <th>สถานะ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($product_serial_list as $product_serial): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $product_serial['serial_number'] ?></strong>
                                    </td>
                                    <td>
                                        <span>รหัสสินค้า : <strong><?php echo $product_serial['sku'] ?></strong></span><br/>
                                        <span>ชื่อสินค้า : <strong><?php echo $product_serial['product_name'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                         <span>สถานะ : <strong><?php echo $product_serial['status_name'].' วันที่ : '.date("d-m-Y H:i",strtotime($product_serial['create_date_status'])); ?></strong></span><br/>
                                         <?php if (isset($product_serial['order_id'] )): ?>
                                              <span>วันที่ขาย : </span> <strong><?php echo date("d-m-Y H:i", strtotime($product_serial['modified_date_order']));?></strong><br/>

                                         <?php endif ?>

                                    </td>
                                    <td>
                                         <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($product_serial['modified_date']));?></span>
                                        <br/>
                                        <?php if ($product_serial['is_active']=="1"): ?>
                                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                      <button type="button" class="btn btn-info" ng-click="open(<?php echo $product_serial['product_id'] ?>,'<?php echo $product_serial['serial_number'] ?>')">ประวิติ Serial Number</button>
                                  </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
