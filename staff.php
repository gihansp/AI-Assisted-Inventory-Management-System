<?php require_once 'functions/db-connector.php' ?>
<?php require_once 'includes/header.php'; ?>

    <div class="row">
        <div class="col-md-12">



            <div class="remove-messages"></div>

            <div class="pull pull-right pb">
                <button class="btn btn-primary" data-toggle="modal" id="new_usr_btn" data-target="#addUserModal">Add User</button>
            </div>

            <table class="table table-striped table-bordered" id="manage_usr_tbl">
                <thead>
                <tr>
                    <th style="width:90%;">User Name</th>
                    <th style="width:10%;">Options</th>
                </tr>
                </thead>
            </table>



        </div>
    </div>


    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addUserModalLabel">Add User</h4>
                </div>
                <div class="modal-body">
                    <form id="submit_usr_form" action="functions/user/create-staff.php" method="POST" enctype="multipart/form-data">
                        <div id="add-user-messages"></div>
                        <div class="form-group">
                            <label for="userName">User Name:</label>
                            <input type="text" class="form-control" id="userName" name="userName" placeholder="User Name">
                        </div>
                        <div class="form-group">
                            <label for="upassword">Password:</label>
                            <input type="password" class="form-control" id="upassword" name="upassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="uemail">Email:</label>
                            <input type="email" class="form-control" id="uemail" name="uemail" placeholder="Email">
                        </div>
                </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary" id="new_usr_btn">Yes</button>
                        </div>
                    </form>




            </div>
        </div>
    </div>






    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editUserModalLabel">Edit User</h4>

                </div>

                    <div class="div-result">
                        <form id="mdfy_usr_form" action="functions/user/edit-staff.php" method="POST">
                            <div class="modal-body" style="overflow:auto;">
                            <div id="edit-user-messages"></div>
                            <div class="form-group">
                                <label for="mdfy_usr_nm">User Name</label>
                                <input type="text" class="form-control" id="mdfy_usr_nm" name="mdfy_usr_nm" placeholder="User Name">
                            </div>
                            <div class="form-group">
                                <label for="mdfy_pwd">Password</label>
                                <input type="password" class="form-control" id="mdfy_pwd" name="mdfy_pwd" placeholder="Password">
                            </div>



                            </div>
                            <div class="modal-footer editUserFooter">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Exit</button>
                                <button type="submit" class="btn btn-success" id="mdfyProdBtn">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>




            </div>

    </div>









    <div class="modal" tabindex="-1" role="dialog" id="del_usr_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Staff</h4>
                </div>
                <div class="modal-body">

                    <div class="deleteUserMessages"></div>

                    <p>Confirm removal? This action cannot be undone.</p>
                </div>
                <div class="modal-footer deleteProdFooter">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> No</button>
                    <button type="button" class="btn btn-primary" id="del_prod_btn" > Yes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://closure-compiler.appspot.com/code/jsc3c0a61f6f9c7c7f20c5d03f2f01fcdb6/default.js"></script>

<?php require_once 'includes/footer.php'; ?>