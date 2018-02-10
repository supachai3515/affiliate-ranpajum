<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      เปิดใบสั่งซื้อ
      <small>เปิดใบสั่งซื้อ</small>
    </h1>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>backend_order/list_temp"><i class="fa fa-eye"></i> View List</a>
            </div>
        </div>
    </div>
      <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                  <h3 class="box-title">เลือกสินค้า</h3>
                  <div class="box-tools">
                      <form action="<?php echo base_url() ?>backend_order" method="POST" id="searchList">
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
                      <th class="text-center">#</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Date</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php foreach ($products_serach as $record): ?>
                    <tr>
                      <td class="text-center">
                        <img src="<?php echo $this->config->item('url_img').$record->image?>" class="img-thumbnail" alt="" width="100px">
                      </td>
                      <td>
                        <strong>SKU : </strong> <?php echo $record->sku ?><br>
                        <strong>Name : </strong> <?php echo $record->name ?><br>
                        <strong>Type : </strong> <?php echo $record->type_name ?><br>
                        <strong>brand : </strong> <?php echo $record->brand_name ?><br>
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
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'backend_order/add/'.$record->id; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
