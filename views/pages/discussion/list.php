<?php require_once "../../../autoload_files.php"; ?>
<?php include_once root_path() . '/views/components/header.php' ?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-dark mb-3">
                    <div class="card-header">
                        Records
                        <a href="<?php echo base_url() . 'views/pages/discussion/create.php' ?>" class="btn btn-sm btn-dark float-end">Create New</a>
                    </div>
                    <div class="card-body text-dark">
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
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>125</td>
                                <td>Financial Matter</td>
                                <td>1</td>
                                <td>2</td>
                                <td>2022</td>
                                <td><a href="" class="btn btn-sm btn-light border rounded-0">🔽 Download</a></td>
                                <td>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#staticMediaModal" class="btn btn-sm btn-success rounded-0">View</a>
                                </td>
                                <td><a href="" class="btn btn-sm btn-danger rounded-0">Delete</a></td>
                            </tr>
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
                                <th scope="col">Date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticMediaModal">-->
<!--    Launch static backdrop modal-->
<!--</button>-->

<!-- Modal -->
<div class="modal fade" id="staticMediaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticMediaModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark rounded-0" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php include_once root_path() . '/views/components/footer.php' ?>
