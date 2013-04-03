<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
	<title>Graf4Design - Accueil</title>
	<link rel="stylesheet" href="css/style.css">
	<link href="zoombox/zoombox.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="zoombox/zoombox.js"></script>
    <script type="text/javascript">
		jQuery(function($){
		$('a.zoombox').zoombox();


		});
	</script>
</head>
<body>
<div class="content">
	<div class="container">
		<?php include 'header.inc.php'; ?>
		<?php
		if (!empty($_GET['page'])) {
			$page = strtolower($_GET['page']);
			$page_inc = 'pages/'.$page.'.php';
			if (file_exists($page_inc)) {
				include ($page_inc);
			}
			else {
				echo '<h2>Erreur 404</h2>';
				echo '<p>La page demandée n\'existe pas</p>';
			}
		}
		else { ?>
		<div class="featured-post">
			<div class="last-post">
			<?php
			if (isset($_GET['id'])) {
				require 'config.php';
				mysql_query("SET NAMES'utf8'");
				$sql="SELECT * FROM news WHERE id={$_GET['id']} ORDER BY id DESC LIMIT 0, 1";
				$req=mysql_query($sql) or die(mysql_error());
				while ($data=mysql_fetch_assoc($req)) {
					echo "<a href=\"index.php?page=view&id={$data['id']}\">";
					echo "<img src=\"{$data['image']}\">";
					echo "</a>";
					echo "<h2>{$data['title']}</h2>";
					echo "<p>{$data['message']}</p>";
				}
			}
			else{
				require 'config.php';
				mysql_query("SET NAMES'utf8'");
				$sql="SELECT * FROM news ORDER BY id DESC LIMIT 0, 1";
				$req=mysql_query($sql) or die(mysql_error());
				while ($data=mysql_fetch_assoc($req)) {
					echo "<a href=\"index.php?page=view&id={$data['id']}\">";
					echo "<img src=\"{$data['image']}\">";
					echo "</a>";
					echo "<h2>{$data['title']}</h2>";
					echo "<p>{$data['message']}</p>";
				}
			}
			?>
			</div>
				<?php
					require 'config.php';

					$sql="SELECT COUNT(id) as nbArt FROM news";
					$req=mysql_query($sql) or die(mysql_error());
					$data=mysql_fetch_assoc($req);

					$nbArt=$data['nbArt'];
					$perPage=5;
					$nbPage = ceil($nbArt/$perPage);

					if (isset($_GET['pageid']) && $_GET['pageid']<=$nbPage) {
						$cPage = $_GET['pageid'];
					}
					else{
						$cPage = $_GET['pageid']=1;
					}

					?>
					<div class="before-last-img">
					<div class="last-img">
					<?php
					$sql="SELECT * FROM news ORDER BY id DESC LIMIT ".(($cPage-1)*$perPage).", $perPage";
					$req=mysql_query($sql) or die(mysql_error());
					mysql_query("SET NAMES'UTF8'");
					while ($data=mysql_fetch_assoc($req)) {
						echo "<a href=\"index.php?pageid={$_GET['pageid']}&id={$data['id']}\">";
						echo "<img src=\"{$data['image']}\">";
						echo "</a>";
					} 
					?>
					</div>
					</div>
					<div class="pagination-posts">
					<?php
					for($i=1;$i<=$nbPage;$i++){
						if ($i==$cPage) {
							echo "<span class=\"news-pagination-active\">$i</span>";
						}
						else{
							echo "<a class=\"news-pagination\" href=\"index.php?pageid=$i\">$i</a>";
						}
					}
					?>
					</div>
			</div>
		</div>
		<?php include 'sidebar.inc.php'; ?>
		<?php } ?>
		<?php include 'footer.inc.php'; ?>
	</div>
</div>
</body>
</html>
