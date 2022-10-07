<?php

/*
 *
 * read details how to config domain in README.md
 * */
const PROJECT_NAME = 'project';

function base_url() {
    if (!is_null(PROJECT_NAME)) {
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . PROJECT_NAME . '/';
    }

    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
}

function root_path() {
    return dirname(__FILE__);
}