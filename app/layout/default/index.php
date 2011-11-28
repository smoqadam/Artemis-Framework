<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php 
$this->setSeparator(' | ');  

$this->setTitle('Artemis Framework');
echo $this->title?></title>
</head>

<body>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td height="64" bgcolor="#CCCCCC"><h1>Artemis Framework</h1></td>
  </tr>
  <tr>
    <td height="288" valign="top"><?php echo $this->content;?>&nbsp;</td>
  </tr>
  <tr>
    <td height="40" align="center" bgcolor="#CCCCCC">phpro.ir</td>
  </tr>
</table>
</body>
</html>