<!-- static-right-social-area end-->
<section class="slider-category-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-md-3">
            <?php 
                 //left-sidebar
                 $this->load->view('template/left-sidebar');
            ?>
            </div>
            <div class="col-sm-9 col-lg-9 col-md-9">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- breadcrumbs start-->
                        <div class="breadcrumb">
                            <ul>
                                <li>
                                    <a href="<?php echo base_url(); ?>">Home</a>
                                    <i class="fa fa-angle-right"></i>
                                </li>
                                <li>สินค้า</li>
                            </ul>
                        </div>
                        <!-- breadcrumbs end-->
                    </div>
                </div>
                <?php if (isset($title_tag)): ?>
                <div class="head-search">

                    <div class="product-description">
                        <h1 class="text-center product-name">
                            <?php echo $title_tag; ?>
                        </h1>
                        <div>
                        <?php if (isset($detail['description'])): ?>
                            <?php if ($detail['description']): ?>
                                 <?php echo $detail['description']; ?>
                            <?php endif ?>
                        <?php endif ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
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
                <div style="padding-bottom: 20px;"></div>
                <div class="row">
                    <div class="tab-content">
                         <?php $this->load->view('template/product-item',$product_list); ?>
                    </div>
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
                <!-- pagination-end -->
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('template/logo'); ?>
