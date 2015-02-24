<form action="<?php echo Yii::app()->request->baseUrl;?>/site/register" method="POST">
	<?php if(isset($error)){?> <label><?php echo $error;?></label> <?php }?>
	<label>Username:</label><input name="username" value="<?php if(isset($username)){?> <?php echo $username;?> <?php }?>" type="text" />
	<label>Password:</label><input name="password" value="<?php if(isset($password)){?> <?php echo $password;?> <?php }?>" type="password" />
    <input type="submit" value="submit">
</form>
