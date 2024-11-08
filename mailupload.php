<?php
if(!empty($_POST['name']) || !empty($_POST['email']) || !empty($_POST['mobile'])|| !empty($_POST['dob'])|| !empty($_POST['ms'])|| !empty($_POST['gen'])|| !empty($_POST['pan'])|| !empty($_POST['ban'])|| !empty($_POST['bn'])|| !empty($_POST['adn']) || !empty($_POST['ifsc']) || !empty($_FILES['file1']['name'])){


    $uploadedFile1 = '';
    if(!empty($_FILES["file1"]["type"])){
        $fileName = $_POST['name'] . '_' . $_FILES['file1']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file1"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["file1"]["type"] == "image/png") || ($_FILES["file1"]["type"] == "image/jpg") || ($_FILES["file1"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file1']['tmp_name'];
            $targetPath = "pics/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile1 = $fileName;
            }
        }
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $ms = $_POST['ms'];
    $gen = $_POST['gen'];
    $pan = $_POST['pan'];
    $ban = $_POST['ban'];
    $bn = $_POST['bn'];
    $adn = $_POST['adn'];
    $ifsc = $_POST['ifsc'];

    
    //include database configuration file
    include_once 'dbConfig.php';
    
    $insert = $db->query("INSERT into onb(empname,empemail,empph,empdob,empms,empgen,pan,ban,bn,adn,ifsc,pic) VALUES ('".$name."','".$email."','".$mobile."','".$dob."','".$ms."','".$gen."','".$pan."','".$ban."','".$bn."','".$adn."','".$ifsc."','".$uploadedFile1."')");
 
    echo $insert?'ok':'err';
}
?>