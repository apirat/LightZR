<div id="member">
<form method="post" action="<?php echo URL?>">
<table cellpadding="0" cellspacing="3" border="0" width="100%">
<tr><th>Email</th><td><input type="text" name="email" size="15" class="tbox"></td></tr>
<tr><th>Password</th><td><input type="password" name="password" size="15" class="tbox"></td></tr>
<tr><th></th><td><input type="submit" value="Login" class="submit"></td></tr>
</table>
</form>
<p style="text-align:center; margin:5px 0px; font-size:9px"><a href="javascript:;" onClick="return false">Sign up</a> | <a href="javascript:;" onClick="return false">Forget a password</a></p>
</div>
<script type="text/javascript">
if(MY_ID!='MY_ID')
{
	$('#member').html('<ul><li><a'+' href'+'="'+'<?php echo PATHMIN?>'+'">'+'Adm'+'in A'+'rea</a></li><li><a href="<?php echo HTTP?>logout">Logout</a></li></ul>');
}
</script>
<style type="text/css">
#member th{ text-align:right; font-size:9px;}
#member ul li{list-style:inside circle; line-height:18px; height:18px;}
#member ul{margin-left:15px}
</style>