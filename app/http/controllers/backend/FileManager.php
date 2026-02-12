<?php 

namespace app\http\controllers\backend;
use core\Request;



class FileManager 
{

    public function Index(){

        return view("/backend/file_manager/index");
    }

    public function StoreFile(Request $request){
        $uploadDir = public_path("/uploads/file_manager/");

        // Check if the 'files' key is set (this will be an array of files)
        if (isset($_FILES['files'])) {
            $uploadedFiles = $_FILES['files'];
            $uploadedFileNames = [];
        
            // Loop through all uploaded files
            foreach ($uploadedFiles['name'] as $index => $fileName) {
                // Get the temporary file path and the destination file path
                $tempPath = $uploadedFiles['tmp_name'][$index];
                $destination = $uploadDir .hexdec(uniqid()) ."-" .  preg_replace('/[^\w\.]+/', '', basename($fileName));
        
                // Ensure the upload directory exists
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
                }
        
                // Try to move the uploaded file
                if (move_uploaded_file($tempPath, $destination)) {
                    $uploadedFileNames[] = $fileName; // Add to the list of successfully uploaded files
                } else {
                    echo json_encode(['error' => 'Failed to upload file: ' . $fileName]);
                    exit;
                }
            }
        
            // If all files uploaded successfully, return a success message
            echo json_encode([
                'message' => 'Files uploaded successfully!',
                'uploaded_files' => $uploadedFileNames
            ]);
        } else {
            echo json_encode(['error' => 'No files were uploaded']);
        }
    }

    public function GetFile(){

        // Define the upload directory
        $uploadDir = public_path("/uploads/file_manager/");

        // Check if the directory exists
        if (!is_dir($uploadDir)) {
            echo json_encode(['error' => 'Directory not found']);
            exit;
        }

        // Get all the files in the directory
        $files = scandir($uploadDir);

        // Remove '.' and '..' from the array (they are not real files)
        $files = array_diff($files, array('.', '..'));

        // Filter only image files (you can customize this to support other file types)
        $imageFiles = array_filter($files, function($file) use ($uploadDir) {
            $filePath = $uploadDir . $file;
            return is_file($filePath) && exif_imagetype($filePath); // Check if it's an image
        });

        // If there are no files, return an error message
        if (empty($imageFiles)) {
            echo json_encode(['message' => 'No image files found']);
            exit;
        }

        // Return the list of image files and their paths as a JSON response
        $imageData = array_map(function($file) use ($uploadDir) {
            return [
                'name' => $file,
                'url' => "/uploads/file_manager/" . $file  // Provide the URL to the image
            ];
        }, $imageFiles);

        echo json_encode(['files' => $imageData]);


    }

    public function DeleteFile(){


            // Read the incoming request
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            // Check if the imageName exists in the request
            if (isset($data['imageName'])) {
                $imageName = $data['imageName'];

                // Define the path to your image directory
                $imagePath = public_path($imageName) ; // Make sure the 'images' directory is correct

                // Check if the image exists
                if (file_exists($imagePath)) {
                    // Attempt to delete the image
                    if (unlink($imagePath)) {
                        // Respond with success
                        echo json_encode(['success' => true]);
                    } else {
                        // Respond with failure
                        echo json_encode(['success' => false, 'message' => 'Failed to unlink image']);
                    }
                } else {
                    // Respond if the image doesn't exist
                    echo json_encode(['success' => false, 'message' => 'Image not found']);
                }
            } else {
                // Respond if imageName is not provided
                echo json_encode(['success' => false, 'message' => 'No image name provided']);
            }


    }
}
