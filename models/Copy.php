<?php

class Copy{
    public $postObject;

    public function __construct(WP_Post $postObject){
        $this->postObject = $postObject;
    }

    public function getHomeText(){
        $homeText = [];
        if( have_rows('home', $this->postObject->ID) ):
            while( have_rows('home', $this->postObject->ID) ): the_row();
                $homeText['banner'] = get_sub_field('banner', $this->postObject->ID);
                $homeText['donateLink'] = get_sub_field('donate_link', $this->postObject->ID);
                $homeText['events'] = get_sub_field('events', $this->postObject->ID);
                $homeText['calendar'] = get_sub_field('calendar', $this->postObject->ID);
                $homeText['about'] = get_sub_field('about', $this->postObject->ID);
                $homeText['aboutFirstParagraph'] = get_sub_field('about_first_paragraph', $this->postObject->ID);
                $homeText['aboutSecondParagraph'] = get_sub_field('about_second_paragraph', $this->postObject->ID);
                $homeText['aboutLink'] = get_sub_field('about_link', $this->postObject->ID);
            endwhile;
        endif;
        return $homeText;
    }

    public function getContactText(){
        $contactText = [];
        if( have_rows('contact', $this->postObject->ID) ):
            while( have_rows('contact', $this->postObject->ID) ): the_row();
                $contactText['title'] = get_sub_field('title', $this->postObject->ID);
                $contactText['phoneNumber'] = get_sub_field('phone_number', $this->postObject->ID);
                $contactText['location'] = Location::getLocationFromPostObject(get_sub_field('location', $this->postObject->ID));
                $contactText['email'] = get_sub_field('email', $this->postObject->ID);
            endwhile;
        endif;
        return $contactText;
    }

    public function getAboutText(){
        $aboutText = [];
        if( have_rows('about', $this->postObject->ID) ):
            while( have_rows('about', $this->postObject->ID) ): the_row();
                $aboutText['banner'] = get_sub_field('banner', $this->postObject->ID);
                $aboutText['missionHeader'] = get_sub_field('mission_header', $this->postObject->ID);
                $aboutText['missionParagraph'] = get_sub_field('mission_paragraph', $this->postObject->ID);
                $aboutText['teamHeader'] = get_sub_field('team_header', $this->postObject->ID);
                $aboutText['teamParagraph'] = get_sub_field('team_paragraph', $this->postObject->ID);
            endwhile;
        endif;
        return $aboutText;
    }

    public function getDonateText(){
        $donateText = [];
        if( have_rows('donate', $this->postObject->ID) ):
            while( have_rows('donate', $this->postObject->ID) ): the_row();
                $donateText['banner'] = get_sub_field('banner', $this->postObject->ID);
                $donateText['donateHeader'] = get_sub_field('donate_header', $this->postObject->ID);
                $donateText['donateParagraph'] = get_sub_field('donate_paragraph', $this->postObject->ID);
                $donateText['donateButtonText'] = get_sub_field('donate_button_text', $this->postObject->ID);
                $donateText['donateLink'] = get_sub_field('donate_link', $this->postObject->ID);
                $donateText['paypalLink'] = get_sub_field('paypal_link', $this->postObject->ID);
            endwhile;
        endif;
        return $donateText;
    }
}

$WPAlbanianCopy = get_posts(array(
    'name' => 'albanian-copy',
    "post_type"=>"copy",
));
$WPEnglishCopy = get_posts(array(
    'name' => 'english-copy',
    "post_type"=>"copy",
));

$albanianCopyPost = new Copy($WPAlbanianCopy[0]);
$englishCopyPost = new Copy($WPEnglishCopy[0]);

?>