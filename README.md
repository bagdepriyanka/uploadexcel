# uploadexcel #

## upload excel file ##

show progress bar while uploading the file

## send emails ##

send email to all uploaded users 
also show progress bar for the same

## download excel file ## 
once emails are send download an excel file
which show summary of total emails, sent emails and failed emails.

![picture alt](https://github.com/bagdepriyanka/uploadexcel/blob/main/sample_download.PNG "sample download")

## Instrcutions ## 
database connection settings can be done in connect() written in functions.php

Set your gmail account credtionals in sendEmail() written in functions.php
	$mail->Username = ""; //gmail username
    $mail->Password = ""; // gmail password, make sure 2 factor authentication of off the gmail account 
    $mail->SetFrom(""); // your gmail email id
	
## Notes ##
The sample of excel file format that can be uploaded and the db table is kept in docs folder. 

The progress bar and file download is not added yet.

only the file can be uploaded and the data will be uploaded to sql server.
