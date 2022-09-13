<?php
get_header();
include("models/Location.php");
include("models/Copy.php");

$albanianCopy = $albanianCopyPost->getContactText();
$englishCopy = $englishCopyPost->getContactText();
?>

<main class="contact">
	<div class="text">
        <h1 lang="sq"><?php echo $albanianCopy['title']; ?></h1>
		<h1 lang="en"><?php echo $englishCopy['title']; ?></h1>
        <div>
            <img src="<?php echo THEME_IMG_PATH?>/phone.svg"/>
            <span lang="sq"><?php echo $albanianCopy['phoneNumber']; ?></span>
		    <span lang="en"><?php echo $englishCopy['phoneNumber']; ?></span>
        </div>
        <div>
            <img src="<?php echo THEME_IMG_PATH?>/location.svg"/>
            <span lang="sq"><?php echo $albanianCopy['location']->address['albanian']; ?></span>
		    <span lang="en"><?php echo $englishCopy['location']->address['english']; ?></span>
        </div>
        <div>
            <img src="<?php echo THEME_IMG_PATH?>/email.svg"/>
            <span lang="sq"><?php echo $albanianCopy['email']; ?></span>
		    <span lang="en"><?php echo $englishCopy['email']; ?></span>
        </div>
	</div>
	<div class="map">
        <?php echo $albanianCopy['location']->map_embed; ?>
	</div>
</main>

<?php
get_footer();