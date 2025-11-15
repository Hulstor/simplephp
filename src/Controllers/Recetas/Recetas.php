<?php

namespace Controllers\Recetas;

use Dao\Recetas\Recetas as RecetasDao;
use Controllers\PrivateController;

class Recetas extends \controllers\PrivateController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["recetas"] = RecetasDao::getAll();

        foreach ($viewData["recetas"] as $idx => $receta) {
            foreach ($receta as $k => $v) {
                $viewData["recetas"][$idx][$k] = htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
            }
        }
        $this->render("recetas/list", $viewData);
    }
}
