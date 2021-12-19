<?php

class BeerStyleController extends BaseController implements Controller
{
    const viewDirectory = "beerstyle/";

    public function __construct()
    {
        if ((isset($_GET['mode']))) {
            if (($_GET['mode'] != "visitor")) {
                header("Location:" . PAGE_SIGNIN);
            }
        } else if (!Session::getConnectedUser()) {
            header("Location:" . PAGE_SIGNIN);
        }
    }

    public function getAllBeerStyles()
    {
        $content = false;
        $this->h1 = "Beer styles";
        $this->description = "Beer styles";
        $this->title = "Beer styles | TasteMyBeer";

        $view = "index.phtml";


        $limit = DEFAULT_PAGINATION;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $offset = ($page - 1) * $limit;

        $beerStylesCount = BeerStyle::count();

        $pages = ceil($beerStylesCount / $limit);

        $beerStyles = BeerStyle::getBeerStyles($offset, $limit);

        $content = App::get_content(
            self::viewDirectory . $view,
            array(
                "beerStyles" => $beerStyles,
                'pages' => $pages,
                'count' => $beerStylesCount,
                'page' => $page
            )
        );
        return $content;
    }

    public function getBeerStyleById($id)
    {
        $this->h1 = "BeerStyle " . $id;
        $this->description = "BeerStyle " . $id;
        $this->title = "BeerStyle " . $id . " | TasteMyBeer";

        $view = "viewBeerStyle.phtml";

        $beerStyle = BeerStyle::getBeerStyle($id);

        return App::get_content(
            self::viewDirectory . $view,
            array('beerStyle' => $beerStyle)
        );
    }

    public function render()
    {
        $content = false;
        $operation = $_GET['operation'];
        switch ($operation) {
            case 'getAll':
                $content = $this->getAllBeerStyles();
                break;
            case 'getBeerStyle':
            default:
                $content = $this->getBeerStyleById($_GET['id']);
                break;
        }
        return $content;
    }
}