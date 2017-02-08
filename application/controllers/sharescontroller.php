<?php
class sharesController extends Controller
{
    function show() {}

    function getusershares() {
        echo $this->share->getUserShares();
    }

    function getroles() {
        echo $this->share->getRoles();
    }

    function addpermission() {
        if (isset($_POST['roleRowId']) && isset($_POST['id']) && $_POST['roleRowId'] && $_POST['id']) {
            $result = $this->share->addPermission($_POST['id'], $_POST['controller'], $_POST['action'], $_POST['description'], $_POST['activity'], $_POST['roleRowId'], $_POST['permission']);
            echo $result['info'];
        } else {
            echo "blędne parametry wejściowe";
        }
    }

    function updatepermission() {
        if ($_POST['rowid'] && $_POST['roleid']) {
            $result = $this->share->updatePermission($_POST['permission'], $_POST['rowid'], $_POST['roleid']);
            echo $result['info'];
        } else {
            echo "blędne parametry wejściowe";
        }

    }

    function removepermission() {
        if (isset($_POST['rowid']) && isset($_POST['roleid']) && $_POST['rowid'] && $_POST['roleid']) {
            $result = $this->share->removePermission($_POST['rowid'], $_POST['roleid']);
            echo $result['info'];
        } else {
            echo "blędne parametry wejściowe";
        }
    }
}

