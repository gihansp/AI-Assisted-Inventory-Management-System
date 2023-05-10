<?php
require_once 'functions/db-connector.php';
require_once 'includes/header.php';

if(isset($_GET['order'])) {
    $request = $_GET['order'];
    switch($request) {
        case 'add':
            echo "<div class='div-request div-hide'>add</div>";
            break;
        case 'manage':
            echo "<div class='div-request div-hide'>manage</div>";
            break;
        case 'modify':
            echo "<div class='div-request div-hide'>modify</div>";
            break;
        default:
            // Handle invalid request
            break;
    }
}
?>











<?php if($_GET['order'] == 'add') {
			// add order
			?>			

			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="functions/order/add-new-order.php" id="new_ord_form">

			  <div class="form-group">
			    <label for="ord_date" class="col-sm-2 control-label">Order Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="ord_date" name="ord_date" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="cstmr_nm" class="col-sm-2 control-label">Customer Name</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="cstmr_nm" name="cstmr_nm" placeholder="Customer Name" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="cstmr_contact" class="col-sm-2 control-label">Client Contact</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="cstmr_contact" name="cstmr_contact" placeholder="Contact Number" />
			    </div>
			  </div> <!--/form-group-->

            <style>
                .cell-padding {
                    padding-left: 20px;
                }
            </style>

            <table class="table table-bordered table-striped" id="prod_tbl">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Available Quantity</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="cart_items">
                <!-- Cart items will be dynamically added here -->
                </tbody>
            </table>

            <script>
                // Function to add a new row to the cart table
                function addCartItem() {
                    var cartItems = document.getElementById("cart_items");
                    var rowCount = cartItems.rows.length;

                    var row = cartItems.insertRow(rowCount);
                    row.id = "row" + rowCount;

                    var productCell = row.insertCell(0);
                    var priceCell = row.insertCell(1);
                    var availQtyCell = row.insertCell(2);
                    var quantityCell = row.insertCell(3);
                    var totalCell = row.insertCell(4);
                    var removeCell = row.insertCell(5);

                    productCell.innerHTML = `
      <div class="form-group">
        <select class="form-control" name="prod_nm[]" onchange="getProd(${rowCount})">
          <!-- Options will be dynamically loaded using AJAX or fetched from a JavaScript array -->
        </select>
      </div>
    `;

                    priceCell.innerHTML = `
      <input type="text" name="rate[]" id="rate${rowCount}" disabled class="form-control" />
      <input type="hidden" name="rate_val[]" id="rate_val${rowCount}" class="form-control" />
    `;

                    availQtyCell.innerHTML = `
      <div class="form-group">
        <p id="avail_prod_qty${rowCount}"></p>
      </div>
    `;

                    quantityCell.innerHTML = `
      <div class="form-group">
        <input type="number" name="product_quantity[]" id="product_quantity${rowCount}" onkeyup="getTotal(${rowCount})" class="form-control" min="1" />
      </div>
    `;

                    totalCell.innerHTML = `
      <input type="text" name="total[]" id="total${rowCount}" class="form-control" disabled />
      <input type="hidden" name="tot_val[]" id="tot_val${rowCount}" class="form-control" />
    `;

                    removeCell.innerHTML = `
      <button class="btn btn-default removeProdBtn" type="button" onclick="removeProd(${rowCount})">
        <i class="glyphicon glyphicon-remove"></i>
      </button>
    `;
                }

                // Function to remove a row from the cart table
                function removeProd(rowId) {
                    var row = document.getElementById("row" + rowId);
                    row.parentNode.removeChild(row);
                }
            </script>




            <div class="col-md-6">
                <div class="form-group">
                    <label for="subTotal" class="col-sm-3 control-label">Subtotal</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="subTotal" name="subTotal" disabled>
                        <input type="hidden" class="form-control" id="subtot_val" name="subtot_val">
                    </div>
                </div>

                <div class="form-group">
                    <label for="totalAmount" class="col-sm-3 control-label">Total</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled>
                        <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue">
                    </div>
                </div>

                <div class="form-group">
                    <label for="discount" class="col-sm-3 control-label">Discount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="discount" name="discount" oninput="applyDiscount()">
                    </div>
                </div>

                <div class="form-group">
                    <label for="grandTotal" class="col-sm-3 control-label">Final Total</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled>
                        <input type="hidden" class="form-control" id="grandtot_val" name="grandtot_val">
                    </div>
                </div>

                <div class="form-group">
                    <label for="vat" class="col-sm-3 control-label gst">Tax</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="vat" name="gstn" readonly>
                        <input type="hidden" class="form-control" id="vatValue" name="vatValue">
                    </div>
                </div>
            </div>
            <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" onkeyup="paidAmt()" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Due Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="cstmr_contact" class="col-sm-3 control-label">Payment Type</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="pay_type" id="pay_type">
				      	<option value="1">Cheque</option>
				      	<option value="2">Cash</option>
				      	<option value="3">Credit Card</option>
				      </select>
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="cstmr_contact" class="col-sm-3 control-label">Payment Method</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="pay_status" id="pay_status">
				      	<option value="1">Full Payment</option>
				      	<option value="2">Advance Payment</option>
				      	<option value="3">No Payment</option>
				      </select>
				    </div>
				  </div>

			  </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="addProd()" id="new_row_btn">Add Product</button>
                    <button type="submit" class="btn btn-success" id="new_ord_btn">Add</button>
                </div>
            </div>

        </form>
		<?php } else if($_GET['order'] == 'manage') {
			?>

			<div id="success-messages"></div>
			
			<table class="table table-striped table-bordered" id="manage_ord_tbl">
				<thead>
					<tr>
						<th style="width:12.85%;">#</th>
						<th style="width:12.85%;">Order Date</th>
						<th style="width:12.85%;">Customer Name</th>
						<th style="width:12.85%;">Contact</th>
						<th style="width:12.85%;">Total Selected Products</th>
						<th style="width:12.85%;">Payment Status</th>
						<th style="width:10%;">Option</th>
					</tr>
				</thead>
			</table>

		<?php 
		} else if($_GET['order'] == 'modify') {
			?>
			
			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="functions/modifyer.php" id="mdfy_ord_form">

  			<?php $orderId = $_GET['i'];

  			$sql = "SELECT orders.order_id, orders.date_ordered, orders.customer_name, orders.customer_phone, orders.total_before_tax, orders.vat, orders.total_invoice_amount, orders.discount, orders.total_amount_payable, orders.paid, orders.due, orders.payment_method, orders.payment_status FROM orders 	
					WHERE orders.order_id = {$orderId}";

				$result = $connect->query($sql);
				$data = $result->fetch_row();
  			?>

            <div class="form-group">
                <label for="ord_date" class="col-sm-2 control-label">Order Date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="ord_date" name="ord_date" value="<?php echo $data[1] ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="cstmr_nm" class="col-sm-2 control-label">Customer Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cstmr_nm" name="cstmr_nm" placeholder="Customer Name" value="<?php echo $data[2] ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="cstmr_contact" class="col-sm-2 control-label">Client Contact</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cstmr_contact" name="cstmr_contact" placeholder="Contact Number" value="<?php echo $data[3] ?>" />
                </div>
            </div>

			  <table class="table" id="prod_tbl">
			  	<thead>
			  		<tr>			  			
			  			<th>Product</th>
			  			<th>Rate</th>
			  			<th>Available product_quantity</th>
			  			<th>product_quantity</th>
			  			<th>Total</th>
			  			<th></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$transactionItemsSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.product_quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
						$transactionItemsResult = $connect->query($transactionItemsSql);

			  		$arrayNumber = 0;
			  		$x = 1;
			  		while($transactionItemsData = $transactionItemsResult->fetch_array()) { 
			  	 ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="prod_nm[]" id="prod_nm<?php echo $x; ?>" onchange="getProd(<?php echo $x; ?>)" >
			  						
                                    <?php
                                    $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND product_quantity != 0";
                                    $productData = $connect->prepare($productSql);
                                    $productData->execute();

                                    while($row = $productData->fetch_array()) {
                                        $selected = ($row['product_id'] == $transactionItemsData['product_id']) ? "selected" : "";
                                        echo '<option value="' . $row['product_id'] . '" id="changeProduct' . $row['product_id'] . '" ' . $selected . '>' . $row['product_name'] . '</option>';
                                    } // /while
                                    ?>

                                </select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" disabled="true" class="form-control" value="<?php echo $transactionItemsData['rate']; ?>" />			  					
			  					<input type="hidden" name="rate_val[]" id="rate_val<?php echo $x; ?>" class="form-control" value="<?php echo $transactionItemsData['rate']; ?>" />			  					
			  				</td>
							<td style="padding-left:20px;">
			  					<div class="form-group">
                                    <?php
                                    $productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND product_quantity != 0";
                                    $productData = $connect->prepare($productSql);
                                    $productData->execute();

                                    while($row = $productData->fetch_array()) {
                                        $selected = ($row['product_id'] == $transactionItemsData['product_id']) ? "selected" : "";
                                        echo '<option value="' . $row['product_id'] . '" id="changeProduct' . $row['product_id'] . '" ' . $selected . '>' . $row['product_name'] . '</option>';
                                        echo ($row['product_id'] == $transactionItemsData['product_id']) ? '<p id="avail_prod_qty' . $row['product_id'] . '">' . $row['product_quantity'] . '</p>' : '';
                                    } // /while
                                    ?>


                                </div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="product_quantity[]" id="product_quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" class="form-control" min="1" value="<?php echo $transactionItemsData['product_quantity']; ?>" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" class="form-control" disabled="true" value="<?php echo $transactionItemsData['total']; ?>"/>			  					
			  					<input type="hidden" name="tot_val[]" id="tot_val<?php echo $x; ?>" class="form-control" value="<?php echo $transactionItemsData['total']; ?>"/>			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProdBtn" type="button" id="removeProdBtn" onclick="removeProd(<?php echo $x; ?>)"><i class="glyphicon glyphicon-remove"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[4] ?>" />
				      <input type="hidden" class="form-control" id="subtot_val" name="subtot_val" value="<?php echo $data[4] ?>" />
				    </div>
				  </div> <!--/form-group-->			  
				  			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[6] ?>" />
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[6] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Discount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="applyDiscount()" value="<?php echo $data[7] ?>" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data[8] ?>"  />
				      <input type="hidden" class="form-control" id="grandtot_val" name="grandtot_val" value="<?php echo $data[8] ?>"  />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label gst"><?php if($data[13] == 2) {echo "IGST 18%";} else echo "GST 18%"; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" value="<?php echo $data[5] ?>"  />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data[5] ?>"  />
				    </div>
				  </div> 


			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">paid Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" onkeyup="paidAmt()" value="<?php echo $data[9] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Due Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[10] ?>"  />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[10] ?>"  />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="cstmr_contact" class="col-sm-3 control-label">Payment Type</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="pay_type" id="pay_type" >
				      	
				      	<option value="1" <?php if($data[11] == 1) {
				      		echo "selected";
				      	} ?> >Cheque</option>
				      	<option value="2" <?php if($data[11] == 2) {
				      		echo "selected";
				      	} ?>  >Cash</option>
				      	<option value="3" <?php if($data[11] == 3) {
				      		echo "selected";
				      	} ?> >Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="cstmr_contact" class="col-sm-3 control-label">Payment Status</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="pay_status" id="pay_status">
				      	
				      	<option value="1" <?php if($data[12] == 1) {
				      		echo "selected";
				      	} ?>  >Full Payment</option>
				      	<option value="2" <?php if($data[12] == 2) {
				      		echo "selected";
				      	} ?> >Advance Payment</option>
				      	<option value="3" <?php if($data[10] == 3) {
				      		echo "selected";
				      	} ?> >No Payment</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->

			  </div> <!--/col-md-6-->


			  <div class="form-group editButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addProd()" id="new_row_btn" > <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

			    <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="mdfy_ord_btn" class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Add</button>
			      
			    </div>
			  </div>
			</form>

			<?php
		} // /get order else  ?>


	</div> <!--/panel-->	
</div> <!--/panel-->	


<!-- edit order -->
<div class="modal" tabindex="-1" role="dialog" id="pay-order-modal">
  <div class="modal-dialog modal-fullpage modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Edit Payment</h4>
      </div>      

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

      	<div class="payOrderMessages"></div>

      	     				 				 
			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Due Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="due" name="due" disabled="true" />					
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="pay_amt" class="col-sm-3 control-label">Pay Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="pay_amt" name="pay_amt"/>
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="cstmr_contact" class="col-sm-3 control-label">Payment Type</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="pay_type" id="pay_type" >
			      	
			      	<option value="1">Cheque</option>
			      	<option value="2">Cash</option>
			      	<option value="3">Credit Card</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  
			  <div class="form-group">
			    <label for="cstmr_contact" class="col-sm-3 control-label">Payment Status</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="pay_status" id="pay_status">
			      	
			      	<option value="1">Full Payment</option>
			      	<option value="2">Advance Payment</option>
			      	<option value="3">No Payment</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  				  
      	        
      </div> <!--/modal-body-->
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> Exit</button>
        <button type="button" class="btn btn-primary" id="updt-pay-order-btn" > Add</button>	
      </div>           
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog modal-fullpage -->
</div><!-- /.modal -->
<!-- /edit order-->

<!-- remove order -->
<div class="modal" tabindex="-1" role="dialog" id="deleteOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Order</h4>
      </div>
      <div class="modal-body">

      	<div class="deleteOrderMessages"></div>

        <p>Confirm removal? This action cannot be undone.</p>
      </div>
      <div class="modal-footer deleteProdFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> No</button>
        <button type="button" class="btn btn-primary" id="deleteOrderBtn" > Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog modal-fullpage -->
</div><!-- /.modal -->
<!-- /remove order-->


<script src="https://closure-compiler.appspot.com/code/jsc3c0a61f6f9c7c7f20c5d03f2f01fcdb6/default.js"></script>

<?php require_once 'includes/footer.php'; ?>


	