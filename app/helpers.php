<?php

if (! function_exists('hdate')) {
  function hdate($str) {
    return date('j. F Y', strtotime($str)); 
  }
}
