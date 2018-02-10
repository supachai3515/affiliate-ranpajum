<div class="content-wrapper">
  <section class="content">

    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h4>เลือกใบรับคืน</h4>
        </div>
        <div class="modal-body">
        <form class="form-inline" role="form" ng-submit="searchOrder(search_order)">
            <div class="form-group">
                <label class="sr-only" for="">รหัสสินค้า , เลขที่ใบรับคืน</label>
                <input type="text" class="form-control"  ng-model="search_order" ng-init="search_order =''" placeholder="รหัสสินค้า , เลขที่สั่งซื้อ" >
            </div>
            <button type="submit" class="btn btn-primary" >ค้นหา</button>
        </form>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Serial Number</th>
                            <th>วันที่</th>
                            <th>Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="value in order_data">
                            <td>
                                ใบรับคืน : <span ng-bind="value.return_id"></span>/<span ng-bind="value.return_docno"></span><br>
                                ใบสั่งซื้อ : <span ng-bind="value.order_id"></span>/<span ng-bind="value.invoice_no"></span><br>

                            </td>
                            <td>
                                <span ng-bind="value.serial_number"></span><br>
                            </td>
                            <td><span ng-bind="value.create_date"></span></td>
                            <td>
                                SKU : <span ng-bind="value.sku"></span><br>
                                NAME : <span ng-bind="value.product_name"></span>
                            </td>
                            <td ng-if="value.is_credit_note == 0 &&  value.is_delivery_return == 0"><button type="button" class="btn btn-info btn-xs"  ng-click="selectOrder(value.order_id,value.return_id,value.serial_number,value.product_id)">เลือก</button></td>
                              <td ng-if="value.is_credit_note == 1"><span class="label label-default">ทำใบลดหนี้แล้ว</span></td>
                              <td ng-if="value.is_delivery_return == 1"><span class="label label-default">ทำใบส่งคืนแล้ว</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>



    <div class="container-fluid box" ng-controller="delivery_return">
        <div class="page-header">
            <h1>ใบส่งคืน</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>";?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาใบส่งคืน</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มใบส่งคืน</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form action="<?php echo base_url('delivery_return/search');?>" method="POST" class="form-inline" role="form">

                        <div class="form-group">
                            <label class="sr-only" for="">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="serial number">
                        </div>

                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>สถานะ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($delivery_return_list as $delivery_return): ?>
                                <tr>
                                    <td>
                                        <span>รหัส : <strong><?php echo $delivery_return['docno'] ?></strong></span><br/>
                                        <span>serial number : <strong><?php echo $delivery_return['serial_number'] ?></strong></span><br/>
                                        <span>order : <strong><?php echo $delivery_return['order_id'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                        <span>name : <strong><?php echo $delivery_return['order_name'] ?></strong></span><br/>
                                        <span>ที่อยู่จัดส่ง : <strong><?php echo $delivery_return['address'] ?></strong></span><br/>
                                    </td>
                                    <td>
                                        <span>sku : <strong><?php echo $delivery_return['sku'] ?></strong></span><br/>
                                        <span>name : <strong><?php echo $delivery_return['product_name'] ?></strong></span><br/>
                                    </td>
                                    <td>
                                         <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($delivery_return['modified_date']));?></span>
                                        <br/>
                                        <?php if ($delivery_return['is_active']=="1"): ?>
                                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                      <a class="btn btn-sm btn-warning" href="<?php echo base_url('delivery_return/edit/'.$delivery_return['id']) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (isset($links_pagination)) { echo $links_pagination; } ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>
                    <form class="form-horizontal" method="POST" name="return_form" action="<?php echo base_url('delivery_return/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="return_id">เลขที่ใบรับคืน</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="return_id" name="return_id" type="text" placeholder="เลขที่ใบรับคืน" class="form-control input-md"
                                            ng-model="return_id"  ng-init="return_id = items.return_id"
                                            required="" readonly="true">

                                        <span class="input-group-addon"> <button type="button" ng-click="open()">เลือกใบรับคืน</i></button></span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                             <label class="col-md-3 control-label" for="order_id">เลขที่ใบสั่งซื้อ</label>
                              <div class="col-md-6">
                                     <input id="order_id" name="order_id" type="text" placeholder="เลขที่ใบสั่งซื้อ" class="form-control input-md"
                                        ng-model="order_id"  ng-init="order_id = items.order_id" required="" readonly="true">
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="product_id">รหัสสินค้า</label>
                              <div class="col-md-6">
                                    <input id="product_id" name="product_id" type="text" placeholder="รหัสสินค้า" class="form-control input-md"
                                     ng-model="product_id"  ng-init="product_id = items.product_id"
                                     required="" readonly="true">
                                </div>
                            </div>

                            <div class="form-group">
                              <label class="col-md-3 control-label" for="serial">serial number</label>
                              <div class="col-md-6">
                                    <input id="serial" name="serial" type="text" placeholder="serial number" class="form-control input-md"
                                     ng-model="serial"  ng-init="serial = items.serial"
                                     required="" readonly="true">
                                </div>
                            </div>


                            <!-- Text input-->
                            <div class="form-group">
                              <label class="col-md-3 control-label" for="tracking">tracking</label>
                              <div class="col-md-6">
                              <input id="tracking" name="tracking" type="text" placeholder="tracking" class="form-control input-md" required="">

                              </div>
                            </div>


                            <div class="form-group">
                              <label class="col-md-3 control-label" for="comment">หมายเหตุ</label>
                              <div class="col-md-6">
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>
                            </div>

                            <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="isactive-0">
                                            <input type="checkbox" name="isactive" id="isactive-0" value="1" checked> ใช้งาน
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="save"></label>
                                <div class="col-md-4" ng-show="!return_form.return_id.$invalid && !return_form.order_id.$invalid" >
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
