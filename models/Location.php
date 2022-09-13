<?php

class Location{
    public $address;
    public $directions;
    public $mapCoordinates;

    function getLocationFromPostObject(WP_Post $locationPost){
        $locationFromPost = new Location();
        $locationFromPost->location = get_field("map_coordinates", $locationPost->ID);
        $locationFromPost->map_embed = self::makeGoogleMapEmbed(get_field("map_coordinates", $locationPost->ID));
        $locationFromPost->address = self::getSubFieldLanguages($locationPost->ID, "address");
        $locationFromPost->directions = self::getSubFieldLanguages($locationPost->ID, "directions");
        return $locationFromPost;
    }

    private static function getSubFieldLanguages(int $id, string $field){
        $subFields = [];
        if( have_rows($field, $id) ):
            while( have_rows($field, $id) ): the_row();
                $subFields['albanian'] = get_sub_field('albanian', $id);
                $subFields['english'] = get_sub_field('english', $id);
            endwhile;
        endif;
        return $subFields;
    }

    private static function makeGoogleMapEmbed(array $location){
        $config = include( __DIR__  . '/../config.php');
        $address_field = $location['address'];
        $encoded_address = urlencode( $address_field );
        return '
            <iframe
                height="450"
                frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/place?key=' . $config->maps_api_key . '&q=' . $encoded_address . '" allowfullscreen>
            </iframe>';
    }
}
?>