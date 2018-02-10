<div class="content-wrapper">
  <section class="content">
  <script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header">
      <h4>เลือกใบสั่งซื้อ</h4>
    </div>
    <div class="modal-body">
      <form class="form-inline" role="form" ng-submit="searchOrder(search_order)">
        <div class="form-group">
          <label class="sr-only" for="">รหัสสินค้า , เลขที่ใบสั่งซื้อ</label>
          <input type="text" class="form-control" ng-model="search_order" ng-init="search_order =''" placeholder="รหัสสินค้า , เลขที่สั่งซื้อ">
        </div>
        <button type="submit" class="btn btn-primary">ค้นหา</button>
      </form>
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Order</th>
              <th>Products</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="value in order_data">
              <td>
                <strong>Order: </strong><span ng-bind="value.order_id"></span>/ <span ng-bind="value.invoice_no"></span>
                <strong>Serial: </strong><span ng-bind="value.serial_number"></span>
                <br>
                <strong>รับคืนแล้ว: </strong><span>{{value.Count_qty}}/{{value.quantity}}</span>
                <br>
                <strong>วันที่ขาย: </strong><span ng-bind="value.order_date"></span>
                <br>

              </td>
              <td>
                <strong>SKU: </strong><span ng-bind="value.sku"></span>
                <br>
                <strong>NAME: </strong><span ng-bind="value.product_name"></span>
                <br>
                <strong>ชื่อลูกค้า: </strong><span ng-bind="value.order_name"></span>
                <br>
              </td>
              <td ng-if="value.Count_qty < value.quantity">
                <button type="button" class="btn btn-info btn-xs" ng-click="selectOrder(value.order_id,value.product_id,value.serial_number)">เลือก</button>
              </td>
              <td ng-if="value.Count_qty == value.quantity"><span class="label label-default">รับคืนแล้ว</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
    </div>
  </script>

  <div class="container-fluid box" ng-controller="return_receive">
    <div class="page-header">
      <h1>ใบรับคืน</h1>
      <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
    </div>
    <div role="tabpanel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
          <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาใบรับคืน</a>
        </li>
        <li role="presentation">
          <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มใบรับคืน</a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="search">
          <div style="padding-top:30px;"></div>
          <form action="<?php echo base_url('return_receive/search');?>" method="POST" class="form-inline" role="form">

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
                  <th>ชื่อ</th>
                  <th>สถานะ</th>
                  <th>แก้ไข</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($return_receive_list as $return_receive): ?>
                  <tr>
                    <td>
                      <span>รหัส : <strong><?php echo $return_receive['docno'] ?></strong></span>
                      <br/>
                      <span>serial number : <strong><?php echo $return_receive['serial_number'] ?></strong></span>
                      <br/>
                      <span>order : <strong><?php echo $return_receive['order_id'] ?></strong></span>
                      <br/>

                    </td>
                    <td>
                      <span>name : <strong><?php echo $return_receive['order_name'] ?></strong></span>
                      <br/>
                      <span>ที่อยู่จัดส่ง : <strong><?php echo $return_receive['address'] ?></strong></span>
                      <br/>
                    </td>
                    <td>
                      <span>sku : <strong><?php echo $return_receive['sku'] ?></strong></span>
                      <br/>
                      <span>name : <strong><?php echo $return_receive['product_name'] ?></strong></span>
                      <br/>
                    </td>

                    <td>
                      <?php if (isset($return_receive['credit_note_docno'])): ?>
                        <span class="label label-info">ใบลดหนี้ : <strong><?php echo $return_receive['credit_note_docno'] ?></strong></span>
                        <br/>
                        <?php endif ?>
                          <?php if (isset($return_receive['delivery_return_docno'])): ?>
                            <span class="label label-warning">ส่งคืน : <strong><?php echo $return_receive['delivery_return_docno'] ?></strong></span>
                            <br/>
                            <?php endif ?>
                              <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($return_receive['modified_date']));?></span>
                              <br/>
                              <?php if ($return_receive['is_active']=="1"): ?>
                                <span><i class="fa fa-check"></i> ใช้งาน</span>
                                <br/>
                                <?php else: ?>
                                  <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                  <br/>
                                  <?php endif ?>
                    </td>
                    <td><a class="btn btn-xs btn-info" href="<?php echo base_url('return_receive/edit/'.$return_receive['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a></td>
                  </tr>
                  <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="add">
          <div style="padding-top:30px;"></div>
          <form class="form-horizontal" method="POST" name="return_form" action="<?php echo base_url('return_receive/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
            <fieldset>
              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label" for="order_id">เลขที่ใบสั่งซื้อ</label>
                <div class="col-md-6">
                  <div class="input-group">
                    <input id="order_id" name="order_id" type="text" placeholder="เลขที่ใบสั่งซื้อ" class="form-control input-md" ng-model="order_id" ng-init="order_id = items.order_id" required="" readonly="true">
                    <span class="input-group-addon"> <button type="button" ng-click="open()">เลือกใบสั่งซื้อ</i></button></span>
                  </div>
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-3 control-label" for="product_id">รหัสสินค้า</label>
                <div class="col-md-6">
                  <input id="product_id" name="product_id" type="text" placeholder="หรัสสินค้า" class="form-control input-md" ng-model="product_id" ng-init="product_id = items.product_id" required="" readonly="true">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="serial">serial number</label>
                <div class="col-md-6">
                  <input id="serial" name="serial" type="text" placeholder="serial number" class="form-control input-md" ng-model="serial" ng-init="serial = items.serial" required="" readonly="true">
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
                <label class="col-md-3 control-label" for="is_cut_stock">เพิ่มสต็อก</label>
                <div class="col-md-4">
                  <div class="checkbox">
                    <label for="is_cut_stock-0">
                      <input type="checkbox" name="is_cut_stock" id="is_cut_stock-0" value="1"> เพิ่มสต็อกสินค้า
                    </label>
                  </div>
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
                <div class="col-md-4" ng-show="!return_form.product_id.$invalid && !return_form.order_id.$invalid">
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
