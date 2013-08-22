<?php
$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';
$bodyClass = $input->get->modal ? 'modal' : '';
if(!isset($content)) $content = '';
$config->styles->prepend($config->urls->adminTemplates . "styles/jqueryui/jqui.css");
$config->styles->prepend($config->urls->adminTemplates . "styles/style.css");
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js");
$config->scripts->append($config->urls->adminTemplates . "scripts/jquery.collagePlus.min.js");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<title><?php echo strip_tags($page->get("browser_title|headline|title|name")); ?> &rsaquo; ProcessWire</title>
	<script type="text/javascript">
	<?php
	$jsConfig = $config->js();
	$jsConfig['debug'] = $config->debug;
	$jsConfig['urls'] = array(
		'root' => $config->urls->root,
		'admin' => $config->urls->admin,
		'modules' => $config->urls->modules,
		'core' => $config->urls->core,
		'files' => $config->urls->files,
		'templates' => $config->urls->templates,
		'adminTemplates' => $config->urls->adminTemplates,
		);
	?>
	var config = <?php echo json_encode($jsConfig); ?>;
	</script>
	<?php foreach($config->styles->unique() as $file) echo "\n\t<link type='text/css' href='$file' rel='stylesheet' />"; ?>
	<!--[if lt IE 9 ]>
	<link rel="stylesheet" type="text/css" href="<? echo $config->urls->adminTemplates ?>styles/ie.css" />
	<![endif]-->
	<?php foreach($config->scripts->unique() as $file) echo "\n\t<script type='text/javascript' src='$file'></script>"; ?>
</head>

<?php if($user->isGuest()):?>


<body id="branded" class="login">
	
	<div class="login-box">
		<div id="logo">
        	<img src="<?php echo $config->urls->adminTemplates ?>styles/images/pw-logo.png">
        </div>
        <div class="login-form">
        	<?php echo $content?>
        </div>
	    <?php if(count($notices)) include("notices.inc"); ?>
	    <div id="skyline"></div>
	</div>
	<script>
	$(document).ready(function() {
		$(".Inputfields > .Inputfield > .ui-widget-header").unbind('click');
	});
	</script>
</body>


<?php else: ?>


<body <?php if($bodyClass) echo " class='$bodyClass'"; ?> >
	<div id="wrapper">

		<div id="sidebar">
			<div class="container">
				<div id="header">
					
					<img width="170" class=" logo" src="<?php echo $config->urls->adminTemplates ?>styles/images/logo.png">
					<h1><?php echo strip_tags($this->fuel->processHeadline ? $this->fuel->processHeadline : $page->get("title|name")); ?></h1>
			    	<?php if(trim($page->summary)) echo "<h2>{$page->summary}</h2>"; ?>
				
				</div>
				<div class="nav-wrap">					
					<?php include("topnav.inc"); ?>
					<?php echo $searchForm; ?>
				</div>

				<div id="user-menu">
					
					<?php $gravatar = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=mm&s=50"; ?>
					<?php if ($gravatar): ?>
						<?php $edit = __("Edit Profile"); ?>
						<?php if ($user->hasPermission('profile-edit')) echo "<a title='{$edit}' class='tooltip' href='{$config->urls->admin}profile/'>" ?>
						<img class="gravatar" src="<?php echo $gravatar; ?>" alt="">
						<?php if ($user->hasPermission('profile-edit')) echo "</a>" ?>
					<?php endif ?>
										
					<div class="user-menu">
						<?php if ($user->hasPermission('profile-edit')) echo "<a title='{$edit}' class='user-name tooltip' href='{$config->urls->admin}profile/'>{$user->name}</a>" ?><br>
						<a class="user-logout" href='<?php echo $config->urls->admin; ?>login/logout/'><?php echo __('logout', __FILE__); ?></a>
					</div>
				</div>
			</div>


		</div>
		
		
		
		<div id="main">

			<div id="bread">
				<div class="container">
					<ul id="breadcrumbs">
					<?php
						foreach($this->fuel('breadcrumbs') as $breadcrumb) {
							$class = strpos($page->path, $breadcrumb->path) === 0 ? " class='active'" : '';
							$title = htmlspecialchars(strip_tags($breadcrumb->title));
							echo "<li $class><a href='{$breadcrumb->url}'>{$title} </a> &rsaquo; </li>";
						}
					?>
					<li class="fright"><a target="_blank" id="view-site" href="<?php echo $config->urls->root; ?>">View Site</a></li>
					</ul>
				</div>
			</div>

			<div class="container">
				<?php if(count($notices)) include("notices.inc"); ?>
			    <div id="content" class="fouc_fix">
					<div class="container">
						<?php if($page->body) echo $page->body; ?>
						<?php echo $content?>
						<?php if($config->debug && $this->user->isSuperuser()) include($config->paths->adminTemplates . "debug.inc"); ?>
					</div>
				</div>
			</div>

			<div id="footer">
				<div class="container">
					<p class="copy fright"><a href="http://processwire.com/">ProcessWire</a> <?php echo $config->version; ?> - Copyright &copy; <?php echo date("Y"); ?> by Ryan Cramer</p>
				</div>
			</div>


		</div>
	</div>
	


</body>
<?php endif; ?>
</html>