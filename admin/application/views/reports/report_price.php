<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box">
        <div class="page-header">
            <h1>รายงานยอดขายสินค้า
            <?php if($this->input->get("method") == 'post'){?><small style="float:right">
            	<a href="<?php echo base_url('report_order/report_product');?>"><button style="color:#000;" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i>&nbsp;โชว์ข้อมูลทั้งหมด</button></a>
            </small>
			<?php }?>
            </h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="?method=post" method="post" class="form-inline" role="form">
            <select name="select_date" id="input" class="form-control" required="required">
            <?php if (!isset($resultpost['select_date']) || $resultpost['select_date'] == 1): ?>
              <option value="1" selected="true">วันที่สั่งซื้อ</option>
              <option value="2">วันที่ออกใบกำกับภาษี</option>
            <?php else: ?>
              <option value="1">วันที่สั่งซื้อ</option>
              <option value="2"  selected="true">วันที่ออกใบกำกับภาษี</option>
            <?php endif ?>

            </select>
            <div class="form-group">
            	<span id="startDate" style="display:none"><?php echo DATE;?></span>
                <label for="">วันที่เริ่มต้นค้นหา</label>
                <input type="text" class="form-control" id="dateStart" name="dateStart" placeholder="วันที่เริ่มต้นค้นหา" value="<?php if($this->input->get("method") == 'post'){echo ($resultpost['dateStart'] == '' ? DATE : $resultpost['dateStart']);}?>">
            </div>
            <div class="form-group">
            	<span id="endDate"></span>
                <label for="">วันที่สิ้นสุดการค้นหา</label>
                <input type="text" class="form-control" id="dateEnd" name="dateEnd" placeholder="วันที่สิ้นสุดการค้นหา" value="<?php if($this->input->get("method") == 'post'){echo ($resultpost['dateEnd'] == '' ? DATE : $resultpost['dateEnd']);}?>">
            </div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th class="text-right">จำนวน</th>
                        <th class="text-right">VAT</th>
                        <th class="text-right">ยอดรวมใบกำกับภาษี</th>
                        <th class="text-right">ค่าจัดส่ง</th>
                        <th class="text-right">ทั้งหมด</th>
                    </tr>
                </thead>
                <?php $quantity =0 ;$vat =0; $shipping_charge =0; $total = 0; $total_invat=0; ?>
                <?php foreach ($price_report_data as $value): ?>
                  <tr>
                      <td><?php echo $value['date']; ?></td>
                      <td class="text-right"><?php echo number_format($value['quantity'],0); ?></td>
                      <td class="text-right"><?php echo number_format($value['vat'],2); ?></td>
                      <td class="text-right"><?php echo number_format($value['total_invat'],2); ?></td>
                      <td class="text-right"><?php echo number_format($value['shipping_charge'],2); ?></td>
                      <td class="text-right"><?php echo number_format($value['total'],2); ?></td>

                  </tr>
                <?php
                 $quantity =  $quantity + $value['quantity'];
                  $vat = $vat + $value['vat'];
                  $shipping_charge = $shipping_charge + $value['shipping_charge'];
                  $total = $total + $value['total'];
                  $total_invat = $total_invat + $value['total_invat'];
                ?>
                <?php endforeach; ?>
                <tbody>
                </tbody>
                <tfoot>
                  <tr>
                      <td class="text-center"><strong>รวม</strong></td>
                      <td class="text-right"><strong><?php echo number_format($quantity,0); ?></strong> </td>
                      <td class="text-right"><strong><?php echo number_format($vat,2); ?></td>
                      <td class="text-right"><strong><?php echo number_format($total_invat,2); ?></td>
                      <td class="text-right"><strong><?php echo number_format($shipping_charge,2); ?></strong> </td>
                      <td class="text-right"><strong><?php echo number_format($total,2); ?></strong> </td>
                  </tr>
                </tfoot>
            </table>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content -->
