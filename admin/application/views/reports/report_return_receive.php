<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box">
        <div class="page-header">
            <h1> รายงานใบรับคืน
        </div>
        <div class="row">
            <form action="<?php echo base_url() ?>report_order/report_return_receive/1/" method="post" class="form" role="form">
              <fieldset>
                <div class="col-md-6">
                  <div class="form-group">
                    <span id="startDate" style="display:none"><?php echo DATE;?></span>
                      <label for="">จากวันทีใบสั่งซื้อ</label>
                      <input type="text" class="form-control" id="dateStart" name="dateStart" placeholder="วันที่เริ่มต้นค้นหา" value="<?php if(isset($resultpost['dateStart'])){echo ($resultpost['dateStart'] == '' ? DATE : $resultpost['dateStart']);}?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <span id="endDate"></span>
                      <label for="">ถึงวันที่ใบสั่งซื้อ</label>
                      <input type="text" class="form-control" id="dateEnd" name="dateEnd" placeholder="วันที่สิ้นสุดการค้นหา" value="<?php if(isset($resultpost['dateEnd'])){echo ($resultpost['dateEnd'] == '' ? DATE : $resultpost['dateEnd']);}?>">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="search">รหัส + ชื่อ + Serial</label>
                    <input id="search" name="search"  value="<?php if(isset($resultpost['search']))echo $resultpost['search']; ?>" type="text" class="form-control input-md">
                  </div>
                </div>
                <div class="">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="select_supplier">ผู้ผลิต</label>

                      <select id="select_supplier" name="select_supplier" class="form-control">
                       <?php if ($return_receive_data['supplier_id']== 0 || !isset($resultpost['select_supplier'])): ?>
                          <option value="" selected>ทั้งหมด</option>
                          <?php else: ?>
                            <option value="">ทั้งหมด</option>
                      <?php endif ?>
                    <?php foreach ($supplier_list as $supplier): ?>
                        <?php if ($supplier['id']==$resultpost['select_supplier']): ?>
                          <option value="<?php echo $supplier['id']; ?>" selected><?php echo $supplier['name']; ?></option>
                        <?php else: ?>
                          <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                      </select>



                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="select_return_type">ประเภทใบส่งคืน</label>
                      <select id="select_return_type" name="select_return_type" class="form-control">
                       <?php if ($return_receive_data['return_type_id']== 0 || !isset($resultpost['select_return_type'])): ?>
                         <option value="" selected>ทั้งหมด</option>
                         <?php else: ?>
                           <option value="">ทั้งหมด</option>
                      <?php endif ?>
                    <?php foreach ($return_type_list as $return_type): ?>
                        <?php if ($return_type['id']==$resultpost['select_return_type']): ?>
                          <option value="<?php echo $return_type['id']; ?>" selected><?php echo $return_type['name']; ?></option>
                        <?php else: ?>
                          <option value="<?php echo $return_type['id']; ?>"><?php echo $return_type['name']; ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                      </select>

                    </div>
                  </div>
                </div>

                <div class="clearfix"></div>
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
            <p> *** วันที่รับคืน
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
                <thead>
                  <tr>
                    <th>รหัส</th>
                    <th>รายละเอียด</th>
                    <th>supplier</th>
                    <th>สถานะ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($return_receive_report_data as $return_receive): ?>
                    <tr>
                      <td>
                        <span>รหัส : <strong><?php echo $return_receive['docno'] ?></strong></span>
                        <br/>
                        <span>serial number : <strong><?php echo $return_receive['serial_number'] ?></strong></span>
                        <br/>
                        <span>order : <strong><?php echo $return_receive['order_id'] ?></strong></span>
                      </td>
                      <td>
                        <span>Name : <strong><?php echo $return_receive['order_name'] ?></strong></span>
                        <br/>
                        <span>ที่อยู่จัดส่ง : <strong><?php echo $return_receive['address'] ?></strong></span>
                        <br/>
                        <span>SKU : <strong><?php echo $return_receive['sku'] ?></strong></span>
                        <br/>
                        <span>Product Name : <strong><?php echo $return_receive['product_name'] ?></strong></span>
                        <br/>
                      </td>


                      <td>
                          <span>supplier: <strong><?php echo $return_receive['supplier_name'] ?></strong></span>
                          <br/>
                          <span>return type: <strong><?php echo $return_receive['return_type_name'] ?></strong></span>
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

                    </tr>
                    <?php endforeach ?>
                </tbody>
              </table>
            </div>
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
