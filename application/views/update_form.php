<html>
<head>
    <title>Update Links</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('update/do_upload');?>

<br>

Download current Link Database as CSV file  (Edit with Excel):
<br>
<a href="upload/downloadLinks">
   <button>Download Links</button>
</a>

<br>
<br>
<br>

Update Links by Uploading new CSV Here:
<br>
<input type='file' name='userfile' size='20' />

<br><br>

<input type='submit' value='upload'/>

</form>

</body>

</html>
