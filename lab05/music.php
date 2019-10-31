<!DOCTYPE html>
<html lang="en">

<head>
	<title>Music Library</title>
	<meta charset="utf-8" />
	<link href="https://selab.hanyang.ac.kr/courses/cse326/2019/labs/images/5/music.jpg" type="image/jpeg" rel="shortcut icon" />
	<link href="https://selab.hanyang.ac.kr/courses/cse326/2019/labs/labResources/music.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<h1>My Music Page</h1>

	<!-- Ex 1: Number of Songs (Variables) -->
	<?php 
	$song_count=123;
	$song_hour = (int)($song_count/10);
	?>
	<p>
		I love music.
		I have <? echo $song_count?>total songs,
		which is over <? echo $song_hour?>hours of music!
	</p>
	<!-- Ex 2: Top Music News (Loops) -->
	<!-- Ex 3: Query Variable -->
	<div class="section">
		<h2>Billboard News</h2>
		<?php 
		if(isset($_GET["newspages"])){
			$newspages = (int)$_GET["newspages"];
		}
		else{
			$newspages = 5;
		}
		?>

		<ol>
			<?php for($news_pages=1;$news_pages<=$newspages;$news_pages++){ 
				$x = 12-$news_pages;
				if($x<10){
					$link = "0" . ($x-1);
					$x = "0" . $x;
				}
				else{
					if($x==10){ $link = "0" . ($x-1); }
					else {$link = ($x-1);}
				}
				$result = "https://www.billboard.com/archive/article/2019" . $link;

				?>
				<li><a href="<?php echo $result; ?>">2019-<?=$x?></a></li>
			<?php } ?>
		</ol>
	</div>

	<!-- Ex 4: Favorite Artists (Arrays) -->
	<!-- Ex 5: Favorite Artists from a File (Files) -->
	<div class="section">
		<h2>My Favorite Artists</h2>

		<?php 
		$lines = file("favorite.txt");
		?>

		<ol>
			<?php foreach ($lines as $line) {
				$url = "http://en.wikipedia.org/wiki/" . $line; ?>
				<li><a href="<?php echo $url; ?>"><?= $line ?></a></li>
			<?php } ?>
		</ol>
	</div>

	<!-- Ex 6: Music (Multiple Files) -->
	<!-- Ex 7: MP3 Formatting -->
	<div class="section">
		<h2>My Music and Playlists</h2>

		<ul id="musiclist">
			<?php 
			function cmp($a, $b)
			{
				if (filesize($a) == filesize($b)) {
					return 0;
				}
				return (filesize($a) < filesize($b)) ? 1 : -1;
			}

			$files = glob("lab5/musicPHP/songs/*.mp3");
			usort($files, "cmp");
			foreach($files as $filename){?>
				<li class="mp3item"><a href="<? print_r($filename,true)?>"><?= print_r(basename($filename),true);?></a>
					<?php print "(" . (int)(filesize($filename)/1024) . " KB)";?>
				</li>
			<?php } ?>
			<!-- Exercise 8: Playlists (Files) -->


			<?php 
			$m3ufiles = glob("lab5/musicPHP/songs/*.m3u");
			foreach (array_reverse($m3ufiles) as $m3ufile) {
				$name = print_r(basename($m3ufile),true);?>
				<li class="playlistitem"><?= $name ?></li>
				<ul>
					<?php
					$lines = file($m3ufile);
					shuffle($lines);
					foreach ($lines as $line) { 
						if(strpos($line, '#')===false){?>
							<li><?= $line; ?> </li>
						<?php }
						else{
							continue;
						} ?>
					<?php } ?>
				</ul>
			<?php } ?>
		<!-- <li class="playlistitem">326-13f-mix.m3u:</li>
		<ul>
			<li>Basket Case.mp3</li>
			<li>All the Small Things.mp3</li>
			<li>Just the Way You Are.mp3</li>
			<li>Pradise City.mp3</li>
			<li>Dreams.mp3</li>
		</ul>
		<li class="playlistitem">mypicks.m3u:</li>

		<li class="playlistitem">playlist.m3u:</li> -->
	</ul>
</div>

<div>
	<a href="https://validator.w3.org/check/referer">
		<img src="https://selab.hanyang.ac.kr/courses/cse326/2019/labs/images/w3c-html.png" alt="Valid HTML5" />
	</a>
	<a href="https://jigsaw.w3.org/css-validator/check/referer">
		<img src="https://selab.hanyang.ac.kr/courses/cse326/2019/labs/images/w3c-css.png" alt="Valid CSS" />
	</a>
</div>
</body>
</html>
