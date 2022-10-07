<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'public/plugins/bootstrap-5.2.2/css/bootstrap.min.css' ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'public/plugins/DataTables/datatables.min.css' ?>"/>
    <link rel="stylesheet" href="<?php echo base_url() .  'public/plugins/sweetalert2/sweetalert2.min.css' ?>" />

</head>
<body>

<?php include_once dirname(__FILE__) . '/navigation.php' ?>

<style>
    div#screen-spinner {
        position: absolute;
        background: rgba(255, 255, 255, 0.7);
        width: 100vw;
        height: 100vh;
        filter: blur(4);
        z-index: 1200;
    }
    .invisible {
        visibility: hidden !important;
    }
    .visible {
        visibility: visible !important;
    }
</style>
<div id="screen-spinner" class="invisible position-absolute screen-spinner fixed top-0 left-0 d-flex flex-column align-items-center justify-content-center">
    <div role="status">
        <div class="spinner-border text-primary"></div>
        <span class="sr-only">Loading...</span>
    </div>
</div>
