<?php
class sharesController extends Controller
{
    function show() {}

    function getusershares() {
        echo $this->share->getUserShares();
    }

    function updatepermission() {
        if ($_POST['permission'] && $_POST['rowid']) {
            $result = $this->share->updatePermission($_POST['permission'], $_POST['rowid']);
            echo $result['info'];
        } else {
            echo "blędne parametry wejściowe";
        }

    }
}

