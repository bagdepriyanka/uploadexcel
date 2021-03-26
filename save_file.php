<?php
//files required for uploading excel sheet
require("PHPExcel.php");
require("PHPExcel/IOFactory.php");
require("functions.php");

session_start();
$file = $_FILES["file"]["tmp_name"];
$file_name = $_FILES["file"]["name"];

$ext = pathinfo($file_name, PATHINFO_EXTENSION);
if ($ext == "xlsx") {

    $obj = PHPExcel_IOFactory::load($file);

    $sent_mail = 0;
    $failed_mail = 0;

    $total_recs = 0;
    foreach ($obj->getWorksheetIterator() as $sheet) {

        $getHightestRow = $sheet->getHighestRow(); //get number of rows
        $total_recs = $getHightestRow - 1;
    }

    $_SESSION['total_recs'] = $total_recs;
    session_write_close();
    
    $dest = "import_files/" . time() . "_" . $file_name;

    $flag = move_uploaded_file($_FILES['file']['tmp_name'], $dest);

    header("Location: index.php?upload=true");
    $shell_res = shell_exec("php process_file.php $dest 2>&1");
} else {
    echo "<br> Only excel files can be uploaded <br> ";
}
