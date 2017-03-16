<?php

namespace app\controllers;

/**
 * Description of Page controller
 * @author Maxym
 */
class PageController extends AppController{

    public function viewAction() {
        $title='Page';
        $menu=$this->menu;
        $this->set(compact('title','menu'));
    }
}
