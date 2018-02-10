<script type="text/javascript">

	app.controller("receive", function($scope, $http, $uibModal, $log) {

	  $scope.product_receive = [];
	  <?php if (isset($receive_data['id'])): ?>

	  	 $scope.intireceive = function() {

		           $http({
		            method: 'POST',
		            url: '<?php echo base_url('receive/get_receive_detail');?>',
		             headers: {
		           'Content-Type': 'application/x-www-form-urlencoded'
		         },

		         data: { id : "<?php echo $receive_data['id']; ?>"}

		        }).success(function(data) {
		             var product_receive_re = data;


		             angular.forEach(product_receive_re,function(value,key){

		             		var product_receive = {
	                      	  	id: value.product_id,
	                      		sku: value.sku,
	                      		name: value.name,
	                           qty: value.qty,
	                          price: value.price,
	                          vat: value.vat,
	                          total: value.total,
	                      };

	                 	$scope.product_receive.push(product_receive);

			        });

		       });

	       }

		$scope.intireceive();
	  <?php endif ?>

	  $scope.addReceive = function() {
	  	 try {

	      if ($scope.sku.length > 0 && $scope.qty > 0 && $scope.price > 0) {
	          $scope.msgError = "";

	          $http({
	              method: 'POST',
	              url: '<?php echo base_url('receive/get_product');?>',
	              headers: {
	                  'Content-Type': 'application/x-www-form-urlencoded'
	              },

	              data: {
	                  sku: $scope.sku
	              }

	          }).success(function(data) {

	              var product_receive_re = data;

	              try {

	                  if (product_receive_re["sku"].length > 0) {
	                      var vat_p = 0;
	                      if ($scope.is_vat_rececive) {
	                          vat_p = parseInt(($scope.price * $scope.qty) * 7 /107);
	                      }

	                      var product_receive = {
	                      	  id: product_receive_re["id"],
	                          sku: product_receive_re["sku"],
	                          name: product_receive_re["name"],
	                          qty: $scope.qty,
	                          price: $scope.price,
	                          vat: vat_p,
	                          total: $scope.qty * $scope.price,
	                      };

	                      if($scope.product_receive.length > 0)
	                      {
	                      	var isdup = 0;
	                      	 angular.forEach($scope.product_receive, function(value,index) {
		                      	if(value.sku == product_receive_re["sku"] ){
		                      		isdup = 1;
		                      		$scope.msgError = "ข้อมูลสินค้า "+product_receive_re["sku"] +" : "+product_receive_re["name"]+" ***ซ้ำ***  กรุณาลบแล้วเพิ่มใหม่";
		                      	}

							  });

	                      	 if(isdup == 0){
	                      	 		$scope.product_receive.push(product_receive);
	                      	 }
	                      }
	                      else{
	                      	$scope.product_receive.push(product_receive);
	                      }

	                  }

	              } catch (err) {
	                  $scope.msgError = "ไม่มีข้อมูลสินค้า";
	              }
	          });

	      }

	    } catch (err) {
	          $scope.msgError = "กรุณากรอกข้อมูลให้ครบ";
	    }


	  };

	   $scope.removeProduct = function(index){
	    $scope.product_receive.splice(index, 1);
	   };


		$scope.getTotalReceive = function(){
		    var total = 0;
		    for(var i = 0; i < $scope.product_receive.length; i++){
		        var product = $scope.product_receive[i];
		        total += (parseFloat(product.price) * parseFloat(product.qty));
		    }
		    return total;
		}
		$scope.getVatReceive = function(){
		    var total = 0;
		    for(var i = 0; i < $scope.product_receive.length; i++){
		        var product = $scope.product_receive[i];
		        total += (parseFloat(product.vat));
		    }
		    return total;
		}

		$scope.getQtyReceive = function(){
		    var total = 0;
		    for(var i = 0; i < $scope.product_receive.length; i++){
		        var product = $scope.product_receive[i];
		        total += (parseFloat(product.qty));
		    }
		    return total;
		}




		 $scope.open = function (product_id_p,qty_p,receive_id_p) {

		    var modalInstance = $uibModal.open({
		      animation: $scope.animationsEnabled,
		      templateUrl: 'myModalContent.html',
		      controller: 'ModalInstanceCtrl',
		      size: "",
		      resolve: {
		        items: function () {
		        	var re_pa = {
		        		product_id : product_id_p,
		        		qty : qty_p,
		        		receive_id : receive_id_p,
		        	}
		          return re_pa;
		        }
		      }
		    });


		    $scope.animationsEnabled = true;
		    modalInstance.result.then(function (selectedItem) {
		      $scope.selected = selectedItem;
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };

		  $scope.toggleAnimation = function () {
		    $scope.animationsEnabled = !$scope.animationsEnabled;
		  };


	});

	angular.module('ui.bootstrap').controller('ModalInstanceCtrl', function ($scope,$http, $uibModalInstance, items) {
			var re_pa = items ;
	             $http({
	            method: 'POST',
	            url: '<?php echo base_url('receive/get_product_serial');?>',
	             headers: {
	           'Content-Type': 'application/x-www-form-urlencoded'
	         },

	         data: { product_id : re_pa.product_id,
	         		receive_id : re_pa.receive_id,
	         }

	        }).success(function(data) {
	            $scope.product_serial = data;
	            var count_p = $scope.product_serial.length;
	            for (i = 0; i < re_pa.qty - count_p; i++) {

	            	 var product_serial = {
	                      	  sku: "",
	                      	  line_number : i+1,
	                          product_id: re_pa.product_id,
	                          receive_id: re_pa.receive_id,
	                          name: "",
	                          serial_number: "",
	                          create_date: "",
	                          modified_date: "",

	                      };

	            	$scope.product_serial.push(product_serial);
				}

	            //console.log(data);
	       });


	  $scope.ok = function () {
	    $uibModalInstance.close($scope.selected.item);
	  };

	  $scope.cancel = function () {
	    $uibModalInstance.dismiss('cancel');
	  };

	    $scope.removeSerial = function(index){
	    $scope.product_serial.splice(index, 1);
	   };

	    $scope.save_serial = function(index){
	    	$scope.txtError ="";
	    	$scope.txtSuccess ="";

	    	var ch_ = true;


	    	 angular.forEach($scope.product_serial, function(value,index) {
	    	 	try{

	    	 		if($scope.product_serial.serial_number[value.line_number].trim() == "" ){
	    	 			 ch_ = false;
              			console.log($scope.product_serial.serial_number[value.line_number]);

              		} else{

              			 $scope.product_serial[index].serial_number = $scope.product_serial.serial_number[value.line_number].trim();
              		}

	    	 	 } catch (err) {
	    	 	 	  console.log(err.message);
	                  ch_ = false;
	             }

			  });

	    	 if(ch_ == true){

	    	 		var ch_dup = true;
	    	 		 angular.forEach($scope.product_serial, function(value,index) {

	    	 		 	var i = 0;
	    	 		 	angular.forEach($scope.product_serial, function(value_d,index) {
			    	 		if(value.serial_number == value_d.serial_number){
								i++;
								if(i > 1){
									ch_dup = false;
									$scope.txtError = $scope.txtError + value.serial_number  +" ซ้ำ , ";
								}
		              		}

						});

					 });

    	 		 	if(ch_dup ==true) {

    	 		 		try {
    	 		 				$scope.txtError = "....";

    	 		 				$http({
						            method: 'POST',
						            url: '<?php echo base_url('receive/save_serial');?>',
						             headers: {
						           'Content-Type': 'application/x-www-form-urlencoded'
						         },
						         	data: $scope.product_serial

						        }).success(function(data) {

						        	$scope.txtError = "";
						           var  result = data;

						           if(result.is_error) {
						           		$scope.txtError = result.message;
						           }
						           else{
						           	$scope.txtSuccess = result.message;
						           }
						       });

    	 		 		}
    	 		 		catch (err) {
			    	 	 	  console.log(err.message);
			                  $scope.txtError = "ข้อมูลซ้ำ";
			             }



    	 		 	}

	    	 }
	    	 else{
	    	 	$scope.txtError ="กรุณากรอก serial number ให้ครบ";
	    	 }


	   };

	});


</script>
