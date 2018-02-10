<!-- static-right-social-area end-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- error-content-area start-->
                <div class="error-content">
                    <div class="error-img">
                        <img src="<?php echo base_url('theme')?>/img/404.jpg" alt="">
                    </div>
                    <div class="error-content">
                        <h1>หน้านี้ไม่สามารถใช้ได้</h1>
                        <p>ขออภัย แต่ที่อยู่เว็บที่คุณป้อนไม่สามารถใช้ได้อีก</p>
                        <h3>เพื่อค้นหาสิค้าโปรดพิมพ์ชื่อในช่องด้านล่าง</h3>
                        <form role="search" action="<?php echo base_url('search')?>" method="GET">
                            <label>ค้นหาสินค้า:</label>
                            <input type="text" name="search">
                            <button type="submit">
                                <span>ค้นหาสินค้า</span>
                            </button>
                        </form>
                        <div class="buttons"><a href="<?php echo base_url()?>"><span><i class="fa fa-angle-left"></i>หน้าแรก</span></a></div>
                    </div>
                </div>
                <!-- error-content-area end-->
            </div>
        </div>
    </div>
    <!-- logo-brand-area-start -->
    <?php $this->load->view('template/logo'); ?>