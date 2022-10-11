<?php require_once "../../../autoload_files.php"; ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">`
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>PDF.js viewer</title>

    <link rel="stylesheet" href="<?= base_url() . 'public/plugins/pdfjs-2.16.105/web/viewer.css' ?>">

    <script src="<?= base_url() . 'public/plugins/pdfjs-2.16.105/build/pdf.js' ?>"></script>
    <script src="<?= base_url() . 'public/plugins/pdfjs-2.16.105/web/viewer.js' ?>"></script>
</head>

<body>
<header>
    <h1 id="title"></h1>
</header>

<div id="viewerContainer">
    <div id="viewer" class="pdfViewer"></div>
</div>

<div id="loadingBar">
    <div class="progress"></div>
    <div class="glimmer"></div>
</div>

<div id="errorWrapper" hidden="true">
    <div id="errorMessageLeft">
        <span id="errorMessage"></span>
        <button id="errorShowMore">
            More Information
        </button>
        <button id="errorShowLess">
            Less Information
        </button>
    </div>
    <div id="errorMessageRight">
        <button id="errorClose">
            Close
        </button>
    </div>
    <div class="clearBoth"></div>
    <textarea id="errorMoreInfo" hidden="true" readonly="readonly"></textarea>
</div>

<footer>
    <button class="toolbarButton pageUp" title="Previous Page" id="previous"></button>
    <button class="toolbarButton pageDown" title="Next Page" id="next"></button>

    <input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="4" min="1">

    <button class="toolbarButton zoomOut" title="Zoom Out" id="zoomOut"></button>
    <button class="toolbarButton zoomIn" title="Zoom In" id="zoomIn"></button>
</footer>

<script src="<?= base_url() . 'public/plugins/pdfjs-2.16.105/web/viewer.js' ?>"></script>
</body>
</html>