<div class="content-wrapper">
  <section class="content">
  <script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header">
      <h4>เลือกใบสั่งซื้อ</h4>
    </div>
    <div class="modal-body">
      <form class="form-inline" role="form" ng-submit="searchOrder(search_order)">
          <p class="" for="">รหัสสินค้า, เลขที่ใบสั่งซื้อ, เลขที่ invoice, ชื่อลูกค้า</p>
        <div class="form-group">
          <input type="text" class="form-control" ng-model="search_order" ng-init="search_order =''" placeholder="">
        </div>
        <button type="submit" class="btn btn-primary">ค้นหา</button>
      </form>
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Order</th>
              <th>Serial Number</th>
              <th>Order Date</th>
              <th>Products</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="value in order_data">
              <td>
                order : <span ng-bind="value.order_id"></span>/ <span ng-bind="value.invoice_no"></span> Name : <span ng-bind="value.order_name"></span>
              </td>
              <td>
                <span ng-bind="value.serial_number"></span>
                <br>
              </td>
              <td><span ng-bind="value.order_date"></span></td>
              <td>
                SKU : <span ng-bind="value.sku"></span>
                <br> NAME : <span ng-bind="value.product_name"></span>
              </td>
              <td>
                <button type="button" class="btn btn-info btn-xs" ng-click="selectOrder(value.order_id,value.product_id,value.serial_number)">เลือก</button>
              </td>
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
      <h2>ใบรับคืน <?php echo $return_receive_data['docno']; ?></h2>
    </div>
    <div style="padding-top:30px;"></div>
    <form class="form-horizontal">
      <fieldset>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>
          <div class="col-md-1">
            <input type="text" name="docno" hidden="true" value="<?php echo $return_receive_data['docno']; ?>">
            <input id="id" name="id" type="text" readonly="true" value="<?php echo $return_receive_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
          </div>
          <label class="col-md-3">
            <?php echo $return_receive_data['docno']; ?>
          </label>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="order_id">เลขที่ใบสั่งซื้อ</label>
          <div class="col-md-1">
            <div class="input-group">
              <input id="order_id" name="order_id" type="text" placeholder="เลขที่ใบสั่งซื้อ" class="form-control input-md" ng-model="order_id" ng-init="order_id = items.order_id" required="" readonly="true">
            </div>
          </div>
          <label class="col-md-3">
            <?php echo $return_receive_data['invoice_no']; ?>
          </label>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="product_id">รหัสสินค้า</label>
          <div class="col-md-6">
            <input id="product_id" name="product_id" type="text" placeholder="รหัสสินค้า" class="form-control input-md" ng-model="product_id" ng-init="product_id = items.product_id" required="" readonly="true">
            <p><strong>Product Name: </strong>
              <?php echo $return_receive_data['product_name']; ?>
                <br>
                <strong>Price : </strong>
                <?php echo $return_receive_data['price']; ?>
            </p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="serial">serial number</label>
          <div class="col-md-6">
            <input id="serial" name="serial" type="text" placeholder="serial number" class="form-control input-md" ng-model="serial" ng-init="serial = items.serial" required="" readonly="true">
          </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="select_supplier">ผู้ผลิต</label>
          <div class="col-md-4">
            <select id="select_supplier" name="select_supplier" class="form-control" readonly>
             <?php if ($return_receive_data['supplier_id']== 0 || !isset($return_receive_data['supplier_id'])): ?>
                <option value="0" selected>*** ไม่มี ***</option>
                <?php else: ?>
                  <option value="0">*** ไม่มี ***</option>
            <?php endif ?>
          <?php foreach ($supplier_list as $supplier): ?>
              <?php if ($supplier['id']==$return_receive_data['supplier_id']): ?>
                <option value="<?php echo $supplier['id']; ?>" selected><?php echo $supplier['name']; ?></option>
              <?php else: ?>
                <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
              <?php endif ?>
            <?php endforeach ?>
            </select>
          </div>
        </div>


        <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="select_return_type">ประเภทใบส่งคืน</label>
          <div class="col-md-4">
            <select id="select_return_type" name="select_return_type" class="form-control" readonly>
             <?php if ($return_receive_data['return_type_id']== 0 || !isset($return_receive_data['return_type_id'])): ?>
                <option value="0" selected>*** ไม่มี ***</option>
                <?php else: ?>
                  <option value="0">*** ไม่มี ***</option>
            <?php endif ?>
          <?php foreach ($return_type_list as $return_type): ?>
              <?php if ($return_type['id']==$return_receive_data['return_type_id']): ?>
                <option value="<?php echo $return_type['id']; ?>" selected><?php echo $return_type['name']; ?></option>
              <?php else: ?>
                <option value="<?php echo $return_type['id']; ?>"><?php echo $return_type['name']; ?></option>
              <?php endif ?>
            <?php endforeach ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="comment">หมายเหตุ</label>
          <div class="col-md-6">
            <textarea class="form-control" name="comment" readonly><?php echo $return_receive_data['comment']; ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label" for="issues_comment">ปัญหาที่เสีย</label>
          <div class="col-md-6">
            <textarea class="form-control" name="issues_comment" readonly><?php echo $return_receive_data['issues_comment']; ?></textarea>
          </div>
        </div>
        <?php if ($return_receive_data['is_cut_stock']==1): ?>
          <input hidden="true" type="text" name="is_cut_stock" value="1">
          <?php endif ?>
            <!-- Multiple Checkboxes -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="is_cut_stock">เพิ่มสต็อก</label>
              <div class="col-md-4">
                <div class="checkbox">
                  <label for="is_cut_stock-0">
                    <input type="checkbox"  name="is_cut_stock" id="is_cut_stock-0" value="1" <?php if ($return_receive_data[ 'is_cut_stock']==1): ?>
                    <?php echo "checked"; ?>
                      <?php echo 'disabled="true"> เพิ่มสต็อกสินค้า' ?>
                        <?php else: ?>
                          <?php echo '> ตัดสต็อกสินค้า' ?>
                            <?php endif ?>

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
                    <input type="checkbox"  disabled="true" name="is_active" id="isactive-0" value="1" <?php if ($return_receive_data[ 'is_active']==1): ?>
                    <?php echo "checked"; ?>
                      <?php endif ?>
                        > ใช้งาน
                  </label>
                </div>
              </div>
            </div>
            <?php if (isset($return_receive_data['credit_note_docno']) || isset($return_receive_data['delivery_return_docno'])): ?>
              <div class="form-group">
                <label class="col-md-3 control-label" for="save"></label>
                <div class="col-md-4">
                  <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong></strong>
                    <?php if (isset($return_receive_data['credit_note_docno'])): ?>
                      ใบลดนี้เลขที่ #
                      <?php echo $return_receive_data['credit_note_docno'] ?>
                        <?php else: ?>
                          ใบส่งคืนเลขที่ #
                          <?php echo $return_receive_data['delivery_return_docno'] ?>
                            <?php endif ?>
                  </div>
                </div>
              </div>
                <?php endif ?>

      </fieldset>
    </form>
  </div>
  <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
