<?php require_once 'functions/db-connector.php' ?>
<?php require_once 'includes/header.php'; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="div-action pull pull-right pb">
                <button class="btn btn-primary" data-toggle="modal" id="new_prod_btn" data-target="#addProductModal">Add Product</button>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">









        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="manageprod_tbl">
                <thead>
                <tr>
                    <th style="width:12.85%;">Photo</th>
                    <th style="width:12.85%;">Product Name</th>
                    <th style="width:12.85%;">Price</th>
                    <th style="width:12.85%;">Quantity</th>
                    <th style="width:12.85%;">Category</th>
                    <th style="width:10%;">Options</th>
                </tr>
                </thead>
            </table>



        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="modal" id="addProductModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="mdfyProdModalLabel">Add Product</h4>
                            </div>
                            <form class="form-horizontal" id="submit_prod_form" action="functions/product/add-product.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body" style="overflow:auto;">
                                    <div id="add-product-messages"></div>
                                    <div class="form-group">
                                        <label for="prod_img" class="col-sm-3 control-label">Product Image:</label>
                                        <label class="col-sm-1 control-label">:</label>
                                        <div class="col-sm-8">
                                            <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                                            <div class="kv-avatar center-block">
                                                <input type="file" class="form-control" id="prod_img" placeholder="Product Name" name="prod_img" style="width:auto;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="prod_nm" class="col-sm-3 control-label">Product Name: </label>
                                        <label class="col-sm-1 control-label">: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="prod_nm" placeholder="Product Name" name="prod_nm">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity" class="col-sm-3 control-label">Product Quantity: </label>
                                        <label class="col-sm-1 control-label">: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="product_quantity" placeholder="Product Quantity" name="product_quantity">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="rate" class="col-sm-3 control-label">Rate: </label>
                                        <label class="col-sm-1 control-label">: </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="rate" placeholder="Rate" name="rate">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cat_nm" class="col-sm-3 control-label">Category Name: </label>
                                        <label class="col-sm-1 control-label">: </label>
                                        <div class="col-sm-8">
                                            <select type="text" class="form-control" id="cat_nm" placeholder="Product Name" name="cat_nm">
                                                <?php
                                                $sql = "SELECT cat_id, cat_name, cat_status FROM categories WHERE cat_status = 1";
                                                $result = $connect->query($sql);
                                                while($row = $result->fetch_array()) {
                                                    echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="prod_status" class="col-sm-3 control-label">Status:</label>
                                        <label class="col-sm-1 control-label">: </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="prod_status" name="prod_status">
                                                <option value="1">Available</option>
                                                <option value="2">Not Available</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                                    <button type="submit" class="btn btn-primary" id="createProductBtn">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>






            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="modal" id="mdfyProdModal" tabindex="-1" role="dialog" aria-labelledby="mdfyProdModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="mdfyProdModalLabel">Modify Product</h4>

                            </div>
                            <div class="modal-body" style="overflow:auto;">
                                <div class="div-result">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab" data-toggle="tab">Photo</a></li>
                                        <li role="presentation"><a href="#productInfo" aria-controls="profile" role="tab" data-toggle="tab">Product Info</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="photo">
                                            <form action="functions/product/edit-product-image.php" method="POST" id="mdfy_prod_img_form" class="form-horizontal" enctype="multipart/form-data">
                                                <br>
                                                <div id="edit-productPhoto-messages"></div>
                                                <div class="form-group">
                                                    <label for="mdfy_prod_img" class="col-sm-3 control-label">Select Photo:</label>
                                                    <div class="col-sm-9">
                                                        <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                                                        <div class="kv-avatar center-block">
                                                            <input type="file" class="form-control" id="mdfy_prod_img" placeholder="Product Name" name="mdfy_prod_img" style="width:auto;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer mdfyProdPhotoFooter">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="productInfo">
                                            <form class="form-horizontal" id="mdfyProdForm" action="functions/product/edit-product.php" method="POST">
                                                <br>
                                                <div id="edit-product-messages"></div>
                                                <div class="form-group">
                                                    <label for="mdfy_prod_nm" class="col-sm-3 control-label">Product Name:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="mdfy_prod_nm" placeholder="Product Name" name="mdfy_prod_nm">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mdfy_prod_qty" class="col-sm-3 control-label">Product Quantity:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="mdfy_prod_qty" placeholder="Product Quantity" name="mdfy_prod_qty">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mdfy_rate" class="col-sm-3 control-label">Rate:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="mdfy_rate" placeholder="Rate" name="mdfy_rate">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mdfy_cat_nm" class="col-sm-3 control-label">Category Name:</label>
                                                    <div class="col-sm-9">
                                                        <select type="text" class="form-control" id="mdfy_cat_nm" name="mdfy_cat_nm">
                                                            <?php
                                                            $sql = "SELECT cat_id, cat_name, cat_status FROM categories WHERE cat_status = 1";
                                                            $result = $connect->query($sql);

                                                            while ($row = $result->fetch_array()) {
                                                                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mdfy_prod_status" class="col-sm-3 control-label">Status:</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" id="mdfy_prod_status" name="mdfy_prod_status">
                                                            <option value="1">Available</option>
                                                            <option value="2">Not Available</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer mdfyProdFooter">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                                                    <button type="submit" class="btn btn-success" id="mdfyProdBtn">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /modal -->


            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="modal" tabindex="-1" role="dialog" id="del_prod_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Remove Product</h4>
                            </div>
                            <div class="modal-body">

                                <div class="deleteProdMessages"></div>

                                <p>Confirm removal? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer deleteProdFooter">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> No</button>
                                <button type="button" class="btn btn-primary" id="del_prod_btn" > Yes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog modal-fullpage -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://closure-compiler.appspot.com/code/jsc3c0a61f6f9c7c7f20c5d03f2f01fcdb6/default.js"></script>

<?php require_once 'includes/footer.php'; ?>