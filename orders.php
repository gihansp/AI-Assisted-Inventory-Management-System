
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
            break;
    }
}
?>


<?php if($_GET['order'] == 'add') {
			?>			

			<div class="success-messages"></div> 

  		<form class="form-horizontal" method="POST" action="functions/order/add-new-order.php" id="new_ord_form">

			  <div class="form-group">
			    <label for="ord_date" class="col-sm-2 control-label">Order Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="ord_date" name="ord_date" />
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="cstmr_nm" class="col-sm-2 control-label">Customer Name</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="cstmr_nm" name="cstmr_nm" placeholder="Customer Name" />
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="cstmr_contact" class="col-sm-2 control-label">Client Contact</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="cstmr_contact" name="cstmr_contact" placeholder="Contact Number" />
			    </div>
			  </div> 

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