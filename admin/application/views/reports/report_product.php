<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box">
        <div class="page-header">
            <h1>รายงานสินค้าอันดับขายดี
            <?php if($this->input->get("method") == 'post'){?><small style="float:right">
            	<a href="<?php echo base_url('report_order/report_product');?>"><button style="color:#000;" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i>&nbsp;โชว์ข้อมูลทั้งหมด</button></a>
            </small>
			<?php }?>
            </h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="?method=post" method="post" class="form-inline" role="form">
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>sku</th>
                        <th>ชื่อสินค้า</th>
                        <th>ยี่ห้อ</th>
                        <th>ประเภทยี</th>
                        <th class="text-right">จำนวน</th>
                        <th class="text-right">ราคาvat</th>
                        <th class="text-right">ราคาเฉลี่ย</th>
                        <th class="text-right">ราคารวมทั้งหมด</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    $number = 1;
                    ?>
                    <?php if(count($selectDB) == 0){?>
                    <tr>
                        <td colspan="9"  class="text-center text-danger"><strong>ไม่มีข้อมูล</strong></td>
                    </tr>
                    <?php }else{
                      $sum_total = 0;
                      $avgtotal = 0;
                      $ordetailsVAC = 0;
                      $ordetailsQTY = 0;
                        foreach($selectDB as $dw):
                        ?>
                        <tr>
                            <td><strong><?php echo $number;?></strong></td>
                            <td><?php echo $dw['sku'] ?></td>
                            <td><?php echo $dw['proname'] ?></td>
                            <td><?php echo $dw['typename'] ?></td>
                            <td><?php echo $dw['brandname'] ?></td>
                            <td class="text-right"><?php echo $dw['ordetailsQTY'];?></td>
                            <td class="text-right"><?php echo number_format($dw['ordetailsVAC'],2);?></td>
                            <td class="text-right"><?php echo number_format($dw['avgtotal'],2);?></td>
                            <td class="text-right"><?php echo number_format($dw['sum_total'],2);?></td>
                        </tr>
                        <?php
              						$sum_total = $sum_total + $dw['sum_total'];
                          $avgtotal = $avgtotal + $dw['avgtotal'];
                          $ordetailsVAC = $ordetailsVAC + $dw['ordetailsVAC'];
                          $ordetailsQTY = $ordetailsQTY + $dw['ordetailsQTY'];
              						$number++;
                          ?>
                        <?php endforeach;?>
                    <?php }?>
                    <?php
					if($this->input->get("method") == 'post'){
						if(count($selectDB) != 0){?>
							<tr>
								<td colspan="5"  class="text-center"><strong>รวมยอดขายทั้งหมด</strong></td>
                <td class="text-right"><strong> <?php echo number_format($ordetailsQTY,0);?></strong></td>
                <td class="text-right"><strong> <?php echo number_format($ordetailsVAC,2);?></strong></td>
                <td class="text-right"><strong> <?php echo number_format($avgtotal,2);?></strong></td>
								<td class="text-right"><strong> <?php echo number_format($sum_total,2);?></strong></td>
							</tr>
                        <?php }?>
					<?php }?>
                </tbody>
            </table>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content -->
