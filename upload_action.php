<?php
//files required for uploading excel sheet
require("PHPExcel.php");
require("PHPExcel/IOFactory.php");
require("functions.php");


$conn = connect(); //sql connection

//$upload_info = $_FILES;
$file = $_FILES["file"]["tmp_name"];
$file_name = $_FILES["file"]["name"];

$filesize = $_FILES["file"]["size"];
header("Content-Length: " . $filesize);
header('Cache-Control: no-cache');
//session_start();
$ext = pathinfo($file_name, PATHINFO_EXTENSION);
if ($ext == "xlsx") {
    $obj = PHPExcel_IOFactory::load($file);

    $sent_mail = 0;
    $failed_mail = 0;

    foreach ($obj->getWorksheetIterator() as $sheet) {

        $getHightestRow = $sheet->getHighestRow(); //get number of rows
		
        for ($i = 1; $i <= $getHightestRow; $i++) {
            $name = $sheet->getCellByColumnAndRow(0, $i)->getValue();
            $email = $sheet->getCellByColumnAndRow(1, $i)->getValue();

            if ($name != '' && $name != 'name') {
                $sql = $conn->prepare("INSERT INTO `users` (`id`,`name`, `email`, `added_date`, `updated_date`) 
                    VALUES (NULL, '$name', '$email', NOW(), NOW());");

                $res = $sql->execute();

              // $_SESSION['file'] = $i;

                if ($res) {
                    $email_res = sendEmail($email);
                    if ($email_res === 1) {
                        $last_id = $conn->lastInsertId();
                        $u_sql = $conn->prepare("UPDATE `users` SET `sent_email` = 'failed' WHERE `users`.`id` = $last_id;");
                        $result = $u_sql->execute();

                        $failed_mail++;
                    } else {
                        $sent_mail++;
                    }
                }
            }
        }

       // $_SESSION['file'] = 0;


    }

    
    $total_email = intval($sent_mail) + intval($failed_mail);
    echo "Total email send: ".$total_email;
	

} else {
    echo "<br> Only excel files can be uploaded <br> ";
}
