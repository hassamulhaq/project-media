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
            $this->conn->beginTransaction();

            $subject = $_POST['subject'];
            $file_number = $_POST['file_number'];
            $f_head_no = $_POST['f_head_no'];
            $sub_head_no = $_POST['sub_head_no'];
            $file_year = $_POST['file_year'];

            // check if user selected a file
            if(!empty($_FILES["file"]['name'])) {
                $res = $this->uploadFile($_FILES);
                if (!$res['success']) { // means error
                    echo json_encode([
                        'success' => $res['success'],
                        'message' => $res['message']
                    ]);
                    exit;
                }

                $file_path = $res['file_path'];
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
            $this->conn->commit();
            echo json_encode(['success' => true, 'message' => 'Record Added!']);

        } catch (Exception $e) {
            $this->conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Data Not saved', 'errors' => $e->getMessage()]);
        }
    }


    public function uploadFile($fileObj)
    {
        ini_set('file_uploads', 'on');
        ini_set('upload_max_filesize', '128M');
        ini_set('post_max_size', '128M'); // it will be greater to same like upload_max_filesize

        $movedToPath = filesUploadPath();
        $path = FILES_PATH; // comes from autoload_files.php

        $response = [];
        if(isset($fileObj["file"]) && $fileObj["file"]["error"] == 0) {
            $allowed = array("pdf" => "application/pdf");
            $filename = $fileObj["file"]["name"];
            $filetype = $fileObj["file"]["type"];
            $filesize = $fileObj["file"]["size"];

            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) return $response = ['success' => 'error', 'message' => 'Error: Please select a valid file format.'];

            // Verify file size - 140MB maximum
            $maxsize = 140 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

            // Verify MEME type of the file
            if(in_array($filetype, $allowed)) {
                $filename = uniqid() .'-'. $filename;
                move_uploaded_file($fileObj["file"]["tmp_name"], "{$movedToPath}" . $filename);
                $response = [
                    'success' => true,
                    'message' => 'File uploaded and save in local directory',
                    'file_path' => $path . $filename
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
                'message' => "Increase upload_max_filesize in php.ini file" ." Error: ". $fileObj["file"]["error"]
            ];
        }

        return $response;
    }
}

$obj = new Discussion();
$obj->save();

