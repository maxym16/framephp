<?php

namespace app\controllers;

/**
 * controller PostsNew 
 */
class PostsNewController extends AppController {
    public function indexAction() {
        echo '<b>PostsNew::index</b> ';
    }
    public function testAction() {
        echo '<b>PostsNew::test</b> ';
    }
    public function testPageAction() {
        echo '<b>PostsNew::testPage</b> ';
    }
    public function before() {
        echo '<b>PostsNew::before</b> ';
    }
}


