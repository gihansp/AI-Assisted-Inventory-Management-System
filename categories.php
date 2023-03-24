<?php require_once 'includes/header.php'; ?>
<div class="row">
        <div class="col-md-12">

            <!-- DataTables CSS -->




            <div class="remove-messages"></div>

            <div class="div-action pull pull-right pb">
                <button class="btn btn-primary" data-toggle="modal" id="new_cats_btn" data-target="#add-cat-modal">  Add Categories </button>
            </div> <!-- /div-action -->

            <table class="table table-striped table-bordered" id="manage_cats_tbl">
                <thead>
                <tr>
                    <th style="width:90%;">Category Name</th>
                    <th style="width:10%;">Options</th>
                </tr>
                </thead>
            </table>

        </div>
    </div>

    <div class="modal fade" id="add-cat-modal" tabindex="-1" role="dialog" aria-labelledby="add-cat-modal-label">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="add-cat-modal-label">Add Category</h4>

                </div>
                <form id="submit_cats_form" action="functions/category/add-category.php" method="POST">
                    <div class="modal-body">
                        <div id="add-categories-messages"></div>
                        <div class="form-group">
                            <label for="cats_name">Category Name</label>
                            <input type="text" class="form-control" id="cats_name" name="cats_name" placeholder="Category Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                        <button type="submit" class="btn btn-primary" id="new_cats_btn">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>