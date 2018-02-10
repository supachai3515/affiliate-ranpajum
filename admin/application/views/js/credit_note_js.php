<script type="text/javascript">

	app.controller("credit_note", function($scope, $http, $uibModal, $log) {

	$scope.product_credit_note = [];
		 $scope.items = { return_id : '',
 		  				  order_id : '',
 		  				  serial : '' ,
 		  				  product_id : '' ,
							  product_name : '',
						    product_price : '' };

	<?php if (isset($credit_note_data['id'])): ?>

	  	 $scope.items = { return_id : "<?php echo $credit_note_data['return_id'] ?>",
 		  				  order_id : "<?php echo $credit_note_data['order_id'] ?>",
 		  				  serial : "<?php echo $credit_note_data['serial'] ?>" ,
 		  				  product_id : "<?php echo $credit_note_data['product_id'] ?>"};
	<?php endif ?>

		 $scope.open = function () {

		    var modalInstance = $uibModal.open({
		      animation: $scope.animationsEnabled,
		      templateUrl: 'myModalContent.html',
		      controller: 'ModalInstanceCtrl',
		      size: "lg",
		      resolve: {
		        items: function () {
		          return $scope.items;
		        }
		      }
		    });


		    $scope.animationsEnabled = true;
		    modalInstance.result.then(function (selectedItem) {
		     $scope.items = selectedItem;
		     $scope.order_id = $scope.items.order_id;
		     $scope.return_id = $scope.items.return_id;
		     $scope.serial = $scope.items.serial;
		     $scope.product_id = $scope.items.product_id;
				 $scope.product_name = $scope.items.product_name;
				 $scope.product_price = $scope.items.product_price;

		     	console.log($scope.items);
		    }, function () {
		      $log.info('Modal dismissed at: ' + new Date());
		    });
		  };

		  $scope.toggleAnimation = function () {
		    $scope.animationsEnabled = !$scope.animationsEnabled;
		  };


	});

	angular.module('ui.bootstrap').controller('ModalInstanceCtrl', function ($scope,$http, $uibModalInstance, items) {
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
		            url: '<?php echo base_url('credit_note/get_search_order');?>',
		            headers: { 'Content-Type': 'application/x-www-form-urlencoded'
		         }, data: { search : $scope.search_order }

		        }).success(function(data) {
		             var order_data = data;
 					$scope.order_data = order_data;
				});

			}

		};


		$scope.selectOrder = function (data_v){

			$scope.items.return_id = data_v.return_id;
 		  	$scope.items.order_id = data_v.order_id;
 		  	$scope.items.serial = data_v.serial_number;
 		  	$scope.items.product_id = data_v.product_id;
				$scope.items.product_name  = data_v.product_name;
				$scope.items.product_price = data_v.product_price;
			$uibModalInstance.close($scope.items);
		};


	});
	$(document).on('ready', function() {
		    $("#image_fieldedit").fileinput({
		    	language: "th",
					<?php if(isset($credit_note_data['note_img']) && $credit_note_data['note_img']!=""){?>
			        initialPreview: [
			            '<img src="<?php echo $this->config->item('url_img').$credit_note_data['note_img'];?>" class="file-preview-image">'
			        ],
		        <?php } ?>
		    		overwriteInitial: false,
		        maxFileSize: 2000,
		    });

				$("#image_field").fileinput({
				 language: "th",
					 overwriteInitial: false,
					 maxFileSize: 2000,
			 });
		});

</script>
