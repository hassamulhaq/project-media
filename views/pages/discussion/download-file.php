<?php
require_once "../../../autoload_files.php";

// http://localhost/project//public/files/634161dce34d2-FIBS-MARKETING-TEAM.pdf

//if (isset($_POST['file_download'])) {
//    //Read the filename
//    //$filename = $_POST['filepath'];
//
//
//    $file_url = '../../../'.$_POST['file_url'];
//
//    //$file_url = "../../../public/files/634161dce34d2-FIBS-MARKETING-TEAM.pdf";
//
//    var_dump(file_exists($file_url));
//
//    exit;
//
//
//    if (file_exists($file_url)) {
//        header('Content-Description: File Transfer');
//        header('Content-Type: application/octet-stream');
//        header('Content-Disposition: attachment; filename='.basename($file_url));
//        header('Content-Transfer-Encoding: binary');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate');
//        header('Pragma: public');
//        header('Content-Length: ' . filesize($file_url));
//        ob_clean();
//        flush();
//        readfile($file_url);
//        exit;
//    }
//
//
//
//} else
//    echo "Filename is not defined."
//?>