<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>ใบแจ้งชำระเงิน เลขที่ใบสั่งซื้อ <?php echo $order['id']." ".$order["name"];?> </title>

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
            		<img src="<?php echo base_url('theme');?>/img/logo/logo.png" style="width: 200px"/>
            		<h4><?php echo $this->config->item('short_sitename')?></h4>
			  		 บริษัท ไซเบอร์ แบต จำกัด 2963 ซ.ลาดพร้าว <br>
			  		 101/2 ถ.ลาดพร้าว คลองจั่น บางกะปิ กทม. 10310<br>

            	</div>
            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
        			
                <h2>เลขที่ใบสั่งซื้อ #<?php echo  $order['id'];?> </h2>
                <strong>วันที่ออก <?php echo $order['date']?></strong><br/>
				กรุณาชำระเงินภายใน 3 วัน 
                   
					
            	</div>
		</div>
		<div class="row" style="padding-top:10px;">

            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            		<div class="panel panel-default height">
                        <div class="panel-heading">ที่อยู่สำหรับจัดส่งสินค้า</div>
                        <div class="panel-body">
                            <strong>ชื่อ: </strong><?php echo $order["name"];?><br>
                            <strong>ที่อยู่: </strong><?php echo $order["address"];?><br>
                            <strong>เบอร์ติดต่อ: </strong><?php echo $order["tel"];?><br>
                            <strong>อีเมล์: </strong><?php echo $order["email"];?>

                        </div>
                    </div>

            	</div>
            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            	<?php if($order['is_tax'] == 1 ) { ?>
            		<div class="panel panel-default height">
                        <div class="panel-heading">ที่อยู่สำหรับออกใบกำกับภาษี</div>
                        <div class="panel-body">
                            <strong>ชื่อ: </strong><?php echo $order["name"];?><br>
                            <strong>ชื่อบริษัท / ร้าน: </strong><?php echo $order["tax_company"];?><br>
                            <strong>ที่อยู่: </strong><?php echo $order["tax_address"];?><br>
                            <strong>เบอร์ติดต่อ: </strong><?php echo $order["tel"];?><br>
                            <strong>อีเมล์: </strong><?php echo $order["email"];?><br>
                            <strong>เลขประจำตัวผู้เสียภาษี: </strong><?php echo $order["tax_id"];?>

                        </div>
                    </div>
		  		<?php } ?>
            	</div>
		</div>


		<?php if($order['customer_id'] != ""){ ?> 
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
	                            <?php foreach ($order_detail as $value): ?>
	                            	 <tr>
										<td><?php echo $value['sku'] ?></td>

										<td class="">
											<a target="_blank" href="<?php echo base_url("product/".$value['slug']) ?>">
												<?php echo $value['name'] ?>
											</a>
										</td>
										<td class="text-center">
											<?php echo number_format($value['price_order'],2) ?>
										</td>
										<td class="text-center"><?php echo $value["quantity"];?></td>
										<td class="text-right"><?php echo number_format($value['price_order']*$value["quantity"],2);?></td>
									  </tr>
	                            <?php endforeach ?>

								  <tr>
								  		<td class="highrow"></td>
	                                    <td class="highrow"></td>
	                                    <td class="highrow"></td>
	                                    <td class="highrow text-center sumprice">รวมราคาสินค้า</td>
	                                    <td class="highrow text-right"><?php echo number_format($order['total'] - $order['shipping_charge'],2);?>&nbsp;บาท</td>
	                                </tr>
	                                <tr>
	                                	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center"><?php if($order["is_tax"]==0){echo "";}else{echo "VAT(7%)";} ?></td>
	                                    <td class="emptyrow text-right"><?php if($order["is_tax"]==0){echo "";}else{echo number_format($order["vat"],2)."&nbsp;บาท";} ?></td>
	                                </tr>
	                                 <tr>
	                                 	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center">ค่าจัดส่ง</td>
	                                    <td class="emptyrow text-right"><?php echo number_format($order['shipping_charge'],2);?>&nbsp;บาท</td>
	                                </tr>
	                                 <tr>
	                                 	<td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-center ">รามราคาสุทธิ</td>
	                                    <td class="emptyrow text-right text-danger"><strong><?php echo number_format($order["total"],2);?>&nbsp;บาท</strong></td>
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
	    		   <?php echo $this->config->item('payment_transfer') ?>
	    		</div>
	    	</div>
	        	
			</div>
		</div>
		<div class="row">
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
.fix-container{
	width: 878px;
}
.lineover{
  /* Fallback for non-webkit */
  display: -webkit-box;
  /* Fallback for non-webkit */
  -webkit-line-clamp: 1;
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
</style>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.0/angular.min.js"></script>
		<script type="text/javascript">
			var app = angular.module('myApp', []);
			app.controller('mainCtrl', function($scope, $http) {

				$scope.orderSenmailInit = function() {

				    <?php if(isset($_GET["Sendmail"]) && $order["is_sendmail"]== 0 ){?>
			            $http({
			            method: 'GET',
			            url: '<?php echo base_url()."/inc/order_sendmail.php?order=".$_GET["Sendmail"];?>',
			            headers: {
			            'Content-Type': 'application/x-www-form-urlencoded'
			            },

			            }).success(function(data) {
			            console.log(data);
			            });
		            <?php } ?>
  
		       	}

			});

		</script>
</body>
</html>