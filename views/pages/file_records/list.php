<?php require_once "../../../autoload_files.php"; ?>
<?php include_once root_path() . '/views/components/header.php' ?>

<style>
    .dt-buttons.btn-group.flex-wrap {
        padding-top: 6px;
        padding-bottom: 6px;
    }
    #the-canvas {
        border: 1px solid black;
        direction: ltr;
        width: 100%;
    }
</style>


<?php
require_once root_path() . "/views/pages/discussion/get-and-save.php";

if (isset($_GET['filter_by_year'])) {
    $date = $_GET['filter_by_year'];
    $obj = new FormTask();
    $records = $obj->getFilteredRecords($date);
} else {
    $obj = new FormTask();
    $records = $obj->getRecords();
}
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-dark mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" href="list.php">Records List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() . 'views/pages/file_records/create.php' ?>" class="nav-link">Create New</a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <div class="input-group input-group-sm float-end">
                                    <form class="form-inline d-flex gap-1 align-items-center" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" autocomplete="off">
                                        <label for="filter_by_date" class="text-nowrap">Filter By Year</label>
                                        <input type="number" id="filter_by_date" name="filter_by_year"  placeholder="yyyy" class="form-control form-control-sm" value="<?php echo (isset($_GET['filter_by_year']) ? $_GET['filter_by_year'] : '') ?>">
                                        <div class="input-group-append">
                                            <input type="submit" value="search" class="btn btn-sm btn-dark">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body text-dark">
                        <div id="datatable-wrapper">
                            <table id="pdf-datatables" class="table table-condensed table-sm table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">File No</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Head No</th>
                                    <th scope="col">Sub-Head No</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Download</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Delete</th>
                                    <!-- <th scope="col">Created at</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                    <?php if ($records) { ?>
                                        <?php foreach ($records as $index => $record) { ?>
                                            <tr>
                                                <td scope="row"><?= $record->id ?></td>
                                                <td><?= $record->file_number ?></td>
                                                <td><?= $record->subject ?></td>
                                                <td><?= $record->f_head_no ?></td>
                                                <td><?= $record->sub_head_no ?></td>
                                                <td><?= $record->file_year ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <?php if (!is_null($record->file_path) && $record->file_path !== '') { ?>
                                                            <form action="get-and-save.php" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="record_id" value="<?= $record->id ?>">
                                                                <input type="hidden" name="file_path" value="<?= $record->file_path ?>">
                                                                <button type="submit" name="file_download" class="btn btn-sm btn-light border rounded-0">🔽 Download</button>
                                                            </form>
                                                            <a href="<?= base_url() . $record->file_path ?>" target="_blank" class="btn btn-sm btn-light border rounded-0">🔰</a>
                                                        <?php } else echo '❕ N/A' ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!is_null($record->file_path) && $record->file_path !== '') { ?>
                                                        <a href="javascript:void(0)"
                                                           onclick="RenderPDF('<?= base_url() . $record->file_path ?>');"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#genericPdfModal"
                                                           class="btn btn-sm btn-success rounded-0">View</a>
                                                    <?php } else echo '❕ N/A' ?>
                                                </td>
                                                <td>
                                                    <form action="get-and-save.php" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="record_id" value="<?= $record->id ?>">
                                                        <input type="hidden" name="file_path" value="<?= $record->file_path ?>">
                                                        <button type="submit" name="delete_record" class="btn btn-sm btn-danger rounded-0">Delete</button>
                                                    </form>
                                                </td>
                                                <!-- <td><?php //echo $record->created_at ?></td> -->
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">File No</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Head No</th>
                                    <th scope="col">Sub-Head No</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Download</th>
                                    <th scope="col">View</th>
                                    <th scope="col">Delete</th>
                                    <!-- <th scope="col">Created At</th> -->
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>


<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticMediaModal">-->
<!--    Launch static backdrop modal-->
<!--</button>-->

<!-- Modal -->
<div class="modal modal-xl fade" id="genericPdfModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="genericPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="genericPdfModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <button id="prev_page" class="btn btn-sm btn-dark rounded-0 mb-2">Previous</button>
                    <button id="next_page" class="btn btn-sm btn-dark rounded-0 mb-2">Next</button>
                    &nbsp; &nbsp;
                    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                </div>
                <canvas id="the-canvas"></canvas>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php include_once root_path() . '/views/components/footer.php' ?>
<script src="<?php echo base_url() . 'public/dist/js/serverside-datatables.js' ?>"></script>

<script>
    <?php if (isset($_SESSION['is_deleted']) && $_SESSION['is_deleted']['success']) { ?>
    Toast.fire({
        icon: "success",
        title: "<?php echo $_SESSION['is_deleted']['message'] ?>"
    })
    <?php
        // set session set to null after Toast trigger.
        // new session will auto generate when record deleted in get-and-save.php
        $_SESSION['is_deleted'] = null
    ?>
    <?php } ?>
</script>