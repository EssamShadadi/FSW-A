<?php

include "config.php";


if (isset($_POST["method"])) {
    
    
    if($_POST["method"] == "new-ticket") {
        try {

            $ticketCenterId = $_POST["ticketCenterId"];
            $ticketProblemDescription = $_POST["ticketProblemDescription"];
            $ticketProblemType = $_POST["ticketProblemType"];
            $ticketDeviceType = $_POST["ticketDeviceType"];
            $ticketEmployeeId = $_POST["ticketEmployeeId"];
            $ticketItSpecialistId = $_POST["ticketItSpecialistId"];
            $ticketOsVersion = $_POST["ticketOsVersion"];
            $ticketAffectedSoftware = $_POST["ticketAffectedSoftware"];
            // $ticketOsVersion = $_POST["ticketOsVersion"];
            $ticketErrorCode = $_POST["ticketErrorCode"];
            $ticketDeviceSN = $_POST["ticketDeviceSN"];
            

            // Handle file upload
            if (isset($_FILES['ticketScreenshot'])) {
                $file = $_FILES['ticketScreenshot'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileError = $file['error'];

                // Check if there was no file upload error
                if ($fileError === UPLOAD_ERR_OK) {
                    // Define the directory where you want to save the uploaded files
                    $uniqueId = uniqid(); // Generate a unique ID
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension
                    $newFileName = $uniqueId . '.' . $extension; // Append unique ID to the file name

                    $uploadDirectory = 'uploads/' . $newFileName;

                    // Move the uploaded file to the specified directory
                    if (move_uploaded_file($fileTmpName, $uploadDirectory)) {
                        // The file was successfully uploaded
                        $fileName = $newFileName; // Update the file name to the new unique name
                    } else {
                        // Handle the case where file upload failed
                        $result = json_encode(array('success' => false, 'msg' => 'Error moving uploaded file'));
                        echo $result;
                        exit;
                    }
                } else {
                    // Handle the case where file upload had an error
                    $result = json_encode(array('success' => false, 'msg' => 'File upload error: ' . $fileError));
                    echo $result;
                    exit;
                }
                // Prepare the SQL statement with placeholders
                $stmt = $pdo->prepare("INSERT INTO tickets ( ticketCenterId, ticketProblemDescription, ticketProblemType, ticketDeviceType, ticketEmployeeId, ticketItSpecialistId, ticketOsVersion, ticketAffectedSoftware,ticketErrorCode, ticketScreenshot, ticketDeviceSN) VALUES (:ticketCenterId, :ticketProblemDescription, :ticketProblemType, :ticketDeviceType, :ticketEmployeeId, :ticketItSpecialistId, :ticketOsVersion, :ticketAffectedSoftware, :ticketErrorCode, :ticketScreenshot, :ticketDeviceSN)");
    
                // Bind parameters
                $stmt->bindParam(':ticketCenterId', $ticketCenterId);
                $stmt->bindParam(':ticketProblemDescription', $ticketProblemDescription);
                $stmt->bindParam(':ticketProblemType', $ticketProblemType);
                $stmt->bindParam(':ticketDeviceType', $ticketDeviceType);
                $stmt->bindParam(':ticketEmployeeId', $ticketEmployeeId);
                $stmt->bindParam(':ticketItSpecialistId', $ticketItSpecialistId);
                $stmt->bindParam(':ticketOsVersion', $ticketOsVersion);
                $stmt->bindParam(':ticketAffectedSoftware', $ticketAffectedSoftware);
                $stmt->bindParam(':ticketErrorCode', $ticketErrorCode);
                $stmt->bindParam(':ticketDeviceSN', $ticketDeviceSN);
    
                $stmt->bindParam(':ticketScreenshot', $fileName); // Store the screenshot name in the database
    
                // Execute the statement
                if ($stmt->execute()) {
                    $result = json_encode(array('success' => true));
                } else {
                    $result = json_encode(array('success' => false, 'msg' => 'Error inserting ticket'));
                }
    
                echo $result;
            }else{

                // Prepare the SQL statement with placeholders
                $stmt = $pdo->prepare("INSERT INTO tickets ( ticketCenterId, ticketProblemDescription, ticketProblemType, ticketDeviceType, ticketEmployeeId, ticketItSpecialistId, ticketOsVersion, ticketAffectedSoftware,ticketErrorCode,  ticketDeviceSN) VALUES (:ticketCenterId, :ticketProblemDescription, :ticketProblemType, :ticketDeviceType, :ticketEmployeeId, :ticketItSpecialistId, :ticketOsVersion, :ticketAffectedSoftware, :ticketErrorCode,  :ticketDeviceSN)");
    
                // Bind parameters
                $stmt->bindParam(':ticketCenterId', $ticketCenterId);
                $stmt->bindParam(':ticketProblemDescription', $ticketProblemDescription);
                $stmt->bindParam(':ticketProblemType', $ticketProblemType);
                $stmt->bindParam(':ticketDeviceType', $ticketDeviceType);
                $stmt->bindParam(':ticketEmployeeId', $ticketEmployeeId);
                $stmt->bindParam(':ticketItSpecialistId', $ticketItSpecialistId);
                $stmt->bindParam(':ticketOsVersion', $ticketOsVersion);
                $stmt->bindParam(':ticketAffectedSoftware', $ticketAffectedSoftware);
                $stmt->bindParam(':ticketErrorCode', $ticketErrorCode);
                $stmt->bindParam(':ticketDeviceSN', $ticketDeviceSN);
    
    
                // Execute the statement
                if ($stmt->execute()) {
                    $result = json_encode(array('success' => true));
                } else {
                    $result = json_encode(array('success' => false, 'msg' => 'Error inserting ticket'));
                }
    
                echo $result;
            }


        } catch (PDOException $e) {
            echo json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }
} 