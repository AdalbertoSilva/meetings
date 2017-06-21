<html>
<head>
    <!--Le CSS==========================================================-->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet">

    <!--Le JavaScript
    ==========================================================-->
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <title>Ola Mundo!</title>
</head>
<body>
<div class="well" style="width:50%; margin: 0 auto;">
    <?php $attributes = array("name" => "comment-form");
    echo form_open("user_comments/submit", $attributes);?>
    <div class="form-group">
        <textarea name="comment" placeholder="Your comments..." rows="4" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Post Comment" class="btn btn-danger">
    </div>
    <?php echo form_close(); ?>
</div>
</body>
</html>