<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      ใบขอซื้อ
      <small>ใบขอซื้อ</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>purchase_order/add"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div>
    </div>
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title">ใบขอซื้อ List</h3>
                  <div class="box-tools">
                      <form action="<?php echo base_url() ?>purchase_order" method="POST" id="searchList">
                          <div class="input-group">
                            <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                            <div class="input-group-btn">
                              <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                      </form>
                  </div>
              </div><!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                      <th>รหัส</th>
                      <th>supplier</th>
                      <th>จำนวนรายการ</th>
                      <th>จำนวนทั้งหมด</th>
                      <th>รวม</th>
                      <th>วันที่</th>
                      <th>สถานะ</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php foreach ($purchase_order_list as $record): ?>
                    <tr>
                      <td><?php echo $record->doc_no ?></td>
                      <td><?php echo $record->supplier ?></td>
                      <td><?php echo $record->product_id ?></td>
                      <td><?php echo $record->qty ?></td>
                      <td><?php echo number_format($record->total,2) ?></td>
                      <td>
                        <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($record->create_date));?></span><br>
                        <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($record->modified_date));?></span><br>
                      </td>
                      <td>
                          <?php if ($record->is_success=="1"): ?>
                              <span class="text-success"><i class="fa fa-check"></i> สำเร็จแล้ว</span>
                          <?php else: ?>
                              <span class="text-warning"><i class="fa fa-clock-o"></i> กำลังดำเนินการ</span>
                          <?php endif ?>
                          <br>
                          <?php if ($record->is_active=="1"): ?>
                              <span><i class="fa fa-check"></i> ใช้งาน</span>
                          <?php else: ?>
                              <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                          <?php endif ?>
                      </td>
                      <td class="text-center">
                        <?php if ($record->is_to_receive > 0): ?>
                          <button type="button" class="btn btn-sm btn-default" disabled><i class="fa fa-exchange" aria-hidden="true"></i></button>
                        <?php else: ?>
                          <a class="btn btn-sm btn-primary" href="<?php echo base_url().'purchase_order/transfer_save/'.$record->id; ?>"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                        <?php endif; ?>
                          <a class="btn btn-sm btn-warning" href="<?php echo base_url().'purchase_order/edit/'.$record->id; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                          <a class="btn btn-sm btn-warning" target="_blank" href="<?php echo base_url().'purchase_order/edit_view/'.$record->id; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          <a class="btn btn-sm btn-info" target="_blank" href="<?php echo base_url().'purchase_order/view/'.$record->id; ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </table>
              </div><!-- /.box-body -->
              <div class="box-footer clearfix">
                  <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
              </div>
            </div><!-- /.box -->
          </div>
      </div>
  </section>
  <!-- /.content -->
</div>
