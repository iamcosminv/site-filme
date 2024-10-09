<?php
    function runtime_prettier($time){
        if($time != '' && $time > 0){
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            return "$hours hours" ." ". "$minutes minutes";
        } else{
          return "movie without runtime";  
        }
    };

    function check_old_movie($year = 0){
        if($year < (date("Y") - 40) && $year > 0 ) {
            return date("Y") - $year;
        } else {
            return false;
        }
    }
    function getGreeting(){
        date_default_timezone_set('Europe/Bucharest');

        $hour = date('H');

        if($hour >= 5 && $hour < 12) {
            return "Good Morning!";
        } elseif($hour >=12 && $hour <= 18) {
            return "Good Afternoon!";
        } elseif($hour >= 18 && $hour < 22) {
            return "Good Evening!";
        } else {
            return "Good Night!";
        }
    };

    function find_movies_by_genre($item){
        if(in_array($_GET['genre'], $item['genres'])){
            return true;
        }else {
            return false;
        }
    }

    function find_movie_by_id($item) {
        if(!isset($_GET['movie_id'])) return false;
        
        if(intval($_GET['movie_id']) === $item['id']) {
            return true;
        }else {
            return false;
        }
    }

    function find_movie_by_title($item) {
        if(stripos($item['title'], $_GET['s']) === false){
            return false;
        }else {
            return true;
        }
    }
?>