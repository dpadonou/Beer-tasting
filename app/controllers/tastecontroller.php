<?php

class TasteController extends BaseController implements Controller
{
    const viewDirectory = "taste/";

    public function __construct()
    {
        if (Session::getConnectedUser()) {
            header("Location:" . PAGE_DASHBOARD);
        }
    }

    public function render()
    {
        $content = false;
        $this->h1 = "home";
        $this->description = "home";
        $this->title = "home";

        $view = "tasting.phtml";

        $content = App::get_content(
            self::viewDirectory . $view,
            array()
        );
        return $content;
    }
}