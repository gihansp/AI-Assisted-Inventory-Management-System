<?php require_once 'includes/header.php'; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-download-alt"></i> Download Database Backup
                </div>
                <div class="panel-body">
                    <p>Click the button below to download a full database backup:</p>
                    <button class="btn btn-primary" onclick="downloadBackup()">Download Backup</button>
                </div>
            </div>

            <script>
                function downloadBackup() {
                    window.location.href = "download-backup.php";
                }
            </script>

        </div>
        <!-- /col-dm-12 -->
    </div>

<!-- /row -->

<script src="assets/js/report.js"></script>

<?php require_once 'includes/footer.php'; ?>