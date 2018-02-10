<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box">
        <div class="page-header">
            <h1>รายงานจัดซื้อ
        </div>
        <div class="row">
            <form action="<?php echo base_url() ?>report_order/report_purchase_order/1/?method=post" method="post" class="form" role="form">
              <fieldset>
                <div class="col-md-6">
                  <div class="form-group">
                    <span id="startDate" style="display:none"><?php echo DATE;?></span>
                      <label for="">จากวันทีใบสั่งซื้อ</label>
                      <input type="text" class="form-control" id="dateStart" name="dateStart" placeholder="วันที่เริ่มต้นค้นหา" value="<?php if($this->input->get("method") == 'post'){echo ($resultpost['dateStart'] == '' ? DATE : $resultpost['dateStart']);}?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <span id="endDate"></span>
                      <label for="">ถึงวันที่ใบสั่งซื้อ</label>
                      <input type="text" class="form-control" id="dateEnd" name="dateEnd" placeholder="วันที่สิ้นสุดการค้นหา" value="<?php if($this->input->get("method") == 'post'){echo ($resultpost['dateEnd'] == '' ? DATE : $resultpost['dateEnd']);}?>">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="search">รหัส + ชื่อ + Model + รายละเอียด</label>
                    <input id="search" name="search"  value="<?php if(isset($data_search['search']))echo $data_search['search']; ?>" type="text" class="form-control input-md">
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="select_brand">ยี่ห้อสินค้า</label>
                    <select id="select_brand" name="select_brand" class="form-control">
                        <option value="">ทั้งหมด</option>
                        <?php foreach ($brands_list as $brand): ?>
                            <?php if ($brand['id']==$data_search['product_brand_id']): ?>
                                <option value="<?php echo $brand['id']; ?>" selected><?php echo $brand['name']; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
                            <?php endif ?>
                        <?php endforeach ?>

                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="select_type">หมวดสินค้า</label>
                    <select id="select_type" name="select_type" class="form-control">
                        <option value="">ทั้งหมด</option>
                        <?php foreach ($type_list as $type): ?>
                            <?php if ($type['id']==$data_search['product_type_id']): ?>
                                <option value="<?php echo $type['id']; ?>" selected><?php echo $type['name']; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="promotion">โปรโมชั่น</label>
                    <div class="checkbox">
                        <label for="all_promotion">
                            <input type="checkbox" name="all_promotion" id="all_promotion" value="1"
                                <?php if(isset($data_search['all_promotion'])) {if($data_search['all_promotion']==1) echo "checked";} ?> > ทั้งหมด
                        </label>
                        <label for="is_promotion">
                            <input type="checkbox" name="is_promotion" id="is_promotion" value="1"
                             <?php if(isset($data_search['is_promotion'])) {if($data_search['is_promotion']==1) echo "checked";} ?> > ลดราคา
                        </label>
                        <label for="is_sale">
                            <input type="checkbox" name="is_sale" id="is_sale" value="1"
                            <?php if(isset($data_search['is_sale'])) {if($data_search['is_sale']==1) echo "checked";} ?> > แนะนำ
                        </label>
                        <label for="is_hot">
                            <input type="checkbox" name="is_hot" id="is_hot" value="1"
                            <?php if(isset($data_search['is_hot'])) {if($data_search['is_hot']==1) echo "checked";} ?>> ได้รับความนิยม
                        </label>
                        <label for="isactive-0">
                            <input type="checkbox" name="isactive" id="isactive" value="1"
                             <?php if(isset($data_search['is_active'])) {if($data_search['is_active']==1) echo "checked";} ?> > ใช้งานสินค้า
                        </label>

                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="from_stock">สินค้าคงเหลือ</label>
                    <input id="from_stock" name="from_stock" type="number"
                        value="<?php if(isset($resultpost['from_stock']))echo $resultpost['from_stock']; else echo "0"; ?>" class="form-control input-md">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="to_stock">ถึง</label>
                    <input id="to_stock" name="to_stock" type="number"
                    value="<?php if(isset($resultpost['to_stock']))echo $resultpost['to_stock']; else echo "9999"; ?>" class="form-control input-md">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="from_stock">จำนวนขาย</label>
                    <input id="from_stock" name="from_order_qty" type="number"
                        value="<?php if(isset($resultpost['from_order_qty']))echo $resultpost['from_order_qty']; else echo "1"; ?>" class="form-control input-md">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="to_stock">ถึง</label>
                    <input id="to_stock" name="to_order_qty" type="number"
                    value="<?php if(isset($resultpost['to_order_qty']))echo $resultpost['to_order_qty']; else echo "9999"; ?>" class="form-control input-md">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="from_stock">จำนวนขอซื้อ</label>
                    <input id="from_stock" name="from_purchase_order_qty" type="number"
                        value="<?php if(isset($resultpost['from_purchase_order_qty']))echo $resultpost['from_purchase_order_qty']; else echo "0"; ?>" class="form-control input-md">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="to_stock">ถึง</label>
                    <input id="to_stock" name="to_purchase_order_qty" type="number"
                    value="<?php if(isset($resultpost['to_purchase_order_qty']))echo $resultpost['to_purchase_order_qty']; else echo "9999"; ?>" class="form-control input-md">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="is_export">
                        <input type="checkbox" name="is_export" id="is_hot" value="1"
                        <?php if(isset($data_search['is_export'])) {if($data_search['is_export']==1) echo "checked";} ?>> export to excel
                    </label>
                  </div>
                </div>
                <div class="col-md-6">

                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary">ค้นหา</button>
                  </div>
                </div>
              </fieldset>
            </form>
            <p> *** วันที่ขาย
              <?php

              $date  = strtotime('-7 days');
              $obj['dateStart'] = date("Y-m-d",$date );
              $obj['dateEnd'] = date("Y-m-d");

                if (isset($resultpost['dateStart']) && $resultpost['dateStart'] != "") {
                    echo $resultpost['dateStart'].' - '. $resultpost['dateEnd'];
                }
                else {
                  echo $obj['dateStart'] .' - '. $obj['dateEnd'];
                }
              ?> ***</p>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tr>
                    <th class="text-center">#</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Stock</th>
                    <th>จำนวนขาย</th>
                    <th>ขอซื้อ</th>

                  </tr>
                  <?php foreach ($purchase_order_report_data as $record): ?>
                  <tr>
                    <td class="text-center">
                      <img src="<?php echo $this->config->item('url_img').$record->image?>" class="img-thumbnail" alt="" width="100px">
                    </td>
                    <td>
                      <strong>SKU : </strong> <?php echo $record->sku ?><br>
                      <strong>Name : </strong> <?php echo $record->name ?><br>
                      <strong>Type : </strong> <?php echo $record->type_name ?><br>
                      <strong>brand : </strong> <?php echo $record->brand_name ?><br>
                      <strong>Model : </strong> <?php echo $record->model ?><br>
                    </td>
                    <td>

                        <span>ราคา : </span><span class="text-success" ng-bind="<?php echo $record->price;?> | currency:'฿':0"></span>
                        <br/>
                        <span>ลดราคา : </span><span class="text-danger" ng-bind="<?php echo $record->dis_price;?> | currency:'฿':0"></span>
                        <br/>
                        <span>ราคา dealer : </span><span class="text-info" ng-bind="<?php echo $record->member_discount;?> | currency:'฿':0"></span>
                        <br/>
                        <span>ราคา dealer fanshine : </span><span class="text-danger" ng-bind="<?php echo $record->member_discount_lv1;?> | currency:'฿':0"></span>
                        <br/>
                    </td>
                    <td>
                        <span><i class="fa fa-calendar-o"></i> <?php echo  date("d-m-Y H:i", strtotime($record->create_date));?></span>
                        <br/>
                        <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($record->modified_date));?></span>
                        <br/>
                           <?php if ($record->is_active=="1"): ?>
                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                            <br/>
                        <?php else: ?>
                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                            <br/>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if($record->stock < 5 && $record->stock != 0) { ?>
                            <strong><span class="text-danger"><?php echo $record->stock;?> <i class="fa fa-caret-down"></i></span></strong>
                        <?php } else if ($record->stock > 4) {?>
                            <strong><span class="text-success"><?php echo $record->stock;?> <i class="fa fa-caret-up"></i></span></strong>
                        <?php  }?>
                        <?php if ($record->stock == 0): ?>
                            <strong><span class="text-danger">0</span></strong>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if($record->order_qty < 5 && $record->order_qty != 0) { ?>
                            <strong><span class="text-danger"><?php echo $record->order_qty;?> <i class="fa fa-caret-down"></i></span></strong>
                        <?php } else if ($record->order_qty > 4) {?>
                            <strong><span class="text-success"><?php echo $record->order_qty;?> <i class="fa fa-caret-up"></i></span></strong>
                        <?php  }?>
                        <?php if ($record->order_qty == 0): ?>
                            <strong><span class="text-danger">0</span></strong>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if($record->purchase_order_qty < 5 && $record->purchase_order_qty != 0) { ?>
                            <strong><span class="text-danger"><?php echo $record->purchase_order_qty;?> <i class="fa fa-caret-down"></i></span></strong>
                        <?php } else if ($record->purchase_order_qty > 4) {?>
                            <strong><span class="text-success"><?php echo $record->purchase_order_qty;?> <i class="fa fa-caret-up"></i></span></strong>
                        <?php  }?>
                        <?php if ($record->purchase_order_qty == 0): ?>
                            <strong><span class="text-danger">0</span></strong>
                        <?php endif ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content -->
