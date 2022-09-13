<?php
get_header();
include("models/Location.php");
include("models/Copy.php");

$albanianCopy = $albanianCopyPost->getDonateText();
$englishCopy = $englishCopyPost->getDonateText();
?>

<main class="donate-page">
    <div class="banner">
        <img src="<?php echo THEME_IMG_PATH?>/jeta_donate.jpg" alt="Woman praying"/>
        <div>
            <h1 lang="sq"><?php echo $albanianCopy['banner']; ?></h1>
            <h1 lang="en"><?php echo $englishCopy['banner']; ?></h1>
        </div>
    </div>
    <section class="donate-section">
        <div class="donate-text">
            <h1 lang="sq"><?php echo $albanianCopy['donateHeader']; ?></h1>
            <h1 lang="en"><?php echo $englishCopy['donateHeader']; ?></h1>
            <p lang="sq">
                <?php echo $albanianCopy['donateParagraph']; ?>
            </p>
            <p lang="en">
                <?php echo $englishCopy['donateParagraph']; ?>
            </p>
        </div>
        <div class="donate-buttons">
            <div class="button-donate">
                <a href="<?php echo $albanianCopy['donateLink']; ?>" lang="sq" class="link-button wide-link-button"><?php echo $albanianCopy['donateButtonText']; ?></a>
                <a href="<?php echo $englishCopy['donateLink']; ?>" lang="en" class="link-button wide-link-button"><?php echo $englishCopy['donateButtonText']; ?></a>
            </div>
            <div class="button-paypal">
                <a href="<?php echo $albanianCopy['paypalLink']; ?>" class="link-button wide-link-button"><img src="<?php echo THEME_IMG_PATH?>/paypal.png"/></a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();