<head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <?php
    if (ENVIRONMENT == "production") {
        $meta_desc = isset($meta_description) ? $meta_description : 'SMARTCardMarket';
        $meta_key = isset($meta_keywords) ? $meta_keywords : 'SMARTCardMarket';
        ?>
        <meta name="description" content="<?php echo $meta_desc; ?>" />
        <meta name="keywords" content="<?php echo $meta_key; ?>" />
        <meta name="google-site-verification" content="a8CyGLF61oAfNFnum1IMolCwn6JPYoJNbvfnUm9OiR8" />
        <?php
    } else {
        ?>
        <meta name="robots" content="noindex,nofollow"/>
        <?php
    }
    ?>
    <script type="text/javascript">
        var base_url = "<?php echo $this->config->base_url(); ?>";
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $this->config->base_url(); ?>styles/images/favicon-smartcard.png" 
          type="image/png">

    <link href="<?php echo $this->config->base_url(); ?>styles/css/bootstrap.min.css?v=<?php echo $this->config->item('version','smartcardmarket');?>" rel="stylesheet"/>
    <!--<link href="<?php echo $this->config->base_url(); ?>styles/css/bootstrap-theme.min.css" rel="stylesheet"/>-->
    <link href="<?php echo $this->config->base_url(); ?>styles/css/style.css?v=<?php echo $this->config->item('version','smartcardmarket');?>" rel="stylesheet"/>

    <script src="<?php echo $this->config->base_url(); ?>styles/js/jquery-1.12.1.min.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $this->config->base_url(); ?>styles/js/bootstrap.min.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>
    <script src="<?php echo $this->config->base_url(); ?>styles/js/bootstrap-datetimepicker.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>   
    <link href="<?php echo $this->config->base_url(); ?>styles/css/bootstrap-datetimepicker.css?v=<?php echo $this->config->item('version','smartcardmarket');?>" rel="stylesheet"/>
    <script src="<?php echo $this->config->base_url(); ?>styles/js/moment.min.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>
    <script src="<?php echo $this->config->base_url(); ?>styles/js/moment-timezone-with-data.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>
    <script src="<?php echo $this->config->base_url(); ?>styles/js/project.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>
    <script src="<?php echo $this->config->base_url(); ?>styles/js/jquery.countdown.min.js?v=<?php echo $this->config->item('version','smartcardmarket');?>"></script>
</head>
<body>