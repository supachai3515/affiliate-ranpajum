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
          <input type="text" class="form-control" ng-model="search_order" ng-init="search_order =''" placeholder="รหัสสินค้า , เลขที่สั่งซื้อ">
        </div>
        <button type="submit" class="btn btn-primary">ค้นหา</button>
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
                <strong>ใบรับคืน : </strong><span ng-bind="value.return_id"></span>/<span ng-bind="value.return_docno"></span>
                <br>
                <strong>ใบสั่งซื้อ : </strong><span ng-bind="value.order_id"></span>/<span ng-bind="value.invoice_no"></span>
                <br>
                <strong>Name : </strong><span ng-bind="value.order_name"></span>

              </td>
              <td>
                <span ng-bind="value.serial_number"></span>
                <br>
              </td>
              <td><span ng-bind="value.create_date"></span></td>
              <td>
                SKU : <span ng-bind="value.sku"></span>
                <br> NAME : <span ng-bind="value.product_name"></span>
              </td>
              <td ng-if="value.is_credit_note == 0 &&  value.is_delivery_return == 0">
                <button type="button" class="btn btn-info btn-xs" ng-click="selectOrder(value)">เลือก</button>
              </td>
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

  <div class="container-fluid box" ng-controller="credit_note">
    <div class="page-header">
      <h1>ใบลดหนี้</h1>
      <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
    </div>
    <div role="tabpanel">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
          <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาใบลดหนี้</a>
        </li>
        <li role="presentation">
          <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มใบลดหนี้</a>
        </li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="search">
          <div style="padding-top:30px;"></div>
          <form action="<?php echo base_url('credit_note/search');?>" method="POST" class="form-inline" role="form">

            <div class="form-group">
              <label class="sr-only" for="">search</label>
              <input type="text" class="form-control" id="search" name="search" placeholder="serial number">
            </div>

            <button type="submit" class="btn btn-primary">ค้นหา</button>
          </form>
          <div class="table-responsive">
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
                <?php foreach ($credit_note_list as $credit_note): ?>
                  <tr>
                    <td>
                      <span>รหัส : <strong><?php echo $credit_note['docno'] ?></strong></span>
                      <br/>
                      <span>serial number : <strong><?php echo $credit_note['serial_number'] ?></strong></span>
                      <br/>
                      <span>order : <strong><?php echo $credit_note['order_id'] ?></strong></span>
                      <br/>

                    </td>
                    <td style="width:30%">
                      <span>name : <strong><?php echo $credit_note['order_name'] ?></strong></span>
                      <br/>
                      <span>ที่อยู่จัดส่ง : <strong><?php echo $credit_note['address'] ?></strong></span>
                      <br/>
                    </td>
                    <td>
                      <span>sku : <strong><?php echo $credit_note['sku'] ?></strong></span>
                      <br/>
                      <span>name : <strong><?php echo $credit_note['product_name'] ?></strong></span>
                      <br/>
                    </td>
                    <td>

                      <?php if (isset($credit_note['order_id_new'])): ?>
                        <span class="label label-success"> เลขที่ใบขายใหม่ : #<?php echo $credit_note['order_id_new'] ?></span><br>

                      <?php endif; ?>
                      <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($credit_note['modified_date']));?></span>
                      <br/>
                      <?php if ($credit_note['is_active']=="1"): ?>
                        <span><i class="fa fa-check"></i> ใช้งาน</span>
                        <br/>
                        <?php else: ?>
                          <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                          <br/>
                          <?php endif ?>

                        <?php if ($credit_note['is_refund']=="1"): ?>
                        <span class="text-info"><i class="fa fa-check"></i> คืนเงิน</span>
                        <br/>
                        <?php endif ?>
                    </td>
                    <td><a class="btn btn-xs btn-info" href="<?php echo base_url('credit_note/edit/'.$credit_note['id']) ?>" role="button"><i class="fa fa-pencil"></i> แก้ไข</a>
                    <a target="_blank" class="btn btn-xs btn-success" href="<?php echo base_url('credit_note/edit_view/'.$credit_note['id']) ?>" role="button">ดูใบลดหนี้</a>
                    </td>
                  </tr>
                  <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="add">
          <div style="padding-top:30px;"></div>
          <form class="form-horizontal" method="POST" name="return_form" action="<?php echo base_url('credit_note/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
            <fieldset>
              <!-- Text input-->
              <div class="form-group">
                <label class="col-md-3 control-label" for="return_id">เลขที่ใบรับคืน</label>

                <div class="col-md-6">
                  <div class="input-group">
                    <input id="return_id" name="return_id" type="text" placeholder="เลขที่ใบรับคืน" class="form-control input-md" ng-model="return_id" ng-init="return_id = items.return_id" required="" readonly="true">

                    <span class="input-group-addon"> <button type="button" ng-click="open()">เลือกใบรับคืน</i></button></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="order_id">เลขที่ใบสั่งซื้อ</label>
                <div class="col-md-6">
                  <input id="order_id" name="order_id" type="text" placeholder="เลขที่ใบสั่งซื้อ" class="form-control input-md" ng-model="order_id" ng-init="order_id = items.order_id" required="" readonly="true">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label" for="product_id">รหัสสินค้า</label>
                <div class="col-md-6">
                  <input id="product_id" name="product_id" type="text" placeholder="รหัสสินค้า" class="form-control input-md"
                    ng-model="product_id" ng-init="product_id = items.product_id" required="" readonly="true">
                    <p><strong>Product Name: </strong>
                        <span ng-model="product_name" ng-bind="product_name"></span>
                        <br>
                        <strong>Price : </strong>
                        <span ng-model="product_price" ng-bind="product_price"></span>
                    </p>
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
                <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
                <div class="col-md-4">
                  <div class="checkbox">
                    <label for="isactive-0">
                      <input type="checkbox" name="isactive" id="isactive-0" value="1" checked> ใช้งาน
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label" for="isactive">คืนเงิน</label>
                  <div class="col-md-4">
                    <div class="checkbox">
                      <label for="is_refund">
                        <input type="checkbox" name="is_refund" id="is_refund" value="1"> คืนเงิน
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group" id="imgshow">
                    <label class="col-md-3 control-label" for="image_field">รูปสลิป</label>
                    <div class="col-md-6">
                        <input id="image_field" name="image_field" class="file-loading" type="file" data-show-upload="false" data-min-file-count="1">
                    </div>
                </div>
              <!-- Button -->
              <div class="form-group">
                <label class="col-md-3 control-label" for="save"></label>
                <div class="col-md-4" ng-show="!return_form.return_id.$invalid && !return_form.order_id.$invalid">
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
