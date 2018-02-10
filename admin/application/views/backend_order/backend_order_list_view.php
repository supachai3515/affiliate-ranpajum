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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <h3 class="box-title">list สินค้า</h3>
            </div><!-- /.box-header -->
            <div class="">
              <?php
                if($this->session->flashdata('msg') != ''){
                    echo '
                    <div class="alert alert-warning alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      '.$this->session->flashdata('msg').'
                    </div>';
                }
            ?>
            </div>
            <div class="box-body table-responsive no-padding">
              <?php if ($this->cart->contents()): ?>
              <?php echo form_open('backend_order/update_cart'); ?>
              <table class="table table-hover">
                  <tr>
                    <th class="text-center">#</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th class="text-center">Actions</th>
                  </tr>
                  <tbody>
                      <?php $i = 1; ?>
                      <?php foreach($this->cart->contents() as $items): ?>
                      <?php echo form_hidden('rowid[]', $items['rowid']); ?>
                      <?php foreach ($cart_list as $row): ?>
                      <?php if ($row['rowid']== $items['rowid']): ?>
                      <tr <?php if($i&1){ echo 'class="alt"'; }?>>
                          <td class="text-center">
                            <img src="<?php echo $row['img']; ?>" class="img-responsive" alt="" width="100">
                          </td>
                          <td class="cart-description">
                              <p><?php echo $row['name']; ?></p>
                              <?php if($row['slug']!=''){ echo '<small >SKU : '.$row['sku'].'</small>'; }?>
                          </td>
                          <td>
                            <?php echo form_input(array('type' => 'number','require' => 'true','name' => 'price[]', 'value' => $items['price'], 'maxlength' => '3', 'size' => '5')); ?>
                          </td>
                          <td>
                              <input type="text" hidden="true"  name="product_id[]" value="<?php echo $row['id'] ?>">
                              <?php echo form_input(array('type' => 'number','require' => 'true','name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                          </td>
                          <td>
                              <span class="price"><?php echo $this->cart->format_number($items['subtotal']); ?></span>
                          </td>
                          <td>
                              <p class="text-center">
                                  <a href="<?php echo base_url('backend_order/delete/'.$row['rowid']) ?>"><i class="fa fa-trash-o" style="color:#a94442"></i></a>
                              </p>
                          </td>
                      </tr>
                      <?php endif ?>
                      <?php endforeach ?>
                      <?php $i++; ?>
                      <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><strong>รวมทั้งหมด</strong></td>
                          <td><strong><?php echo $this->cart->format_number($this->cart->total()); ?></strong></td>
                          <td></td>
                      </tr>
                  </tfoot>
                </table>
                <div class="col-xs-12 text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-info"><i class="fa fa-undo"></i> ปรับปรุง</button>
                    </div>
                </div>
              <?php echo form_close();  ?>
              <?php endif; ?>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
    </div>
    <div class="row">
      <form class="" action="<?php echo base_url('backend_order/save/'); ?>" method="post">
        <div class="col-xs-12 text-right">
          <div class="form-group col-sm-offset-9 col-sm-3">
            <div class="input-group">
              <span class="input-group-addon">ชื่อ</span>
              <input type="text" name="txtName" class="form-control" placeholder="ชื่อลูกค้า" value="">

            </div>
          </div>
          <div class="form-group col-sm-offset-9 col-sm-3">
            <div class="input-group">
              <span class="input-group-addon">ชื่อขนส่ง</span>
              <input type="text" name="txtShipping" class="form-control" placeholder="ชื่อขนส่ง" value="">
            </div>
          </div>
          <div class="form-group col-sm-offset-9 col-sm-3">
            <div class="input-group">
              <span class="input-group-addon">ค่าจัดส่ง</span>
              <input type="number" name="txtShipping_charge"  class="form-control" placeholder="" value="0">

            </div>
          </div>
            <div class="form-group">
               <a class="btn btn-primary" href="<?php echo base_url(); ?>backend_order"><i class="fa fa-arrow-left"></i> กลับไปเลือกสินค้า</a>
               <?php if ($this->cart->total() > 0 ): ?>
                 <button class="btn btn-info" type="submit"><i class="fa fa-floppy-o"></i> บันทึก order</button>
              <?php endif ?>
            </div>
        </div>
      </form>
    </div>

    </div><!-- /.box -->
  </div>
    </div>
  </section>
  <!-- /.content -->
</div>
