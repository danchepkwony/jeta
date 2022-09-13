<?php
/**
 * The header for the theme
 *
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Connecting people to God, their communities, and their bodies" />    
	<title>Jeta</title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
<a class="screen-reader-text" lang="sq" href="#nav-container">Kalo te menyja</a>
<a class="screen-reader-text" lang="en" href="#nav-container">Skip to menu</a>

<a class="screen-reader-text" lang="sq" href="#content">Kalo te përmbajtja</a>
<a class="screen-reader-text" lang="en" href="#content">Skip to content</a>

<header>
	<a href="/"><img src="<?php echo THEME_IMG_PATH; ?>/jeta.jpeg" alt="Jeta"/></a>
	<div id="nav-container" class="right-items">
		<nav class="desktop-nav">
			<a lang="sq" class="donate" href="/donate">Jap</a>
			<a lang="sq" href="/about">Rreth</a>
			<a lang="sq" href="/programs">Programet</a>
			<a lang="sq" href="/contact">Kontaktoni</a>
			<a lang="en" class="donate" href="/donate">Give</a>
			<a lang="en" href="/about">About</a>
			<a lang="en" href="/programs">Programs</a>
			<a lang="en" href="/contact">Contact</a>
		</nav>
		<div class="translator">
			<img src="<?php echo THEME_IMG_PATH; ?>/albania.svg" alt="Albanian"/>
			<input id="translate" type="checkbox"/>
			<label for="translate"></label>
			<img src="<?php echo THEME_IMG_PATH; ?>/united-kingdom.svg" alt="English"/>
		</div>
		<button id="show-nav" class="show-nav">
			<img src="<?php echo THEME_IMG_PATH; ?>/mobileMenu.png" alt="Show navigation menu"/>
		</button>
	</div>
	<nav id="mobile-nav" class="mobile-nav">
		<button id="hide-nav" class="hide-nav">
			<img src="<?php echo THEME_IMG_PATH; ?>/x.svg" alt="Hide navigation menu"/>
		</button>
		<a lang="sq" href="/">Shtëpi</a>
		<a lang="sq" href="/donate">Jap</a>
		<a lang="sq" href="/about">Rreth</a>
		<a lang="sq" href="/programs">Programet</a>
		<a lang="sq" href="/contact">Kontaktoni</a>
		<a lang="en" href="/">Home</a>
		<a lang="en" href="/donate">Give</a>
		<a lang="en" href="/about">About</a>
		<a lang="en" href="/programs">Programs</a>
		<a lang="en" href="/contact">Contact</a>
	</nav>
	
</header>

<div id="content" class="site-content">
	