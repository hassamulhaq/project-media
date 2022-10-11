<?php
session_start();
header("Access-Control-Allow-Origin: *");

/*
 *
 * read details how to config domain in README.md
 *
 * set to null PROJECT_NAME if you host project on line domain.
 * e,g ``` const PROJECT_NAME = null; ```
 *
 * */
const PROJECT_NAME = null;

function base_url() {
    if (!is_null(PROJECT_NAME)) {
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . PROJECT_NAME . '/';
    }

    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
}

function base_path() {
    if (!is_null(PROJECT_NAME)) {
        return $_SERVER['HTTP_HOST'] . '/' . PROJECT_NAME . '/';
    }

    return $_SERVER['HTTP_HOST'] . '/';
}

function root_path() {
    return dirname(__FILE__);
}



const FILES_PATH = "/public/files/";
function filesUploadPath() {
    $path = FILES_PATH;
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    return root_path() . $path;
}