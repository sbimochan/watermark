<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Watermark</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

  </head>
  <body style="overflow-x:hidden;">
    <form enctype="multipart/form-data" method="post" action="upload.php" class="form-horizontal">
<fieldset>
  <div class="jumbotron">
    <h1>Watermark Generator</h1>
    <p>
      Click Download in Next Page
    </p>

  </div>
  <div class="form-group">
    <label class="col-md-4 control-label">Upload From Here</label>
    <div class="col-md-4">
      <input name="uploaded_file" class="input-file" type="file">
    </div>
  </div>


  <div class="form-group">
    <label class="col-md-4 control-label" for="button1id"></label>
    <div class="col-md-8">
  <input type="submit" class="btn btn-success" value="Upload It"/>
  <input type="reset" class="btn btn-danger" value="Reset"/>
</div>
</div>

</fieldset></form>

<script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
   </body>

</html>
