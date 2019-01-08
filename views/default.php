<?php
if(!defined("_WEB_PATH_"))
	die;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo _SITE_NAME_; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<base href="<?php echo _WEB_PATH_; ?>">

	<script>
		var _VIEW_WEB_PATH_ = '<?php echo _VIEW_WEB_PATH_;?>';
	</script>

	<!-- css -->
	<link href="<?php echo _VIEW_WEB_PATH_; ?>css/style.css" rel="stylesheet">
	<link href="<?php echo _VIEW_WEB_PATH_; ?>css/custom.css" rel="stylesheet">

</head>
<body>
	<div class=" container-scroller">
		<!-- partial:partials/_navbar.html -->
		<nav class="navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
			<div class="bg-white text-center navbar-brand-wrapper">
				<a class="navbar-brand brand-logo" href="home"><img src="views/images/logo.png" /></a>
				<a class="navbar-brand brand-logo" href="index.html">  </a>
			</div>
			<div class="navbar-menu-wrapper d-flex align-items-center">
						<a  class="nav-link"  href="<?php echo Tools::getPageLink("profile/logout"); ?>" title="Logout">LOGOUT</i></a>

			</div>
		</nav>

    <!-- partial -->
		<div class="container-fluid">
			<div class="row row-offcanvas row-offcanvas-right">

				<!-- partial -->
				<div class="content-wrapper">

					<?php
					if($sessionobj['msg'] != '')
					{
						echo "<div class='height-45'>";

						if($sessionobj['msgtype'] == 'success')
							echo "<div class='notify_message alert alert-success'><button class='close' data-dismiss='alert'>×</button><strong>Success! </strong>".$sessionobj['msg']."</div>";
						else
							echo "<div class='notify_message alert alert-danger'><button class='close' data-dismiss='alert'>×</button><strong>Error! </strong>".$sessionobj['msg']."</div>";

						echo "</div>";
					}

					if(file_exists(_VIEW_PATH_.$view_page.".php"))
						include(_VIEW_PATH_.$view_page.".php");
					else
						include(_VIEW_PATH_."404.php");
					?>
				</div>
				<!-- partial -->
			</div>
		</div>
	</div>
</body>
</html>
