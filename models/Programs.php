<?php
/* Based on code by Bryon O'Conner */

class Program{
    public $titleAlb;
    public $titleEng;
    public $descriptionAlb;
    public $descriptionEng;
    public $image;
    public $startYear;
    public $startMonth;
    public $startDay;
    public $startTime;
    public $endYear;
    public $endMonth;
    public $endDay;
    public $endTime;
    public $location;
   
    public static function getAllProgramsForDateRange(DateTime $startTime, DateTime $endTime):array{
        $scheduledPrograms = self::getScheduledProgramsForDateRange($startTime, $endTime);
        $repeatedPrograms = self::getAllRepeatedPrograms($startTime, $endTime);
        $allPrograms = array_merge($scheduledPrograms, $repeatedPrograms);
        $allPrograms = self::sortProgramsByDate($allPrograms);
        return $allPrograms;
    }

    public static function getThreeUpcomingPrograms(DateTime $startTime, DateTime $endTime):array{
        $scheduledPrograms = self::getScheduledProgramsForDateRange($startTime, $endTime);
        $repeatedPrograms = self::getAllRepeatedPrograms($startTime, $endTime);
        $allPrograms = array_merge($scheduledPrograms, $repeatedPrograms);
        $allPrograms = self::sortProgramsByDate($allPrograms);
        return array_slice($allPrograms, 0, 3);
    }

    private static function sortProgramsByDate(array $programs):array{
        $newArray = $programs;
        usort($newArray, function ($a,$b){return $a->startDateTime <=> $b->startDateTime;});
        return $newArray;
    }

    private static function getScheduledProgramsForDateRange(DateTime $startTime, DateTime $endTime):array{
        $startFormat = $startTime->format("Ymd");
        $endFormat = $endTime->format("Ymd");
        $scheduledProgramPosts = get_posts(array(
            "posts_per_page"=>-1,
            "post_type"=>"programs",
            "meta_query" => array(
                array(
                    "key"=> "date",
                    "compare"=>">=",
                    "value"=>"$startFormat"
                ),
                array(
                    "key"=>"date",
                    "compare"=>"<=",
                    "value"=>"$endFormat"
                ),
                array(
                    "key"=>"repeats_weekly",
                    "compare"=>"=",
                    "value"=>"0"
                )
            ),
            "order_by"=>"date"
        ));

        $programs = [];
        foreach ($scheduledProgramPosts as $scheduledProgramPost){

            //Create DateTime object from WP Date and Time fields
            $startTimeArray = self::getHourMinuteSecondFromTime(get_post_meta($scheduledProgramPost->ID, "start_time",true));;
            $endTimeArray = self::getHourMinuteSecondFromTime(get_post_meta($scheduledProgramPost->ID, "end_time",true));;

            $programStartDateTime = new DateTime(get_post_meta($scheduledProgramPost->ID, "date",true));
            $programStartDateTime->setTime($startTimeArray['hour'], $startTimeArray['minute'], $startTimeArray['second']);

            $programEndDateTime = clone $programStartDateTime;
            $programEndDateTime->setTime($endTimeArray['hour'], $endTimeArray['minute'], $endTimeArray['second']);

            //If the start date time is happening after the end date time(crossing a midnight boundary)
            //then add a day to the end date time
            if($programStartDateTime > $programEndDateTime){
                $programEndDateTime->add(new DateInterval("P1D"));
            }

            $program = new Program();
            $program->titleAlb = get_field("albanian_title", $scheduledProgramPost->ID);
            $program->titleEng = get_field("english_title", $scheduledProgramPost->ID);
            $program->descriptionAlb = get_field("albanian_description", $scheduledProgramPost->ID);
            $program->descriptionEng = get_field("english_description", $scheduledProgramPost->ID);                
            $program->image = get_field("image", $scheduledProgramPost->ID);
            $program->startYear = $programEndDateTime->format('o');
            $program->startMonth = $programStartDateTime->format('M');
            $program->startDay = $programStartDateTime->format('j');
            $program->startTime = $programStartDateTime->format('g:i A');
            $program->endYear = $programEndDateTime->format('o');
            $program->endMonth = $programEndDateTime->format('M');
            $program->endDay = $programEndDateTime->format('j');
            $program->endTime = $programEndDateTime->format('g:i A');
            $program->location = Location::getLocationFromPostObject(get_field( "location",$scheduledProgramPost->ID));
            $programs[] = $program;
        }

        return $programs;

    }

