<?php

class acl extends Model
{
    function getByLogin($login)
    {
        $this->_table = 'users';
        return $this->selectWhere(null, false, 's', array($login), ' id=?  and activity=1 and haslo is not null', '*');
    }

    function getByRowid($rowid)
    {
        $this->_table = 'users';
        return $this->selectWhere(null, false, 'i', array($rowid), ' rowid=?  and activity=1', 'id,imie,nazwisko,mail,rowid');
    }

    function refreshSession($rowidUser, $appConfig)
    {
        $this->_table = 'users';
        $dataUser = $this->getByRowid($rowidUser);
        $_SESSION['shares'] = $this->getAllShares();
        $_SESSION['przypisaneshares'] = $this->getPrzypisaneShares($rowidUser);
        $_SESSION['user'] = $dataUser[0];
        $_SESSION['przypisanemenu'] = $this->getPrzypisaneMenu($rowidUser);

        $_SESSION['appConfig'] = $appConfig;


        $_SESSION['customMenu'] = $this->readDirectoryContents(ROOT . DS . 'application' . DS . CUSTOM_SCRIPTS_FOLDER_NAME);

        unset($dataUser);
        $_SESSION['login'] = 1;
    }

    function getAllShares()
    {
        $this->_table = 'shares';
        return $this->selectWhere('id', false, null, null, ' activity=1 ', 'id,controller,action');
    }

    function getPrzypisaneMenu($rowidUser)
    {
        $query = "select distinct * from 
                (select 
                d.id,
                d.controller,
                d.`action`,
                c.permission
                from
                ((users_groups a left outer join groups_roles b on a.rowid_group=b.rowid_group)
                left outer join roles_shares c on b.rowid_role=c.rowid_role)
                left outer join shares d on c.rowid_share=d.rowid
                where
                a.rowid_user = {$rowidUser} and d.activity=1
                union all
                select 
                d.id,
                d.controller,
                d.`action`,
                c.permission
                from
                (users_roles a left outer join roles_shares c on a.rowid_role=c.rowid_role)
                left outer join shares d on c.rowid_share=d.rowid
                where
                a.rowid_user={$rowidUser} and d.activity=1) as zbior";
        return $this->query($query, 'id', false);
    }

    function getPrzypisaneShares($rowidUser)
    {
        $query = "select distinct * from 
                (select 
                d.id,
                d.controller,
                d.`action`,
                c.permission
                from
                ((users_groups a left outer join groups_roles b on a.rowid_group=b.rowid_group)
                left outer join roles_shares c on b.rowid_role=c.rowid_role)
                left outer join shares d on c.rowid_share=d.rowid
                where
                a.rowid_user = {$rowidUser} and d.activity=1
                union all
                select 
                d.id,
                d.controller,
                d.`action`,
                c.permission
                from
                (users_roles a left outer join roles_shares c on a.rowid_role=c.rowid_role)
                left outer join shares d on c.rowid_share=d.rowid
                where
                a.rowid_user={$rowidUser} and d.activity=1) as zbior";
        return $this->query($query, 'id', false);
    }

    function readDirectoryContents($baseDir, $currentPath = "")
    {
        $flatList = [];

        if (!is_dir($baseDir)) {
            return $flatList;
        }

        $items = scandir($baseDir);
        $hasPhpFiles = false;

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $baseDir . DIRECTORY_SEPARATOR . $item;
            $relativePath = ltrim($currentPath . '/' . $item, '/');

            if (is_dir($fullPath)) {
                $subFolderContents = $this->readDirectoryContents($fullPath, $relativePath);

                if (!empty($subFolderContents)) {
                    $flatList[] = ['name' => $item, 'type' => 'folder'];
                    $flatList = array_merge($flatList, $subFolderContents);
                }
            } elseif (is_file($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
                $flatList[] = [
                    'name' => $relativePath,
                    'fileName' => pathinfo($item, PATHINFO_FILENAME),
                    'type' => 'file'
                ];
                $hasPhpFiles = true;
            }
        }

        return $flatList;
    }
}