<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box">
        <div class="page-header">
            <h1>รายงานชำระเงิน
            <?php if($this->input->get("method") == 'post'){?><small style="float:right">
            	<a href="<?php echo base_url('report_order');?>"><button style="color:#000;" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i>&nbsp;โชว์ข้อมูลทั้งหมด</button></a>
            </small>
			<?php }?>
            </h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>

        <form action="?method=post" method="post" class="form-inline" role="form">
        	<div class="form-group">
            	<label for="">รายชื่อธนาคาร</label>
                <select name="list_category" id="list_category" style="height:30px;" class="form-control">
                    <option value="0">ทั้งหมด</option>
                    <option value="ธนาคารกรุงเทพ" <?php if($resultpost['list_category'] == 'ธนาคารกรุงเทพ'){echo "selected";}?>>ธนาคารกรุงเทพ</option>
                    <option value="ธนาคารกรุงไทย" <?php if($resultpost['list_category'] == 'ธนาคารกรุงไทย'){echo "selected";}?>>ธนาคารกรุงไทย</option>
                    <option value="ธนาคารไทยพาณิชย์" <?php if($resultpost['list_category'] == 'ธนาคารไทยพาณิชย์'){echo "selected";}?>>ธนาคารไทยพาณิชย์</option>
                    <option value="ธนาคารกสิกรไทย" <?php if($resultpost['list_category'] == 'ธนาคารกสิกรไทย'){echo "selected";}?>>ธนาคารกสิกรไทย</option>
                    <option value="ใบลดหนี้" <?php if($resultpost['list_category'] == 'ใบลดหนี้'){echo "selected";}?>>ใบลดหนี้</option>
                </select>
            </div>

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
    		<div class="form-group">
            	<label><input type="checkbox" value="1" name="checkbank" <?php if($this->input->get("method") == 'post'){echo (empty($resultpost['checkbank']) != 1 ? 'checked="checked"' : '');}?>>รายละเอียด</label>
          	</div>
            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <?php if (empty($resultpost['checkbank']) == 1): ?>
          <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th>วันที่ชำระเงิน</th>
                          <th>รายชื่อธนาคาร</th>
                          <th>สถานะ</th>
                          <th class="text-right">จำนวนเงินที่โอนมาทั้งหมด</th>
                      </tr>
                  </thead>
                  <tbody>
                <?php  $sum_total = 0; ?>
                <?php foreach ($selectDB as $row ): ?>
                  <tr>
                    <td><?php echo $row['inform_date_time'] ?></td>
                    <td><?php echo $row['bank_name'] ?></td>
                    <td>  <?php  switch ($row['order_status_id']) {
                       case '1':
                           echo '<strong class="label label-warning"> <i class="fa fa-clock-o" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                           break;
                      case '2':
                       echo '<strong class="label label-info"><i class="fa fa-spinner" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                      break;
                      case '3':
                      echo '<strong class="label label-danger"><i class="fa fa-pause-circle-o" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                      break;
                          case '4':
                              echo '<strong class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                              break;
                              case '5':
                              echo '<strong class="label label-default"><i class="fa fa-ban" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                              break;

                          default:
                              echo '<strong class="label label-default"><i class="fa fa-repeat" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                              break;
                      }?></td>
                    <td  class="text-right"><?php echo number_format( $row['amount'],0); $sum_total += $row['amount']; ?></td>
                  </tr>
                <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td>รวม</td>
                      <td></td>
                      <td></td>
                      <td  class="text-right text-danger"><?php echo number_format( $sum_total,0); ?></td>
                    </tr>
                  </tfoot>
              </table>
          </div>
        <?php else: ?>
          <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th>วันที่ชำระเงิน</th>
                          <th>order</th>
                          <th>invoice</th>
                          <th>order name</th>
                          <th>รายชื่อธนาคาร</th>
                          <th>สถานะ</th>
                          <th class="text-right">ยอดซื้อ</th>
                          <th class="text-right">จำนวนเงินที่โอนมาทั้งหมด</th>
                      </tr>
                  </thead>
                  <tbody>
                <?php  $sum_total = 0;  $sum_amount = 0;?>
                <?php foreach ($selectDB as $row ): ?>
                  <tr>
                    <td><?php echo $row['inform_date'] ?></td>
                    <td><?php echo $row['order_id'] ?></td>
                    <td><?php echo $row['invoice_docno'] ?></td>
                    <td><?php echo $row['order_name'] ?></td>
                    <td><?php echo $row['bank_name'] ?></td>
                    <td>  <?php  switch ($row['order_status_id']) {
                       case '1':
                           echo '<strong class="label label-warning"> <i class="fa fa-clock-o" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                           break;
                      case '2':
                       echo '<strong class="label label-info"><i class="fa fa-spinner" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                      break;
                      case '3':
                      echo '<strong class="label label-danger"><i class="fa fa-pause-circle-o" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                      break;
                          case '4':
                              echo '<strong class="label label-success"><i class="fa fa-check" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                              break;
                              case '5':
                              echo '<strong class="label label-default"><i class="fa fa-ban" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                              break;

                          default:
                              echo '<strong class="label label-default"><i class="fa fa-repeat" aria-hidden="true"></i> '.$row['order_status_name'].'</strong><br/>';
                              break;
                      }?></td>
                    <?php if ($row['total'] != $row['amount']): ?>
                      <td class="text-right text-warning"><?php echo number_format( $row['total'],0);  $sum_total += $row['total'];?></td>
                      <td  class="text-right text-warning"><?php echo number_format( $row['amount'],0); $sum_amount += $row['amount']; ?></td>
                    <?php else: ?>
                      <td class="text-right"><?php echo number_format( $row['total'],0);  $sum_total += $row['total'];?></td>
                      <td  class="text-right"><?php echo number_format( $row['amount'],0); $sum_amount += $row['amount']; ?></td>
                    <?php endif; ?>

                  </tr>
                <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td>รวม</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td  class="text-right text-danger"><?php echo number_format( $sum_total,0); ?></td>
                      <td  class="text-right text-danger"><?php echo number_format( $sum_amount,0); ?></td>
                    </tr>
                  </tfoot>
              </table>
          </div>
        <?php endif; ?>
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
<!-- /.content -->
