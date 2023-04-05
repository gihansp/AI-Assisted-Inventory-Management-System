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