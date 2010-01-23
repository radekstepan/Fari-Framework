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
		<?php if (isset($messages)) foreach($messages as $message): ?>
			<div class="flash <?php echo $message['status'] ;?>"><?php echo $message['message'] ;?></div>
		<?php endforeach ;?>
		
		<h1>My Albums</h1>
		
		<p><a href="<?php $this->url('albums/add/') ;?>">Add a new album</a></p>
		
		<p> Pages: 
			<?php foreach ($paginator['paginator'] as $page): ?>
                <a href="
                    <?php $this->url('albums/index/'.$page['number']) ;?>
                   "><?php echo ($page['class'] == 'current') ? '<b>'.$page['number'].'</b>' : $page['number']; ?></a>&nbsp;
			<?php endforeach ;?>
		</p>
		
		<table class="grid">
			<tr>
				<th>Title</th>
				<th>Artist</th>
				<th>&nbsp;</th>
			</tr>
			<?php foreach ($paginator['items'] as $album): ?>
			<tr>
				<td><?php echo $album['title'] ;?></td>
				<td><?php echo $album['artist'] ;?></td>
				<td>
					<a href="<?php $this->url('albums/edit/'.$album['id']) ;?>">Edit</a>
					<a href="<?php $this->url('albums/delete/'.$album['id']) ;?>">Delete</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	
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