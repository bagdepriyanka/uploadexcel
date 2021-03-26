<?php
require("PHPExcel.php");
require("PHPExcel/IOFactory.php");
require("functions.php");


$file = $argv[1];

$conn = connect(); //sql connection

$obj = PHPExcel_IOFactory::load($file);

foreach ($obj->getWorksheetIterator() as $sheet) {
	$getHightestRow = $sheet->getHighestRow();

	for ($i = 1; $i <= $getHightestRow; $i++) {

		$name = $sheet->getCellByColumnAndRow(0, $i)->getValue();
		$email = $sheet->getCellByColumnAndRow(1, $i)->getValue();

		if ($name != '' && $name != 'name') {
			$sql = $conn->prepare("INSERT INTO `users` (`id`,`name`, `email`, `added_date`, `updated_date`) 
                    VALUES (NULL, '$name', '$email', NOW(), NOW());");

			$res = $sql->execute();


			if ($res) {
				$email_res = sendEmail($email);
				if ($email_res != 1) {
					$last_id = $conn->lastInsertId();
					$u_sql = $conn->prepare("UPDATE `users` SET `sent_email` = 'failed' WHERE `users`.`id` = $last_id;");
					$result = $u_sql->execute();	
				} 
			}
		}

		sleep(5);
		file_put_contents("count.txt", $i);
	}
}
