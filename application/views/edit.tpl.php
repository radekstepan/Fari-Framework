<?php if (!defined('FARI')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />

	<meta name="description" content="Fari MVC" />

	<title>Fari MVC</title>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php $this->url('/public/akrabat.css') ;?>" />
</head>

<body>
	<div id="content">
		<h1>Edit an album</h1>
		
		<form action="<?php $this->url('/albums/edit/'.$album['id']) ;?>" method="post">
			<table>
				<tr class="required">
					<th><label class="required">Artist:</label></th>
					<td><input type="text" class="text" name="artist" value="<?php echo $album['artist'] ?>" /></td>
				</tr>
				<tr class="required">
					<th><label class="required">Title:</label></th>
					<td><input type="text" class="text" name="title" value="<?php echo $album['title'] ?>" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td><input type="submit" class="button" name="login" value="Edit" /></td>
				</tr>
			</table>
		</form>
		
		<p id="footer">
                    Logged in as: <b><?php echo $user ;?></b> <a href="<?php $this->url('login/logout') ;?>">Logout</a>
                    <br />
                    <span style="font-size:80%;">Executed
                    <?php echo $_SESSION['Fari\Benchmark\Queries'] ;?> database queries using
                    <?php echo Fari_Benchmark::getMemory() ;?> of memory in
                    <?php echo Fari_Benchmark::getTime() ;?></span>
                </p>
	</div>
</body>
</html>