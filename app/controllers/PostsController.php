<?php

namespace app\controllers;

/**
 * Posts 
 */
class PostsController extends AppController {
    public function indexAction() {
        echo '<b>Posts::index</b> ';
    }
    public function testAction() {
        echo '<b>Posts::test</b> ';
    }
}
