<?php
// Access key validation code
$accessKeysFile = "access_keys.txt";
$accessKeys = file_exists($accessKeysFile) ? file($accessKeysFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$accessKey = $_GET['access_key'] ?? '';

if (!in_array($accessKey, $accessKeys)) {
    echo "Unauthorized access.";
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['fileToUpload'])) {
    echo "No file was selected for upload.";
    exit;
}

// Check for upload errors
$fileError = $_FILES['fileToUpload']['error'];
if ($fileError !== UPLOAD_ERR_OK) {
    // Display error based on PHP's file upload error codes
    switch ($fileError) {
        case UPLOAD_ERR_INI_SIZE:
            echo "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo "The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "The uploaded file was only partially uploaded.";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "No file was uploaded.";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo "Missing a temporary folder.";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo "Failed to write file to disk.";
            break;
        case UPLOAD_ERR_EXTENSION:
            echo "File upload stopped by a PHP extension.";
            break;
        default:
            echo "Unknown upload error.";
            break;
    }
    exit;
}

// Directory to store uploaded images
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if the file is an image
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($check === false) {
    echo "File is not an image.";
    exit;
}

// Check file size (limit to 5MB)
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    exit;
}

// Allow only certain file formats
$allowedTypes = ["jpg", "jpeg", "png", "gif"];
if (!in_array($imageFileType, $allowedTypes)) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    exit;
}

// Ensure unique filenames by appending a timestamp
$uniqueFileName = $targetDir . time() . "_" . basename($_FILES["fileToUpload"]["name"]);

// Move the uploaded file to the target directory
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uniqueFileName)) {
    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    header("Location: index.php?access_key=$accessKey");
    exit;
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
