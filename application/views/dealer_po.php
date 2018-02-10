<section class="slider-category-area">
    <div class="container" ng-controller="mainCtrl_po">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- breadcrumbs start-->
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="<?php echo base_url(); ?>">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>Dealer</li>
                    </ul>
                </div>
                <!-- breadcrumbs end-->
                <div style="padding-bottom: 30px;"></div>
                <div class="row">
                    <div class="col-sm-3">
                    <?php $this->load->view('template/dealer-menu', $data); ?>
                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div ng-if="sumTotal() > 0 " class="cart table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Unit price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in productItems" ng-if="item.price != '0'">
                                        <td class="product-img">
                                            <a href="<?php echo base_url('product/'.'{{item.slug}}') ?>">
                                                <img src="{{item.img}}" alt="">
                                            </a>
                                        </td>
                                        <td class="cart-description">
                                            <p><a href="<?php echo base_url('product/'.'{{item.slug}}') ?>"><span ng-bind="item.name"></span></a></p>
                                            <small ng-if="item.sku !='' ">SKU : <span ng-bind="item.sku"></small>
                                            <small><span class="label label-success">มีสินค้า</span></small>
                                        <td>
                                            <span class="price" ng-bind="item.price | currency:'฿':0"></span>
                                        </td>
                                        <td class="product-quantity text-center ">
                                            <button type="button" ng-click="updateProduct_click_minus(item.id)"><i class="fa fa-minus"></i></button>
                                            <input type="number" step="1" min="0" ng-model="editValue" ng-change="updateProduct_click(item.id,editValue)" value="{{item.quantity}}" style="width:50px; height: 30px; text-align:center" />
                                            <button type="button" ng-click="updateProduct_click_plus(item.id)"><i class="fa fa-plus"></i></button>
                                        </td>
                                        <td>
                                            <span class="price" ng-bind="item.price * item.quantity | currency:'฿':0"></span>
                                        </td>
                                        <td>
                                            <p class="text-center">
                                                <a href="" ng-click="deleteProduct_click(item.id)"><i class="fa fa-trash-o" style="color:#a94442"></i></a>
                                            </p>                                        
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" rowspan="3"></td>
                                        <td colspan="3">ราคารวมสินค้า</td>
                                        <td colspan="2"><span class="price" ng-bind="sumTotal() | currency:'฿':0"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">ค่าจัดส่งสินค้า</td>
                                        <td colspan="2"><span class="price" ng-bind="90 | currency:'฿':0"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="total"><span>รวมทั้งหมด</span></td>
                                        <td colspan="2"><span class="total-price" ng-bind="sumTotal() + 90 | currency:'฿':0"></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="cart-button">
                            <a href="<?php echo base_url('products') ?>">
                                <i class="fa fa-angle-left"></i> กลับไปเลือกสินค้า
                            </a>
                            <a class="standard-checkout" ng-if="sumTotal() > 0 " href="<?php echo base_url('po_checkout') ?>">
                                <span>
                                   ขอใบเสนอราคา
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div style="height: 100px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div style="padding-bottom: 50px;"></div>
