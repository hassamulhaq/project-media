<?php require_once "../../../autoload_files.php"; ?>
<?php include_once root_path() . '/views/components/header.php' ?>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-dark mb-3">
                <div class="card-header">
                    Create New Record
                    <a href="<?php echo base_url() . 'views/pages/discussion/list.php' ?>" class="btn btn-sm btn-dark float-end">View List</a>
                </div>
                <div class="card-body text-dark">
                    <form class="ajax_form" method="post" action="get-and-save.php" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="new_record" value="true">
                        <div class="mb-3">
                            <label for="file_number" class="form-label">File No:</label>
                            <input type="text" name="file_number" id="file_number" class="form-control" aria-describedby="file_number">
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" aria-describedby="subject">
                        </div>

                        <div class="mb-3">
                            <label for="f_head_no" class="form-label">F-Head No:</label>
                            <input type="text" name="f_head_no" id="f_head_no" class="form-control" aria-describedby="f_head_no">
                        </div>

                        <div class="mb-3">
                            <label for="sub_head_no" class="form-label text-bo">Sub-Head No:</label>
                            <input type="text" name="sub_head_no" id="sub_head_no" class="form-control" aria-describedby="sub_head_no">
                        </div>

                        <div class="mb-3">
                            <label for="file_year" class="form-label">File Year:</label>
                            <input type="number" name="file_year" id="sub_head_no" min="1900" max="5099" step="1" placeholder="YYYY" class="form-control" aria-describedby="file_year">
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File <small class="small">(PDF only)</small> </label>
                            <input type="file" name="file" id="file" class="form-control" aria-describedby="file" accept="application/pdf">
                        </div>

                        <button type="submit" class="btn btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include_once root_path() . '/views/components/footer.php' ?>