<?php

class materialsController extends Controller
{
    function showdane()
    {
        global $smarty;
        $this->material->populateWithPost();
        $dataMaterials = $this->material->getMaterialsReport($_POST['date_from'], $_POST['date_to']);

        $smarty->assign('dataMaterials', $dataMaterials);
        unset($dataMaterials);
    }
}
