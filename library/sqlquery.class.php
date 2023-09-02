<?php

class SQLQuery
{
    protected $_dbHandle;
    protected $_result;

    /** C onnects to database **/

    function connect($address, $account, $pwd, $name)
    {
        $this->_dbHandle = new mysqli($address, $account, $pwd, $name);
        if ($this->_dbHandle->connect_errno) {
            die($this->getErrorPol());
        } else {
            $this->_dbHandle->query("SET NAMES 'utf8'");
        }
    }

    function getLastId()
    {
        return $this->_dbHandle->insert_id;
    }

    function updateFromPostParams($postParams, $tableName, $keyColName)
    {
        $arrFields = array();
        $arrValues = array();
        $keyColValue = null;
        $arrTypes = array();
        forEach ($postParams as $key => $value) {
            if ($key != $keyColName) {
                $arrKeyWithType = explode(":", $key, 2);

                array_push($arrFields, $arrKeyWithType[0]);
                if (count($arrKeyWithType) > 1) {
                    array_push($arrTypes, $arrKeyWithType[1]);
                } else {
                    // if type is not provided, default is string
                    array_push($arrTypes, "s");
                }

                array_push($arrValues, $value);
            } else {
                $keyColValue = $value;
            }
        }

        array_push($arrValues, $keyColValue);

        $querySet = "`" . implode("`=?,`", $arrFields) . "`=?";

        $strTypes = implode($arrTypes);

        $arrKeyWithType = explode(":", $keyColName, 2);

        $queryWhere = "`" . $arrKeyWithType[0] . "`=?";

        $strTypes = (count($arrKeyWithType) > 1) ? $strTypes . $arrKeyWithType[1] : $strTypes . 's';

        $queryUpdate = "update " . $tableName . " set " . $querySet . " where " . $queryWhere;

        return $this->update($queryUpdate, $strTypes, $arrValues);
    }

    function update($query, $types, $params = array())
    {

        if ($stmt = $this->_dbHandle->prepare($query)) {
            $bind_names[] = $types;

            for ($i = 0; $i < count($params); $i++) {
                $bind_name = 'bind' . $i;
                $$bind_name = $params[$i] == 'NULL' ? null : $params[$i];
                $bind_names[] = &$$bind_name;
            }

            call_user_func_array(array($stmt, 'bind_param'), $bind_names);

            if ($stmt->execute()) {

                $dane['status'] = 1;
                $dane['info'] = $stmt->affected_rows > 0 ? 'Dane zapisane poprawnie' : 'Nic nie zostało zapisane';
                $dane['rows_affected'] = $stmt->affected_rows;

                $stmt->close();
                return $dane;
            } else {
                $dane['status'] = 0;
                $dane['info'] = "Błąd wykonania polecenia : " . $this->getError();
                $dane['rows_affected'] = 0;

                return $dane;
            }
        } else {
            $dane['status'] = 0;
            $dane['info'] = "Błędne polecenie : " . $this->getError();
            $dane['rows_affected'] = 0;

            return $dane;
        }
    }

    function insertFromPostParams($postParams, $tableName)
    {
        $arrFields = array();
        $arrValues = array();
        $arrTypes = array();
        forEach ($postParams as $key => $value) {

            $arrKeyWithType = explode(":", $key, 2);

            array_push($arrFields, $arrKeyWithType[0]);
            if (count($arrKeyWithType) > 1) {
                array_push($arrTypes, $arrKeyWithType[1]);
            } else {
                // if type is not provided, default is string
                array_push($arrTypes, "s");
            }

            array_push($arrValues, $value);
        }

        $strFields = "`" . implode("`,`", $arrFields) . "`";
        $strTypes = implode($arrTypes);

        $this->_table = $tableName;

        return $this->insert($strFields, $strTypes, $arrValues);
    }

    function insertIntoTable($tableName, $fieldNamesWihTypes, $dataObj)
    {
        $fieldsNames = array_keys($fieldNamesWihTypes);
        $fieldsTypes = array_values($fieldNamesWihTypes);

        $resolveFormattedValue = function ($data, $fieldName, $fieldType) {
            switch ($fieldType) {
                case 'string':
                    return "'" . trim($data[$fieldName]) . "'";
                case 'date':
                    return $data[$fieldName] !== '' && $data[$fieldName] !== null ? "'" . $data[$fieldName] . "'" : 'NULL';
                case 'json':
                    $json = "'" . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . "'";
                    $escapes = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
                    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
                    $json = str_replace($escapes, $replacements, $json);
                    return $json;
                case 'currency':
                    return $data[$fieldName] * 100;
                case 'integer':
                    return $data[$fieldName] === null ? 'NULL' : $data[$fieldName];
                default:
                    return $data[$fieldName];
            }
        };

        $formattedValues = array_map(fn($name, $type) => $resolveFormattedValue($dataObj, $name, $type), $fieldsNames, $fieldsTypes);

        $setKeyValues = '';
        for ($i = 0; $i < count($fieldsNames); $i++) {
            if ($setKeyValues !== '') {
                $setKeyValues .= ',';
            }
            $setKeyValues .= $fieldsNames[$i] . '=' . $formattedValues[$i];
        }
        $query = "insert into $tableName set $setKeyValues";

        if ($stmt = $this->_dbHandle->prepare($query)) {
            if ($stmt->execute()) {
                $stmt->close();
                $dane['status'] = 1;
                $dane['info'] = 'Dane zapisane poprawnie';
                $dane['keyval'] = $this->getLastId();
                $dane['rowid'] = $this->getLastId();
                $dane['isnew'] = '1';
                return $dane;
            } else {
                $dane['status'] = 0;
                $dane['info'] = "Błąd wykonania polecenia : " . $this->getError();
                $dane['rowid'] = $this->getLastId();
                $dane['isnew'] = '1';
                return $dane;
            }

        } else {
            $dane['status'] = 0;
            $dane['info'] = "Błędne polecenie : " . $this->getError();
            $dane['rowid'] = $this->getLastId();
            $dane['isnew'] = '1';
            return $dane;
        }
    }

