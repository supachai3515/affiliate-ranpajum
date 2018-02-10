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
                        <div ng-if="sumTotal() > 0 " class="commerce">
                    <div class="cart table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Avail.</th>
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
                                        <small ng-if="item.sku !='' ">sku: <span ng-bind="item.sku"></small>
                                    </td>
                                    <td>
                                        <span class="label-success">มีสินค้า</span>
                                    </td>
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
                                        <a href="" ng-click="deleteProduct_click(item.id)"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" rowspan="3"></td>
                                    <td colspan="3">ราคารวมสินค้า</td>
                                    <td colspan="2"><span class="price" ng-bind="sumTotal() | currency:'฿':0"></span></td>
                                </tr>
                                <tr ng-if="caltax() > 1">
                                    <td colspan="3">ภาษีมูลค่าเพิ่ม 7%</td>
                                    <td colspan="2"><span class="price" ng-bind="caltax() | currency:'฿':0"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">ค่าจัดส่งสินค้า</td>
                                    <td colspan="2"><span class="price" ng-bind="90 | currency:'฿':0"></span></td>
                                </tr>
                                <tr>
                                    <td ng-if="caltax() > 1" colspan="5" class="total"><span>รวมทั้งหมด</span></td>
                                     <td ng-if="caltax() < 1" colspan="3" class="total"><span>รวมทั้งหมด</span></td>
                                    <td colspan="2"><span class="total-price" ng-bind="( (90+sumTotal() )+caltax() ) | currency:'฿':0"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="head-search">

                        <div class="product-description">
                            <h1 class="text-center product-name">
                               
                            </h1>
                        </div>
                    </div>


                     <form class="form-horizontal form-area" ng-submit="ckeckoutSubmit()"  name="form1" method="post" action="<?php echo base_url('po_checkout/save'); ?>" OnSubmit="return chkSubmit();">
                               <h2 class="form-heading"> กรุณากรอกรายละเอียดที่อยู่ เพื่อรับสินค้าจากเว็บไซต์</h2>
                              <fieldset>

                              <!-- Multiple Radios -->
                              <div class="form-group ">
                                <label class="col-md-4 control-label" for="purchase">รูปแบบการออกใบเสร็จ</label>
                                <div class="col-md-4">

                                 <label><input type="checkbox" name="purchase" id="p2" ng-change="caltaxReceipt(tax)" ng-model="tax" /> ใบกำกับภาษี</label><br />

                                </div>
                              </div>

                              <!-- Text input-->
                              <div class="form-group" ng-if="caltax() > 1">
                                <label class="col-md-4 control-label" for="company">ชื่อบริษัท / ร้าน</label>  
                                <div class="col-md-4">
                                <?php if( $isUsername == 1) {?>
                                  <input id="company" name="company" type="text" placeholder="ชื่อบริษัท / ร้าน" value="<?php echo $username_login["Company"]; ?>" class="form-control input-md">
                                <?php } else { ?>
                                  <input id="company" name="company" type="text" placeholder="ชื่อบริษัท / ร้าน" class="form-control input-md">
                                <?php } ?>
                                  
                                </div>
                              </div>


                              <!-- Textarea -->
                              <div class="form-group" ng-if="caltax() > 1">
                                <label class="col-md-4 control-label" for="purchase_address">ชื่อ / ที่อยู่สำหรับออกใบกำกับภาษี</label>
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <textarea class="form-control" name="purchase_address"><?php echo trim($username_login["AVat"]);?></textarea>
                                  <?php } else { ?>
                                      <textarea class="form-control" name="purchase_address"></textarea>
                                  <?php } ?> 
                                </div>
                              </div>

                              <!-- Text input-->
                              <div class="form-group" ng-if="caltax() > 1">
                                <label class="col-md-4 control-label" for="IDCARD">เลขประจำตัวผู้เสียภาษี</label>  
                                <div class="col-md-4">
                                <?php if( $isUsername == 1) {?>
                                  <input id="IDCARD" name="IDCARD" type="text" placeholder="เลขประจำตัวผู้เสียภาษี" value="<?php echo $username_login["Nid"]; ?>" class="form-control input-md">
                                <?php } else { ?>
                                  <input id="IDCARD" name="IDCARD" type="text" placeholder="เลขประจำตัวผู้เสียภาษี" class="form-control input-md">
                                <?php } ?>
                                  
                                </div>
                              </div>


                              <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="textinput">ชื่อผู้รับ</label>  
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <input type="text" name="txtName"  placeholder="ชื่อผู้รับ" class="form-control input-md" required="required" 
                                      value="<?php echo $username_login["FullName"] ." ". $username_login["LastName"]; ?>"/>
                                  <?php } else { ?>
                                      <input type="text" name="txtName"  placeholder="ชื่อผู้รับ" class="form-control input-md" required="required" 
                                  value=""/>
                                  <?php } ?>
                                </div>
                              </div>

                              <!-- Textarea -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="textarea">ที่อยู่จัดส่ง</label>
                                <div class="col-md-4"> 
                                  <?php if( $isUsername == 1) {?>
                                      <textarea class="form-control" name="txtAddress"><?php echo trim($username_login["ARecieve"]);?></textarea>
                                  <?php } else { ?>
                                      <textarea class="form-control" name="txtAddress"></textarea>
                                  <?php } ?>
                                </div>
                              </div>

                              <div class="form-group">
                                <label class="col-md-4 control-label" for="passwordinput">เบอร์โทร</label>
                                <div class="col-md-4">
                                  <?php if( $isUsername == 1) {?>
                                      <input type="text" name="txtTel" id="txtTel" required="required" class="form-control input-md" placeholder="เบอร์โทร" maxlength="12" value="<?php echo $username_login["Mobile"];?>" />
                                  <?php } else { ?>
                                      <input type="text" name="txtTel" id="txtTel" class="form-control input-md" placeholder="เบอร์โทร" required="required" maxlength="12" value="" />
                                  <?php } ?>
                                </div>
                              </div>

                              <!-- Select Basic -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="selectbasic">เลือกการจัดส่ง</label>
                                <div class="col-md-4">
                                  <select id="txtTransport" name="txtTransport" class="form-control">
                                    <option>EMS</option>
                                    <option>SDS(ภาคใต้)</option>
                                    <option>Kerry Express(ทั่วประเทศ)</option>
                                    <option>สยามเฟิร์ส(ภาคเหนือ)</option>
                                  </select>
                                </div>
                              </div>

                              <!-- Text input-->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="txtEmail">อีเมล์</label>  
                                <div class="col-md-4">
                                <?php if( $isUsername == 1) {?>
                                      <input type="text" name="txtEmail" id="txtEmail" required="required "placeholder="อีเมล์"  class="form-control input-md" value="<?php echo $username_login["Email"];?>" />
                                  <?php } else { ?>
                                      <input id="txtEmail" name="txtEmail" type="email" placeholder="อีเมล์" class="form-control input-md" required="required">
                                  <?php } ?>
                                </div>
                              </div>

                              <!-- Button -->
                              <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton"></label>
                                <div class="col-md-4">
                                <div class="form-content">
                                  <button type="submit" name="Submit">
                                    <span>
                                      ยืนยันใบเสนอราคา
                                    </span>
                                  </button>
                                </div>
                                  
                                  <div class="form-group" ng-if="isProscess==true">
                                    <hr>
                                        <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" style="width:70%"></div>
                                    </div>                  
                                  </div>
                                  <h4 class="text-success" ng-bind="message_prosecss"></h4>

                                </div>
                              </div>
                              </fieldset>
                          </form>
                </div>

                <div ng-if="sumTotal() < 1 " class="commerce">
                  <p class="label label-info">คุณไม่มีสินค้าในตะกร้า</p>
                           <div class="cart-button">
                                <a href="<?php echo base_url('products') ?>">
                                    <i class="fa fa-angle-left"></i> กลับไปเลือกสินค้า
                                </a>
        
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
