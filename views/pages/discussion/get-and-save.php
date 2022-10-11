<?php
sleep(0);
require_once "../../../autoload_files.php";
require_once root_path() . '/config/Database.php';

class FormTask
{

    protected $conn;
    public function __construct()
    {
        $conn = \config\Database\Database::connection();
        $this->conn = $conn;
    }

    private function getAbsoluteFilePath($filename) {
        // files are saved in public/file/...
        // In database we save /public/file/filename.pdf
        // while deleting we need absolute path from current file

        return "../../../" . $filename;
    }

    private function validateInputs($inputs) {
        foreach ($inputs as $input) {
            if ($input === '' || is_null($input)) {
                return false;
            }
        }

        return true;
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

            $res = $this->validateInputs($_POST);
            if ($res === false) {
                echo json_encode([
                    'success' => false,
                    'message' => 'All inputs required',
                    'data' => ['Blank Inputs' => 'Fill all inputs']]);
                exit;
            }



            // check if user selected a file
            if(!empty($_FILES["file"]['name'])) {
                $fileUploadResponse = $this->uploadFile($_FILES);
                if (!$fileUploadResponse['success']) { // means error
                    echo json_encode([
                        'success'   => $fileUploadResponse['success'],
                        'message'   => $fileUploadResponse['message'],
                        'data'      => $fileUploadResponse['data']
                    ]);
                    exit;
                }

                // If file uploaded then we got path
                $file_path = $fileUploadResponse['file_path'];
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
            echo json_encode(['success' => true, 'message' => 'Record Added!', 'data'=> []]);

        } catch (Exception $e) {
            $this->conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Data Not saved', 'data' => [$e->getMessage()]]);
        }
    }


    public function uploadFile($fileObj): array
    {
//        ini_set('file_uploads', 'on');
//        ini_set('post_max_size', '2048M');
//        ini_set('upload_max_filesize', '2048M');

        $movedToPath = filesUploadPath();  // comes from autoload_files.php
        $path = FILES_PATH; // comes from autoload_files.php
        if (!file_exists($movedToPath)) {
            mkdir($movedToPath, 0777, true);
        }

        $response = [];

        // if there is an error
        if(isset($fileObj["file"]) && $fileObj["file"]["error"] !== 0) {
            $response = [
                'success' => false,
                'message' => "Increase upload_max_filesize in php.ini or check on google" ." Error Code: ". $fileObj["file"]["error"],
                'data' => []
            ];
            return $response;
        }


        if(isset($fileObj["file"]) && $fileObj["file"]["error"] === 0) {
            $allowed = array("pdf" => "application/pdf");
            $filename = $fileObj["file"]["name"];
            $filetype = $fileObj["file"]["type"];
            $filesize = $fileObj["file"]["size"];

            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) {
                $response = ['success' => false, 'message' => 'Error: Please select a valid file format.', 'data' => (array) $allowed];
                return $response;
            }

            // Verify MEME type of the file
            if(!in_array($filetype, $allowed)) {
                $response = ['success' => false, 'message' => "Error: Meme type is not valid", 'data' => []];
                return $response;
            }

            // Verify file size - 2048M maximum
            $maxsize = 2048 * 1024 * 1024;
            if($filesize > $maxsize) {
                $response = ['success' => false, 'message' => 'Error: File size is larger than the allowed limit.', 'data' => []];
                return $response;
            }

            $filename = uniqid() .'-'. str_replace(' ', '-', $filename);
            $moved = move_uploaded_file($fileObj["file"]["tmp_name"], "{$movedToPath}" . $filename);
            if ($moved) {
                $response = [
                    'success' => true,
                    'message' => 'Record saved, File uploaded and save in local directory',
                    'file_path' => $path . $filename,
                    'data' => []
                ];
            } else $response = ['success' => false, 'message' => "Error: There was a problem uploading your file. Please try again.", 'data' => []];
        }

        return $response;
    }

    public function getRecords()
    {
        $statement = $this->conn->prepare('SELECT * FROM files');
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function deleteRecord($record_id, $file_path)
    {
        $statement = $this->conn->prepare('DELETE FROM files WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $record_id]);

        $_SESSION["is_deleted"] = ['success' => true, 'message' => 'Record deleted!'];

        if ($file_path !== '') {
            $absolute_file_path = $this->getAbsoluteFilePath($file_path);
            if (file_exists($absolute_file_path)) {
                unlink($absolute_file_path);
                $_SESSION["is_deleted"] = ['success' => true, 'message' => 'Record & File both removed!'];
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


    public function downloadFile($file_path)
    {
        $absolute_file_path = $this->getAbsoluteFilePath($file_path);
        if (file_exists($absolute_file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file_path));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            ob_clean();
            flush();
            readfile($file_path);
            exit;
        } else {
            echo json_encode(['message' => 'No file exists, or something went wrong']);
        }

        exit;
    }
}

// save data to database
if (isset($_POST['new_record'])) {
    $obj = new FormTask();
    $obj->save();
}


if (isset($_POST['file_download'])) {
    $file_path = $_POST['file_path'];
    $obj = new FormTask();
    $obj->downloadFile($file_path);
}

if (isset($_POST['delete_record'])) {
    $record_id = $_POST['record_id'];
    $file_path = $_POST['file_path'];
    $obj = new FormTask();
    $obj->deleteRecord($record_id, $file_path);
}
