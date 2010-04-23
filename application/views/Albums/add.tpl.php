<?php if (!defined('FARI')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />

	<meta name="description" content="Fari Framework" />

	<title>Fari Framework</title>

	<link rel="stylesheet" type="text/css" media="screen" href="<?php url('/public/akrabat.css'); ?>" />
</head>

<body>
	<div id="content">
		<h1>Add an album</h1>

		<form action="<?php url('/albums/add/'); ?>" method="post">
			<table>
				<tr class="required">
					<th><label class="required">Artist:</label></th>
					<td><input type="text" class="text" name="artist" /></td>
				</tr>
				<tr class="required">
					<th><label class="required">Title:</label></th>
					<td><input type="text" class="text" name="title" /></td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td><input type="submit" class="button" name="login" value="Add" /></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>