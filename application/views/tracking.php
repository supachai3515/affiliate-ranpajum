
<section class="contuct-us-form-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                 <!-- breadcrumbs start-->
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>Tracking</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
            </div>
        </div>
        <div class="" style="padding-top:30px;"></div>
        <div class="row">
                <div class="col-sm-4">
                    <div class="price-range">
                        <h4 class="text-center"><i class="fa fa-truck"></i> Tracking Number</h4>
                        <div class="panel-group" id="accordian" ng-init="getOrderTracking()">
                            <div class="panel panel-default">
                                <div class="search_box text-center" style="padding: 20px;">
                                    <form ng-submit="getOrderTracking()">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="ค้นหาใบสั่งซื้อ" ng-model="txtSearchTracking" required="required">
                                            <div class="input-group-btn">
                                                <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <table class="table table-hover">
                                    <tbody>
                                        <tr ng-repeat="order in orderTracking">
                                            <td class="text-center"><i class="fa fa-list-alt"></i>
                                                <br> <strong ng-bind="order.id"></strong></td>
                                            <td><span ng-bind="order.name"></span>
                                                <br>
                                                <span ng-bind="order.trackpost" class="text-primary"></span>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--/tracking-->
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo base_url('theme'); ?>/img/thaipost.jpg" alt="ALT NAME" class="img-responsive img-rounded" />
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <div class="caption">
                                <h3>ไปรษณีย์ไทย</h3>
                                <p><strong>ชำระเงินก่อน 12.00น. ส่งสินค้าออกวันเดียวกัน หลังจากนั้น ส่งสินค้าออกวันถัดไป  </strong></p>
                                <div class="button-exclusive">
                                        <a href="http://track.thailandpost.co.th/tracking/default.aspx"  target="_blank">
                                            <span>ไปรษณีย์ไทย</span>
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo base_url('theme'); ?>/img/kerry.jpg" alt="ALT NAME" class="img-responsive img-rounded" />
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <div class="caption">
                                <h3>เคอรี่ เอ็กซ์เพรส (ประเทศไทย)</h3>
                                <p><strong> ชำระเงินก่อน 14.00น. ส่งสินค้าออกในวันเดียวกัน หลังจากนั้น ส่งสินค้าออกวันถัดไป </strong></p>
                                <p>

                                <div class="button-exclusive">
                                       <a href="http://th.ke.rnd.kerrylogistics.com/shipmenttracking/"  target="_blank">
                                            <span> เคอรี่ เอ็กซ์เพรส (ประเทศไทย)</span>
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                     <hr/>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <img src="https://www.tnt.com/content/dam/tnt_express_media/express-master/admin/img/tnt-logo.svg" alt="ALT NAME" class="img-responsive img-rounded" />
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <div class="caption">
                                <h3>ทีเอ็นที (TNT)</h3>
                                <p><strong>ชำระเงินก่อน 16.00น. ส่งสินค้าออกวันเดียวกัน หลังจากนั้น ส่งสินค้าออกวันถัดไป   </strong></p>

                                <p>

                                <div class="button-exclusive">
                                        <a href="https://www.tnt.com/express/th_th/site/home.html"target="_blank">
                                            <span> ทีเอ็นที (TNT)</span>
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>


                                </p>
                            </div>
                        </div>
                    </div>
                     <hr/>
                </div>
            </div>
    </div>
</section>
<div style="padding-top: 50px;"></div>
