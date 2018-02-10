<section class="contuct-us-form-area">
    <div class="container">
        <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="area-title">
                <h1>ซ่อมโน๊ตบุ๊ค รับซ่อม Macbook iMac เปลี่ยนจอ iphone ipad <small> บริการส่งมาซ่อม-ส่งกลับ</small></h1>
            </div>
        </div>
        </div>
        <div style="padding-top: 20px;"></div>
        <div class="row">
	        <div class="col-md-12">
		        <div class="well well-lg">
		        	<ul class="list-group">
		        		<li class="list-group-item"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ส่งเครื่องมาให้ทางร้าน</li>
		        		<li class="list-group-item"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ทางร้านจะตรวจสอบอาการ คำนวนค่าใช้จ่ายและแจ้งกลับไปทางลูกค้า</li>
		        		<li class="list-group-item"><i class="fa fa-hand-o-right" aria-hidden="true"></i> โอนเงินค่าซ่อม</li>
		        		<li class="list-group-item"><i class="fa fa-hand-o-right" aria-hidden="true"></i> เมื่อซ่อมเสร็จแล้วทางร้านส่งกลับไปยังลูกค้า</li>
		        	</ul>
		        </div>
	        </div>
        </div>

        <!-- search-box start -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div style="margin-top: -10px">
                    <form class="navbar-form ng-pristine ng-valid" role="search" action="<?php echo base_url('searchfix')?>" method="GET">
                        <div class="input-group search-form">
                            <input type="text" class="form-control" placeholder="ค้นหารายการซ่อม" name="search" style="font-size: 18px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php if (isset($title_tag)): ?>
        <div class="page-header">
          <h2 class="text-center">ผลการค้นหา <small><?php echo '"'.$title_tag.'"' ?> </small></h2>
        </div>
        <?php endif ?>
        <!-- search-box end -->
        <?php if (isset($links_pagination)): ?>
           <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="toolbar">
                    <div class="pagination-area">
                        <?php echo $links_pagination ?>
                    </div>
                </div>
            </div>
        </div> 
        <?php endif ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th>รายละเอียด</th>
                        <th>ระยะเวลา</th>
                        <th>ราคาโดยประมาณ</th>
                        <th>อับเดตวันที่</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($fix_list as $row): ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><?php echo $row['duration'] ?></td>
                    <td><?php echo $row['price'] ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row['modified_date'])); ?></td>
                </tr>
                
            <?php endforeach ?>
                    
                </tbody>
            </table>
        </div>
        <?php if (isset($links_pagination)): ?>
           <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="toolbar">
                    <div class="pagination-area">
                        <?php echo $links_pagination ?>
                    </div>
                </div>
            </div>
        </div> 
        <?php endif ?>
<!--
        <div class="row">
        	<div class="col-md-12">

        	<div class="fb-comments" data-href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>"  data-order-by="social" data-numposts="20" data-width="100%"></div>
			</div>
    	</div>
        -->
</section>
<div style="padding-top: 50px;"></div>
<div id="fb-root"></div>
