<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Call Scraper
require "Scraper.php";
// Parameter is the tag or subreddit so t/anime or r/anime_irl
$scrap = new Scraper('r/anime_irl');
$scrap->getImages();
?>
