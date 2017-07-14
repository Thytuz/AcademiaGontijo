<?php

require_once '../Views/HomeView.class.php';


class HomeController {

    private $homeView = null;

    public function __construct() {
        $this->homeView = new HomeView("Home");
        $this->homeView->displayInterface(null);
    }

}
