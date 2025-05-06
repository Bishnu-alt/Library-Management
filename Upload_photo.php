<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['member']); 

$member_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['photo'])) {
    $upload_dir = 'Uploads/';
    $file_name = time()."_".basename($_FILES["photo"]["name"]);
    $target_file = $upload_dir.$file_name;

    $check = getimagesize($_FILES["photo"]["tmp_name"]);

    if($check !== false){
        if(move_uploaded_file($_FILES["photo"]["tmp_name"],$target_file)){
            $sql = "UPDATE members SET photo = '$file_name' WHERE user_id = '$member_id'";
            if(mysqli_query($conn,$sql)){
                echo "Photo uploaded successfully.";
                
            }else {
                echo "Data update failed".mysqli_error($conn);
            }
        }else {
            echo "Error moving uploaded file.";
        }
    }else {
        echo "File is not an image.";
    }

}

?>
<h2>Upload Your Profile Photo</h2>
<form method="post" enctype="multipart/form-data">
    <label for="photo">Select Photo:</label>
    <input type="file" name="photo" accept="image/*" required><br><br>
    <button type="submit">Upload</button>
</form>