<?php

namespace controllers;

class SiteController {

    public function displayIndex(){
        include 'app/site/index.php';
    }
    public function showCalculatorForm(){
        include 'app/site/calculator.php';
    }
}