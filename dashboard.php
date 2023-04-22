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
            <div class="row">


                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Staff Referrals</div>
                        <div class="panel-body">


                            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <canvas id="user-orders-chart"></canvas>
                            <script>
                                var chartData = '<?php echo $chartDataJson; ?>';

                                // Parse the chart data JSON string into a JavaScript object
                                chartData = JSON.parse(chartData);

                                // Get the canvas element and create a new Chart.js instance
                                var ctx = document.getElementById('user-orders-chart').getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: Object.keys(chartData),
                                        datasets: [{
                                            data: Object.values(chartData),
                                            backgroundColor: [
                                                '#FF6384',
                                                '#36A2EB',
                                                '#FFCE56',
                                                '#8E44AD',
                                                '#3498DB',
                                                '#27AE60',
                                                '#F1C40F'
                                            ]
                                        }]
                                    },
                                    options: {
                                        title: {
                                            display: true,
                                            text: 'userOrders'
                                        }
                                    }
                                });
                            </script>


                        </div>
                    </div>
                </div>




            <?php } ?>





            <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Recent Customer Orders</div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered" id="prod_tbl">
                                <thead>
                                <tr>
                                    <th style="width:20%;">Date</th>
                                    <th style="width:30%;">Name</th>
                                    <th style="width:20%;">Sales Revenue</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($orderResult = $recentOrdersQuery->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $orderResult['date_ordered']; ?></td>
                                        <td><?php echo $orderResult['customer_name']; ?></td>
                                        <td><?php echo $orderResult['total_amount_payable']; ?> LKR</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            <?php } ?>

        </div>

</div>


<?php require_once 'includes/footer.php'; ?>