    function insert($columnList, $types, $params = array())
    {

        $pytajniki = explode(',', $columnList);
        $listaPytajnikow = '';
        foreach ($pytajniki as $item) {
            if ($listaPytajnikow == '')
                $listaPytajnikow = '?';
            else
                $listaPytajnikow .= ',?';
        }

        $query = "insert into $this->_table ($columnList) values ($listaPytajnikow);";

        if ($stmt = $this->_dbHandle->prepare($query)) {
            $bind_names[] = $types;

            for ($i = 0; $i < count($params); $i++) {
                $bind_name = 'bind' . $i;
                $$bind_name = $params[$i] == 'NULL' ? null : $params[$i];
                $bind_names[] = &$$bind_name;
            }

            call_user_func_array(array($stmt, 'bind_param'), $bind_names);

//                    $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $stmt->close();
                $dane['status'] = 1;
                $dane['info'] = 'Dane zapisane poprawnie';
                $dane['keyval'] = $this->getLastId();
                $dane['rowid'] = $this->getLastId();
                $dane['isnew'] = '1';
                $dane['rows_affected'] = 1;
                return $dane;
            } else {
                $dane['status'] = 0;
                $dane['info'] = "Błąd wykonania polecenia : " . $this->getError();
                $dane['rowid'] = $this->getLastId();
                $dane['isnew'] = '1';
                $dane['rows_affected'] = 0;
                return $dane;
            }
        } else {
            $dane['status'] = 0;
            $dane['info'] = "Błędne polecenie : " . $this->getError();
            $dane['rowid'] = $this->getLastId();
            $dane['isnew'] = '1';
            $dane['rows_affected'] = 0;
            return $dane;
        }
    }

    /** Disconnects from database **/
    function selectWhere($nameOfId = null, $czyObject = false, $types = 's', $params = array(), $where = '', $columnList = '*', $order = '', $max = '')
    {

        // typ danej : s:string,d:double,i-int
        if ($where != null && $where != '')
            $where = ' where ' . $where;
        $query = "select $columnList from `$this->_table` $where $order $max";

        if ($stmt = $this->_dbHandle->prepare($query)) {
            if ($types != null && $params != null) {

                $bind_names[] = $types;
                for ($i = 0; $i < count($params); $i++) {
                    $bind_name = 'bind' . $i;
                    $$bind_name = $params[$i];
                    $bind_names[] = &$$bind_name;
                }

                call_user_func_array(array($stmt, 'bind_param'), $bind_names);
            }
            if ($stmt->execute()) {
                $result = array();
                if ($czyObject)
                    $result = $this->getresultObj($stmt, $nameOfId);
                else
                    $result = $this->getresultArray($stmt, $nameOfId);
                $stmt->free_result();
                $stmt->close();

                return $result;
            } else {
                die("Błąd wykonania polecenia : " . $this->getError());
            }
        } else {
            die("Błędne polecenie : " . $this->getError());
        }
    }

    function query($query, $nameOfId = null, $czyObject = false)
    {
        if ($stmt = $this->_dbHandle->prepare($query)) {
            if ($stmt->execute()) {
                if ($czyObject)
                    $result = $this->getresultObj($stmt, $nameOfId);
                else
                    $result = $this->getresultArray($stmt, $nameOfId);
                $stmt->free_result();
                $stmt->close();
                return $result;
            } else {
                die("Błąd wykonania polecenia : " . $this->getError());
            }
        } else {
            die("Błędne polecenie : " . $this->getError());
        }
    }

    private function getResultArray($stmt, $nameOfId)
    {
        $result = array();
        $meta = $stmt->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = &$row[$field->name];
        }

        call_user_func_array(array($stmt, 'bind_result'), $params);

        while ($stmt->fetch()) {
            foreach ($row as $key => $val) {
                $c[$key] = $val;
            }
            if ($nameOfId != null)
                $result[$c[$nameOfId]] = $c;
            else
                $result[] = $c;
        }

        $meta->free();
        unset($meta);
        return $result;
        unset($result);
    }

    private function getresultObj($stmt, $nameOfId)
    {
        $result = array();

        $metadata = $stmt->result_metadata();
        $fields = $metadata->fetch_fields();

        for (; ;) {
            $pointers = array();
            $row = new stdClass();

            $pointers[] = $stmt;
            foreach ($fields as $field) {
                $fieldname = $field->name;
                $pointers[] = &$row->$fieldname;
            }

            call_user_func_array("mysqli_stmt_bind_result", $pointers);

            if (!$stmt->fetch())
                break;

            if ($nameOfId != null)
                $result[$row->$nameOfId] = $row;
            else
                $result[] = $row;
        }

        $metadata->free();

        return $result;
    }

    function disconnect()
    {
        $this->_dbHandle->close();
    }

    /** Get number of rows **/
    function getErrorPol()
    {
        return $this->_dbHandle->connect_error;
    }

    function getError()
    {
        return $this->_dbHandle->error;
    }

    function strWrap($str, $wrap)
    {
        return $wrap . $str . $wrap;
    }
}