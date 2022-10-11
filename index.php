<?php require_once "autoload_files.php" ?>
<?php include_once root_path() . "/views/components/header.php"; ?>


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">Homepage</div>
                    <div class="card-body text-dark">
                        <h5 class="card-title">PHP Mini APP</h5>
                        <p class="card-text">PHP OOP - Ajax based mini project.</p>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo base_url() . '/views/pages/file_records/list.php' ?>" class="btn btn-sm btn-light">Records List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php include_once root_path() . "/views/components/footer.php"; ?>