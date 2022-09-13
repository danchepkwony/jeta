<?php
get_header();
include("models/Copy.php");
include("models/Staff.php");

$albanianCopy = $albanianCopyPost->getAboutText();
$englishCopy = $englishCopyPost->getAboutText();
$staffMembers = Staff::getAllStaff();
?>

<main class="about-page">
    <div class="banner">
        <img src="<?php echo THEME_IMG_PATH?>/churchService.jpeg" alt=""/>
        <div>
            <h1 lang="sq"><?php echo $albanianCopy['banner']; ?></h1>
            <h1 lang="en"><?php echo $englishCopy['banner']; ?></h1>
        </div>
    </div>
    <section class="mission">
        <div class="text-container">
            <h1 lang="sq"><?php echo $albanianCopy['missionHeader']; ?></h1>
            <h1 lang="en"><?php echo $englishCopy['missionHeader']; ?></h1>
            <p lang="sq">
                <?php echo $albanianCopy['missionParagraph']; ?>
            </p>
            <p lang="en">
                <?php echo $englishCopy['missionParagraph']; ?>
            </p>
        </div>
        <div class="image-container">
            <img class="desktop-img" src="<?php echo THEME_IMG_PATH?>/mind_body_soul.svg" alt="Mind, Body, and Soul">
            <img class="mobile-img" src="<?php echo THEME_IMG_PATH?>/mind_body_soul_mobile.svg" alt="Mind, Body, and Soul">
        </div>
    </section>
    <section class="team">
        <div class="text-container">
            <h1 lang="sq"><?php echo $albanianCopy['teamHeader']; ?></h1>
            <h1 lang="en"><?php echo $englishCopy['teamHeader']; ?></h1>
            <p lang="sq">
                <?php echo $albanianCopy['teamParagraph']; ?>
            </p>
            <p lang="en">
                <?php echo $englishCopy['teamParagraph']; ?>
            </p>
        </div>
        <div class="image-container">      
            <img src="<?php echo THEME_IMG_PATH?>/jeta_about_us.jpeg" alt="Jeta Building"/>
        </div>
    </section>
    <section class="team-members">
        <?php foreach ($staffMembers as $member): 
        ?>
            <div class="member">
                <div class="image-container">
                    <img src="<?php echo $member->headshot?>" />
                </div>
                <div class="text-container">
                    <h1><?php echo $member->name ?></h1>
                    <h2><?php echo $member->position ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php
get_footer();