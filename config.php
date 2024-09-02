<?php

function tt($str){
    echo "<pre>";
        print_r($str);
    echo "</pre>";
}

function tte($str){
    echo "<pre>";
        print_r($str);
    echo "</pre>";
    exit();
}

const APP_BASE_PATH = 'diplom';

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'crm_db';

const START_ROLE = 1;
const START_TASK_STATUS = 'В ожидании';