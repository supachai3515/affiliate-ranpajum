<script type="text/javascript">
//Angular js
app.controller('mainCtrl_po', function($scope,$http) {
    $scope.product_alert = false;
    $scope.is_reservations_check = false;
    $scope.product_alert_text = 'สินค้า 1 ชิ้น ได้ถูกเพิ่มเข้าไปยังตะกร้าสินค้าของคุณ <a class="btn btn-default" href="<?php echo base_url("cart") ?>" role="button">ดูตะกร้าสินค้า</a>';

    $scope.productItems = [{
            id: '0',
            sku: '0',
            name: '',
            img: '',
            price: 0,
            quantity: 0,
            rowid: '',
            model : '',
            brand   : '',
            is_reservations   : 0,
            type   : ''
    }];

    $scope.sumTotal = function() {
        var total = 0;
        for (var i = 0; i < $scope.productItems.length; i++) {
            var product = $scope.productItems[i];
            total += (product.price * product.quantity);
        }
        return total;
    }

    $scope.sumItems = function() {
        var quantity = 0;
        for (var i = 0; i < $scope.productItems.length; i++) {
            var product = $scope.productItems[i];
            quantity = quantity + product.quantity;
        }
        return parseInt(quantity, 10);
    }

    $scope.addProduct_click = function(productId) {
          // Simple GET request example:
        $http({
            method: 'GET',
            url: '<?php echo base_url()."cart/add_item/";?>'+ productId

        }).success(function(data) {
            $scope.product_alert = true;
             $scope.getOrder();
       });
    }

     $scope.updateProduct_click = function(id, editValue) {
        // Simple GET request example:
        $http({
            method: 'GET',
            url: '<?php echo base_url()."dealer_po/update_item/";?>'+ id + '/' + editValue
        }).success(function(data) {
             $scope.getOrder();
            $scope.deleteResult = data;
        });
    }

    $scope.updateProduct_click_plus = function(id) {
        var qty = 0;

         angular.forEach($scope.productItems, function(value, key){
             if(value.id == id)
             {
                qty =value.quantity +1;
             }

         });
         if(qty>0){
             $http({
                method: 'GET',
                url: '<?php echo base_url()."dealer_po/update_item/";?>'+ id + '/' + qty
            }).success(function(data) {
                 $scope.getOrder();
                $scope.deleteResult = data;
            });
         }

    }

     $scope.updateProduct_click_minus = function(id) {

       var qty = 0;

         angular.forEach($scope.productItems, function(value, key){
             if(value.id == id)
             {
                qty =value.quantity - 1;
             }

         });
         if(qty>0){
             $http({
               method: 'GET',
               url: '<?php echo base_url()."dealer_po/update_item/";?>'+ id + '/' + qty
            }).success(function(data) {
                 $scope.getOrder();
                $scope.deleteResult = data;
            });
         }

    }


    $scope.deleteProduct_click = function(id) {

        // Simple GET request example:
        $http({
            method: 'GET',
            url: '<?php echo base_url()."dealer_po/delete_item/";?>'+ id
        }).success(function(data) {
             $scope.getOrder();
            //$scope.deleteResult = data;
        });
    }

    $scope.getOrder = function() {

        // Simple GET request example:
        $http({
            method: 'GET',
            url: '<?php echo base_url()."dealer_po/get_cart";?>'
        }).success(function(data) {

            $scope.productItems = [{
                id: '0',
                sku: '0',
                slug: '',
                name: '',
                img: '',
                price: 0,
                quantity: 0,
                rowid: '',
                model : '',
                brand   : '',
                is_reservations   : 0,
                type   : ''
            }];

            $scope.dataResult = data;
            for (var i = 0; i < $scope.dataResult.length; i++) {
                 var product = $scope.dataResult[i];
                $scope.productItems.push({
                    id: product.id,
                    sku: product.sku,
                    slug: product.slug,
                    name: product.name,
                    img: product.img,
                    price: product.price,
                    quantity: product.qty,
                    rowid: product.rowid,
                    model : product.model,
                    brand : product.brand,
                    is_reservations: product.is_reservations,
                    type : product.type
                });
                if(product.is_reservations=="1"){
                    $scope.is_reservations_check = true;
                }

            }
            $scope.productItems.slice(0, 1);
        });

    }

     $scope.caltax = function() {
        var sumtex = 0;
        if ($scope.isTax) {
            sumtex = (($scope.sumTotal()) * 7) / 107;
        }
        return sumtex;
    }

    $scope.caltaxReceipt = function(val) {

        if (val) {
            $scope.isTax = true;

        } else {
            $scope.isTax = false;

        }
    }



    //init get
     $scope.getOrder();

});
</script>
