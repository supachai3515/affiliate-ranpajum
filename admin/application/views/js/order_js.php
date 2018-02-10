<script type="text/javascript">

	app.controller("order", function($scope, $http, $uibModal, $log) {

		 $scope.open = function (product_id_p,qty_p,order_id_p) {
		  	
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
		        		order_id : order_id_p,
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

		  $scope.product_credit_note = [];
		  $scope.items = { credit_note_id : '',
 		  				  credit_note_docno : ''
 		  				};

			<?php if (isset($orders_data['credit_note_id'])): ?>

			  	 $scope.items = { credit_note_id : "<?php echo $orders_data['credit_note_id'] ?>",
		 		  				  credit_note_docno : "<?php echo $orders_data['credit_note_docno'] ?>",
								};
			<?php endif ?>
 	
		 $scope.open_credit = function () {
		  	
		    var modalInstance = $uibModal.open({
		      animation: $scope.animationsEnabled,
		      templateUrl: 'myModalContent_credit.html',
		      controller: 'ModalInstanceCtrl_credit',
		      size: "",
		      resolve: {
		        items: function () {
		          return $scope.items;
		        }
		      }
		    });


		    $scope.animationsEnabled = true;
		    modalInstance.result.then(function (selectedItem) {
		     $scope.items = selectedItem;
		     $scope.credit_note_id = $scope.items.credit_note_id;
		     $scope.credit_note_docno = $scope.items.credit_note_docno;

		     	console.log($scope.items);
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };

		  $scope.toggleAnimation = function () {
		    $scope.animationsEnabled = !$scope.animationsEnabled;
		  };



	});



		angular.module('ui.bootstrap').controller('ModalInstanceCtrl_credit', function ($scope,$http, $uibModalInstance, items) {
		  $scope.items = items;
		  $scope.order_data;

		  $scope.ok = function () {
		    $uibModalInstance.close($scope.items);
		  };

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};

		$scope.searchOrder = function () {
			if($scope.search_order.length > 0){

				$http({
		            method: 'POST',
		            url: '<?php echo base_url('orders/get_search_credit_note');?>',
		            headers: { 'Content-Type': 'application/x-www-form-urlencoded'
		         }, data: { search : $scope.search_order }
		           
		        }).success(function(data) {
		             var order_data = data;
 					$scope.order_data = order_data;
				});

			}
			
		};


		$scope.selectOrder = function (credit_note_id,credit_note_docno){

			$scope.items.credit_note_id = credit_note_id;
 		  	$scope.items.credit_note_docno = credit_note_docno;
			$uibModalInstance.close($scope.items);
		};


	});




	angular.module('ui.bootstrap').controller('ModalInstanceCtrl', function ($scope,$http, $uibModalInstance, items) {
			var re_pa = items ;
	             $http({
	            method: 'POST',
	            url: '<?php echo base_url('orders/get_product_serial');?>',
	             headers: {
	           'Content-Type': 'application/x-www-form-urlencoded'
	         },

	         data: { product_id : re_pa.product_id,
	         		order_id : re_pa.order_id,
	         }
	           
	        }).success(function(data) {
	            $scope.product_serial = data;
	            var count_p = $scope.product_serial.length;
	            for (i = 0; i < re_pa.qty - count_p; i++) { 

	            	 var product_serial = {
	                      	  sku: "",
	                      	  line_number : i+1,
	                          product_id: re_pa.product_id,
	                          order_id: re_pa.order_id,
	                          name: "",
	                          serial_number: "",
	                          create_date: "",
	                          modified_date: "",
	                          modified_date_order: "",
	     
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
						            url: '<?php echo base_url('orders/save_serial');?>',
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


	$(document).on('ready', function() {
	    $("#image_field").fileinput({
	    	language: "th",
	    	<?php if($orders_data['image_slip_customer']!=""){?>
		        initialPreview: [
		            '<img src="<?php echo $this->config->item('url_img').$orders_data['image_slip_customer'];?>" class="file-preview-image">'
		        ],
	        <?php } ?>
	        overwriteInitial: false,
	        maxFileSize: 2000,
	    });
	    $("#image_field1").fileinput({
	    	language: "th",
	    	<?php if($orders_data['image_slip_own']!=""){?>
		        initialPreview: [
		            '<img src="<?php echo $this->config->item('url_img').$orders_data['image_slip_own'];?>" class="file-preview-image">'
		        ],
	        <?php } ?>
	        overwriteInitial: false,
	        maxFileSize: 2000,
	    });

	});

  $('#datepicker').datepicker({
	    format: "yyyy-mm-dd",
	    language: "th",
	    autoclose: true,
	    todayHighlight: true,
	    todayBtn: true,
	    orientation: "top auto",
	    enableOnReadonly : true
	});

	$('#timepicker1').timepicker({
        showMeridian: false,
        defaultTime: false

    });

</script>


	