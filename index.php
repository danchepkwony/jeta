<?php
get_header();
include("models/Location.php");
include("models/Programs.php");
include("models/Copy.php");

$albanianCopy = $albanianCopyPost->getHomeText();
$englishCopy = $englishCopyPost->getHomeText();
$monthAhead = new DateTime('NOW');
$monthAhead->modify('+1 month');
$upcomingPrograms = Program::getThreeUpcomingPrograms(new DateTime('NOW'), $monthAhead);
?>

<main class="home">
	<div class="banner">
		<img src="<?php echo THEME_IMG_PATH?>/prostheticLeg.jpeg" alt=""/>
		<div>
			<h1 lang="sq"><?php echo $albanianCopy['banner']; ?></h1>
			<h1 lang="en"><?php echo $englishCopy['banner']; ?></h1>
		</div>
	</div>
	<?php if (count($upcomingPrograms) > 0):?>
	<section class="programs">
		<h1 lang="sq"><?php echo $albanianCopy['events']; ?></h1>
		<h1 lang="en"><?php echo $englishCopy['events']; ?></h1>
		<ol>
		<?php foreach ($upcomingPrograms as $index=>$program): 
			?>
			<li class="program">
				<div class="program-date"><?php echo $program->startMonth;?><span class="program-date-number"><?php echo $program->startDay;?></span></div>
				<div class="program-info">
					<div class="image-container">
						<img class="image" src="<?php echo $program->image;?>" alt=""/>
					</div>
					<h2 lang="sq"><?php echo $program->titleAlb;?></h2>
					<h2 lang="en"><?php echo $program->titleEng;?></h2>
					<div class="time"><?php echo $program->startTime . ' - ' . $program->endTime;?></div>
					<div lang="sq" class="address"><?php echo $program->location->address['albanian'];?></div>
					<div lang="en" class="address"><?php echo $program->location->address['english'];?></div>
				</div>
				<a href="/programs/<?php echo $index ?>/register" class="register"><img src="<?php echo THEME_IMG_PATH?>/arrowIcon.svg" alt="Register"/></a>
			</li>
		<?php endforeach; ?>
		</ol>
		<a lang="sq" class="link-button wide-link-button" href="/programs"><?php echo $albanianCopy['calendar']; ?></a>
		<a lang="en" class="link-button wide-link-button" href="/programs"><?php echo $englishCopy['calendar']; ?></a>
	</section>
	<?php endif; ?>
	<section class="instagram">
		<?php echo do_shortcode('[instagram-feed feed=1]');?>
	</section>
	<section class="facebook">
		<?php echo do_shortcode('[custom-facebook-feed feed=1]');?>
	</section>
	<section id="about" class="about">
		<div class="text-container">
			<h1 lang="sq"><?php echo $albanianCopy['about']; ?></h1>
			<h1 lang="en"><?php echo $englishCopy['about']; ?></h1>
			<p lang="sq">
				<?php echo $albanianCopy['aboutFirstParagraph']; ?>
			</p>
			<p lang="en">
				<?php echo $englishCopy['aboutFirstParagraph']; ?>
			</p>
			<a lang="sq" class="link-button wide-link-button" href="/about"><?php echo $albanianCopy['aboutLink']; ?></a>
			<a lang="en" class="link-button wide-link-button" href="/about"><?php echo $englishCopy['aboutLink']; ?></a>
		</div>
		<div class="img-container">
			<img src="<?php echo THEME_IMG_PATH?>/jetaBuilding.png"></img>
		</div>
	</section>
</main>

<?php
get_footer();

