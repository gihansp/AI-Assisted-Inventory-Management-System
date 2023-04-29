<?php require_once 'includes/header.php'; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-stats"></span> Order Analysis Report
                </div>


                <div class="panel-body">
                    <form class="form-horizontal" action="functions/order/order-report.php" method="post" id="get_ord_report_form">
                        <div class="form-group">
                            <label for="startDate" class="col-sm-1 control-label">From:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Report Period From" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="endDate" class="col-sm-1 control-label">To:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" id="endDate" name="endDate" placeholder="Report Period To" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-sm-10">
                                <button type="submit" class="btn btn-success" id="generateReportBtn">Generate Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="assets/js/report.js"></script>

<?php require_once 'includes/footer.php'; ?>