    private static function getAllRepeatedPrograms(DateTime $startTime, DateTime $endTime):array{
        $repeatedPrograms = get_posts(array(
            "posts_per_page"=>-1,
            "post_type"=>"programs",
            "meta_query" => array(
                array(
                    "key"=>"repeats_weekly",
                    "compare"=>"=",
                    "value"=>"1"
                )
            )
        ));

        $programs = [];
        $today = new DateTimeImmutable('NOW');
        $weeks = [$today, $today->modify('+7 days'), $today->modify('+14 days'), $today->modify('+21 days'), $today->modify('+28 days'), $today->modify('+35 days'), $today->modify('+42 days'), $today->modify('+49 days'), $today->modify('+56 days')];

        foreach ($repeatedPrograms as $repeatedProgram){
            $dayOfTheWeek = get_post_meta($repeatedProgram->ID, "day_of_the_week", true);

            foreach ($weeks as $startOfWeek){
                //Create DateTime object from WP Day of the Week and Time fields
                $startTimeArray = self::getHourMinuteSecondFromTime(get_post_meta($repeatedProgram->ID, "start_time",true));
                $endTimeArray = self::getHourMinuteSecondFromTime(get_post_meta($repeatedProgram->ID, "end_time",true));

                //If the repeated program day of the week is later in the week, then just offset it
                //But if it comes before today in the week, then go to next week
                $startingDayOfTheWeek = $startOfWeek->format('N') - 1;
                $programStartDateTime = DateTime::createFromImmutable($startOfWeek);
                $dayOffset = $startingDayOfTheWeek <= $dayOfTheWeek ? $dayOfTheWeek - $startingDayOfTheWeek : 7 - ($startingDayOfTheWeek - $dayOfTheWeek);
                $programStartDateTime->modify('+' . strval($dayOffset) . " days");
                $programStartDateTime->setTime($startTimeArray['hour'], $startTimeArray['minute'], $startTimeArray['second']);
                if($programStartDateTime > $endTime){
                    break;
                }

                $programEndDateTime = clone $programStartDateTime;
                $programEndDateTime->setTime($endTimeArray['hour'], $endTimeArray['minute'], $endTimeArray['second']);
                
                //If the start date time is happening after the end date time (crossing a midnight boundary)
                //then add a day to the end date time
                if($programStartDateTime > $programEndDateTime){
                    $programEndDateTime->add(new DateInterval("P1D"));
                }

                $program = new Program();
                $program->titleAlb = get_field("albanian_title", $repeatedProgram->ID);
                $program->titleEng = get_field("english_title", $repeatedProgram->ID);
                $program->descriptionAlb = get_field("albanian_description", $repeatedProgram->ID);
                $program->descriptionEng = get_field("english_description", $repeatedProgram->ID);                
                $program->image = get_field("image", $repeatedProgram->ID);
                $program->startYear = $programStartDateTime->format('o');
                $program->startMonth = $programStartDateTime->format('M');
                $program->startDay = $programStartDateTime->format('j');
                $program->startTime = $programStartDateTime->format('g:i A');
                $program->endYear = $programEndDateTime->format('o');
                $program->endMonth = $programEndDateTime->format('M');
                $program->endDay = $programEndDateTime->format('j');
                $program->endTime = $programEndDateTime->format('g:i A');
                $program->location = Location::getLocationFromPostObject(get_field("location", $repeatedProgram->ID));
                $programs[] = $program;
            }
        }


        return $programs;

    }

    private static function getHourMinuteSecondFromTime($time){
        $time = new DateTime("2022-1-1 ".$time);
        $hour = (int)$time->format("G");
        $minute = (int)$time->format("i");
        $second = (int)$time->format("s");

        return ["hour"=>$hour,"minute"=>$minute,"second"=>$second];
    }
}
?>