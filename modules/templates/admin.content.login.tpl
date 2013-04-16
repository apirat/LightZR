<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">	
	<title><?php echo HOST?> - Login</title>	
	<link rel="stylesheet" type="text/css" href="<?php echo HTTP?>static/css/admin.login.css">
</head>
<body>
<div id="outter">
<div id="header"><a href=""></a></div>
<div class="border"></div>
<div id="inner">
<div id="content">
<div id="boxleft"></div>
<div id="boxright">
    <form id="login-form" action="<?php echo URL?>" method="post">
		<fieldset>		
			<legend>Login</legend>			
			<label for="login">Email</label>
			<input type="text" id="username" name="email">
			<div class="clear"></div>
			<label for="password">Password</label>
			<input type="password" id="password" name="password">
			<div class="clear"></div>
		   <p align="center"><?php echo $this->loginerror?></p>
			<div class="clear"></div>
			<input type="submit" id="btnlogin" name="commit" value="Log in"><br>
			<div class="clear"></div>
		</fieldset>
	</form>	
</div>
<div class="clear"></div>
</div></div>
<div class="border"></div>
</div>
</body>
</html>
