<?php

class Staff{
    public $name;
    public $position;
    public $headshot;

    public static function getAllStaff(){
        $staffMembers = [];
        $staff = get_posts(array(
            "posts_per_page"=>-1,
            "post_type"=>"staff"
        ));

        foreach($staff as $staffMemberPost){
            $staffMember = new Staff();
            $staffMember->name = get_field("name", $staffMemberPost->ID);
            $staffMember->position = get_field("position", $staffMemberPost->ID);
            $staffMember->headshot = get_field("headshot", $staffMemberPost->ID);
            array_push($staffMembers, $staffMember);
        }
        return $staffMembers;
    }
}

?>