<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo CSS_FOLDER?>ui/jquery-ui.css" type="text/css" rel="stylesheet" />
<link href="<?php echo CSS_FOLDER?>style.css" type="text/css" rel="stylesheet" />
<title>
<?php 
$this->setSeparator(' - ');  
$this->setTitle('Artemis Framework');
echo $this->title?>
</title>
</head>

<body>
<div class="content">
<div class="logo">
  <a href="http://artemisframework.com" title="فریم ورک آرتمیس"> <img src="<?php echo IMG_FOLDER?>logo.jpg" /></a>
</div>
<div class="clearheader"></div>
<div class="main ui-widget-content">
<?php echo $this->content?>
</div>
<div class="clearfooter"></div>
	<div class="footer">
    	Copyright (c) 2011 - 2012 ,Artemis Framework team.All rights reserved.<br />
			Powered by Artemis Framework.
    </div>
</div>
</body>
</html>