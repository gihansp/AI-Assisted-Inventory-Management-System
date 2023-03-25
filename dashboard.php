<?php require_once 'includes/header.php'; ?>

<?php include 'includes/dashboard.php'; ?>


    <style>
        .alert-info {
            background-color: #5bc0de; /* Matched color for info box */
        }

        .alert-danger {
            background-color: #d9534f; /* Matched color for danger box */
        }

        .alert-success {
            background-color: #5cb85c; /* Matched color for success box */
        }

        .alert-warning {
            background-color: #f0ad4e; /* Matched color for warning box */
        }

        .glyphicon {
            opacity: 0.7; /* Lowered opacity for glyphs */
        }
    </style>

    <div class="row">
        <div class="col-lg-3">
            <div class="alert-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <span class="glyphicon glyphicon-inbox" style="font-size: 5em;"></span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <p class="lead"><?php echo $productCount; ?></p>
                            <p class="announcement-text">Inventory</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="alert-danger">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <span class="glyphicon glyphicon-minus" style="font-size: 5em;"></span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <p class="lead"><?php echo $lowStockCount; ?></p>
                            <p class="announcement-text">Low Stock</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="alert-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <span class="glyphicon glyphicon-tasks" style="font-size: 5em;"></span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <p class="lead"><?php echo $orderCount; ?></p>
                            <p class="announcement-text">Order Count</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="alert-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <span class="glyphicon glyphicon-usd" style="font-size: 5em;"></span>
                        </div>
                        <div class="col-xs-6 text-right">
                            <p class="lead"><?php if ($totalRevenue) {
                                    echo $totalRevenue;
                                } else {
                                    echo '0 LKR';
                                } ?></p>
                            <p class="announcement-text">Net Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
            <?php require_once 'includes/footer.php'; ?>