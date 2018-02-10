<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ใบกํากับภาษี/ใบเสร็จรับเงิน <?php echo $orders_data['invoice_docno']." ".$orders_data["name"];?></title>

		<!-- Bootstrap CSS -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body ng-app="myApp" ng-controller="mainCtrl">
	<div style="padding-top:30px;"></div>
	<div class="container fix-container" ng-init="orderSenmailInit()">
		<div class="row">

            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            		<img src="<?php echo $this->config->item('url_img');?>theme/img/logo/logo.png" style="width: 200px"/>
            		<?php echo $this->config->item('sitename'); ?>

            	</div>
            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
            	<?php if ($orders_data['is_tax'] == 1): ?>
        				<h3>ใบกํากับภาษี/ใบเสร็จรับเงิน<br>
        				 <span style="font-size:14px"> (สำเนา) </span>
        				 <?php echo  $orders_data['invoice_docno'];?> </h3>
                        <strong>วันที่ออก <?php echo $orders_data['invoice_date']?></strong><br/>
                        <strong>วันครบกำหนด <?php echo $orders_data['invoice_date']?></strong><br/>

                         <strong>Ref. #<?php echo $orders_data['id']?></strong><br/>

            	<?php else: ?>

        				<h3>ใบกํากับภาษีอย่างย่อ/ใบเสร็จรับเงิน<br>
                        <span style="font-size:14px"> (สำเนา) </span>
        				 <?php echo  $orders_data['invoice_docno'];?> </h3>
                        <strong>วันที่ออก <?php echo $orders_data['invoice_date']?></strong><br/>
                        <strong>วันครบกำหนด <?php echo $orders_data['invoice_date']?></strong><br/>
                        <strong>Ref. #<?php echo $orders_data['id']?></strong><br/>


            	<?php endif ?>


            	</div>
		</div>
		<div class="row" style="padding-top:10px;">
							<?php if ($orders_data['is_tax'] != 1): ?>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="panel panel-default height">
													<div class="panel-heading">ลูกค้า</div>
													<div class="panel-body">
															<strong>ชื่อ: </strong><?php echo $orders_data["name"];?><br>
															<strong>ที่อยู่: </strong><?php echo $orders_data["address"];?><br>
															<strong>เบอร์ติดต่อ: </strong><?php echo $orders_data["tel"];?><br>
															<strong>อีเมล์: </strong><?php echo $orders_data["email"];?>

													</div>
											</div>

								</div>
							<?php endif; ?>

            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            	<?php if($orders_data['is_tax'] == 1 ) { ?>
            		<div class="panel panel-default height">
                        <div class="panel-heading">ที่อยู่สำหรับออกใบกำกับภาษี</div>
                        <div class="panel-body">
                            <strong>ชื่อบริษัท / ร้าน: </strong><?php echo $orders_data["tax_company"];?><br>
                            <strong>ที่อยู่: </strong><?php echo $orders_data["tax_address"];?><br>
                            <strong>เบอร์ติดต่อ: </strong><?php echo $orders_data["tel"];?><br>
                            <strong>อีเมล์: </strong><?php echo $orders_data["email"];?><br>
                            <strong>เลขประจำตัวผู้เสียภาษี: </strong><?php echo $orders_data["tax_id"];?>

                        </div>
                    </div>
		  		<?php } ?>
            	</div>
		</div>


		<?php if($orders_data['customer_id'] != ""){ ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4>สมาชิก Dealer</h4>
				</div>
			</div>
		<?php } ?>
	    <div class="row">
	        <div class="col-md-12">
	            <div class="panel panel-default">
	                <div class="panel-body">
	                    <div class="table-responsive">
	                        <table class="table table-condensed">
	                            <thead>
	                                <tr>
	                                    <td class="product-id">ID สินค้า</td>
	                                    <td class="text-center">รายละเอียด</td>
	                                    <td class="text-center sumpricepernum">ราคาต่อชิ้น</td>
	                                    <td class="text-center">จำนวน</td>
	                                    <td class="text-right">ราคารวม</td>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            <?php foreach ($orders_detail as $value): ?>
	                            	 <tr>
										<td><?php echo $value['sku'] ?></td>

										<td class="">
											<a target="_blank" href="<?php echo $this->config->item('url_img')."product/".$value['slug']; ?>">
												<?php echo $value['product_name'] ?>
											</a>
										</td>
										<td class="text-center">
											<?php echo number_format($value['price'],2) ?>
										</td>
										<td class="text-center"><?php echo $value["quantity"];?></td>
										<td class="text-right"><?php echo number_format($value['total'],2);?></td>
									  </tr>
	                            <?php endforeach ?>

	                            <?php

	                                      $products_price = $orders_data['total'] - $orders_data['shipping_charge'];
	                                      $vat_new =($products_price * 7 )/107;
	                                      $befor_vat = $products_price -  $vat_new;

	                                     ?>

								  <tr>
								  		<td class="highrow"></td>
	                                    <td class="highrow"></td>
	                                    <td class="highrow"></td>
	                                    <td class="highrow text-center sumprice">รวมราคาสินค้า</td>
	                                    <td class="highrow text-right"><?php echo number_format($orders_data['total'] - $orders_data['shipping_charge'],2);?>&nbsp;บาท</td>
	                                </tr>
	                                <tr>
	                                	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center">VAT(7%)</td>
	                                    <td class="emptyrow text-right"><?php echo number_format($vat_new,2)."&nbsp;บาท"; ?></td>
	                                </tr>
	                                <tr>
	                                	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center">ราคาก่อนภาษีมูลค่าเพิ่ม</td>
	                                    <td class="emptyrow text-right">


	                                    <?php echo number_format($befor_vat,2)."&nbsp;บาท"; ?></td>
	                                </tr>
	                                 <tr>
	                                 	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center">ค่าจัดส่ง <?php echo $orders_data['shipping'];?></td>
	                                    <td class="emptyrow text-right"><?php echo number_format($orders_data['shipping_charge'],2);?>&nbsp;บาท</td>
	                                </tr>
	                                 <tr>
	                                 	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center ">รวมราคาสุทธิ</td>
	                                    <td class="emptyrow text-right text-danger"><strong><?php echo number_format($orders_data["total"],2);?>&nbsp;บาท</strong></td>
	                                </tr>

	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	    <div class="row">
	    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    		<div class="panel panel-default">
	    		 <div class="panel-heading">การชำระเงิน</div>
	    		<div class="panel-body">
	    		   <p>การชำระเงินจะสมบูรณ์เมื่อบริษัทได้รับเงินเรียบร้อยแล้ว
	    		   <input type="checkbox" value=""> เงินสด <input type="checkbox" name=""> เช็ค
	    		   <?php if ($orders_data['bank_name'] != "ใบลดหนี้"): ?>
	    		   	<input type="checkbox" name="" checked> โอนเงิน
	    		   <?php else: ?>
	    		   	<input type="checkbox" name=""> โอนเงิน
	    		   <?php endif ?>

	    		   <input type="checkbox" name=""> บัตรเครดิต
	    		   <?php if ($orders_data['bank_name'] == "ใบลดหนี้"): ?>
	    		   	<input type="checkbox" name="" checked> ใบลดหนี้
	    		   <?php else: ?>
	    		   	<input type="checkbox" name=""> ใบลดหนี้
	    		   <?php endif ?>
	    		   </p>
	    		   <p>
	    		   	<?php if ($orders_data['bank_name'] == "ใบลดหนี้"): ?>
	    		   	เลขที่ใบลดหนี้ <?php echo $orders_data['credit_note_docno'];?>
	    		   <?php else: ?>
	    		   ธนาคาร <u><?php echo $orders_data['bank_name'];?></u>
	    		   <?php endif ?>


	    		   วันที่ <u><?php echo $orders_data['inform_date'];?></u>  จำนวนเงิน <u><?php echo number_format($orders_data['amount'],2);?></u>
	    		   </p>
	    		  <div class="row">
	    		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  		<p class="text-center"><br></p>
	    		  		<br>
	    		  		<br>
	    		  		<br>
	    		  		<div class="row">
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		ผู้จ่ายเงิน
			    		  		</p>
	    		  			</div>
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		วันที่
			    		  		</p>
	    		  			</div>
	    		  		</div>

	    		  	</div>
	    		  	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  		<p class="text-center">ในนาม บริษัท ไซเบอร์ แบต จำกัด</p>
	    		  		<br>
	    		  		<br>
	    		  		<br>
	    		  		<div class="row">
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		ผู้รับเงิน
			    		  		</p>
	    		  			</div>
	    		  			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	    		  				<p class="text-center">_______________________<br>
			    		  		วันที่
			    		  		</p>
	    		  			</div>
	    		  		</div>

	    		  	</div>
	    		  </div>
	    		</div>
	    	</div>

			</div>
		</div>
		<div class="row noprint">
			<p class="text-center">
			<button type="button" class="btn btn-primary" onClick="window.print()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> พิมพ์ใบชำระเงิน</button>
			<a class="btn btn-success" href="<?php echo base_url();?>" role="button">ปิดหน้าต่างนี้</a>
			</p>
		</div>
	</div>

<style>

.height {

}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
.table-condensed>tbody>tr>td{
	padding: 2px;
}


.lineover{
  /* Fallback for non-webkit */
  display: -webkit-box;
  /* Fallback for non-webkit */
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.product-id{
	width: 150px;
}
.sumprice{
	width: 150px;
}
.sumpricepernum{
	width: 80px;
}
  @media print {
      a[href]:after {
        content: "" !important;
      }
    }

@media print {
    .noprint {
        display: none;
    }
}
</style>
		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
</body>
</html>
