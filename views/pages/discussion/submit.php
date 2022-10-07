<?php

require_once "../../../autoload_files.php";
require_once root_path() . '/config/Database.php';

class Discussion
{

    protected $conn;
    public function __construct()
    {
        $conn = \config\Database\Database::connection();
        $this->conn = $conn;
    }

    public function save()
    {
        try {
            $subject = $_POST['subject'];
            $file_number = $_POST['file_number'];
            $f_head_no = $_POST['f_head_no'];
            $sub_head_no = $_POST['sub_head_no'];
            $file_year = $_POST['file_year'];

            if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
                $res = $this->uploadFile($_FILES);
                if ($res['success']) {
                    $file_path = $res['file_path'];
                } else {
                    echo json_encode([
                        'success' => $res['success'],
                        'message' => $res['message']
                    ]);
                    exit;
                }
            }

            $statement = $this->conn->prepare('INSERT INTO files (subject, file_number, f_head_no, sub_head_no, file_year, file_path) VALUES (:subject, :file_number, :f_head_no, :sub_head_no, :file_year, :file_path)');
            $statement->execute([
                'subject' => $subject,
                'file_number' => $file_number,
                'f_head_no' => $f_head_no,
                'sub_head_no' => $sub_head_no,
                'file_year' => $file_year,
                'file_path' => isset($file_path) ? $file_path : '',
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function uploadFile($fileObj)
    {
        var_dump($_FILES);

        ini_set('upload_max_filesize', '200M');
        ini_set('post_max_size', '200M'); // it will be greater to same like upload_max_filesize

        $path = './public/files/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $response = [];

        if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $allowed = array("pdf" => "application/pdf");
            $filename = $_FILES["file"]["name"];
            $filetype = $_FILES["file"]["type"];
            $filesize = $_FILES["file"]["size"];

            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) return $response = ['success' => 'error', 'message' => 'Error: Please select a valid file format.'];

            // Verify file size - 140MB maximum
            $maxsize = 140 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

            // Verify MEME type of the file
            if(in_array($filetype, $allowed)) {
                $filename = uniqid() . $filename;
                move_uploaded_file($_FILES["file"]["tmp_name"], "{$path}" . $filename);
                $response = [
                    'success' => true,
                    'message' => 'File uploaded and save in local directory',
                    'file_path' => $filename
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => "Error: There was a problem uploading your file. Please try again."
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => "Error: " . $_FILES["file"]["error"]
            ];
        }


        return $response;
    }
}

$obj = new Discussion();
$obj->save();

