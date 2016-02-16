<?php
class Dao extends Lib {
    public $id;
    public $conn;

    public function __construct($id = NULL) {
        $this -> id = $id;
        $this -> conn = Conexao::init();
    }

    function DAO_ExecutarQuery($sql) {

        try {

            $result = $this -> conn -> query($sql);
            if (!$result) {
                throw new Exception('Erro de SQL:<BR>SQL:' . $sql . "<BR>ERRO:" . $this -> conn -> connection -> error);
            }

        } catch (Exception $e) {
            throw new Exception($e -> getMessage());
        }

        return $result;

    }

    function DAO_ExecutarDelete($sql) {

        try {
            $result = $this -> conn -> query($sql);
            if (!$result) {
                return false;
            }

        } catch (Exception $e) {
            throw new Exception($e -> getMessage());
        }

        return true;

    }

    function getNumeroFormatado() {
        return str_pad($this -> id, 6, "0", STR_PAD_LEFT);
    }

    function getIdMD5Encrypt() {
        return $this -> md5_encrypt($this -> id);
    }

    function getIdMD5Decrypt($crypt) {
        return $this -> md5_decrypt($crypt);
    }

    function DAO_NumeroLinhas($result) {

        return $result -> num_rows;

    }

    function DAO_GerarArray($result) {

        return $result -> fetch_array(MYSQLI_ASSOC);

    }

    function DAO_Result($rs, $campo, $linha) {
        $rs -> data_seek($linha);
        $datarow = $rs -> fetch_array(MYSQLI_ASSOC);
        return $datarow[$campo];
    }

    function DAO_recuperaUltimoIdInserido() {

        return $this -> conn -> connection -> insert_id;

    }

    public function listAll() {
        $string = get_called_class();
        $ob = new $string();
        var_dump(json_decode($ob::COLS));

    }

    /* recupera uma lista de todos os nomes dos campos na tabela ligada a classe*/
    function getFieldsList($class) {
        $string = "";
        foreach ($class->children() as $atributo) {
            if ($atributo['tb-name'] != "")
                $string .= $atributo['tb-name'] . ",";
        }

        return substr($string, 0, strlen($string) - 1);
    }

    /* recupera o nome do campo no banco de dados atraves no nome do atributo */
    function getField($class, $propriedade) {
        foreach ($class->children() as $atributo) {
            if ($atributo[0] == $propriedade)
                return $atributo['tb-name'];
        }
    }

    /* seta o bean com lazy */
    function setBean($arrayValues, $class) {
        foreach ($class->children() as $atributo) {

            $field = $atributo["tb-name"];
            $tbIdent = $class["tb-id"];

            if ($atributo["role"] == "set") {
                $clfk = substr($atributo['class-fk'], 0, strlen($atributo['class-fk']));
                $strClass = substr($atributo['class-relation'], 0, strlen($atributo['class-relation']));
                $clorder = substr($atributo['class-order'], 0, strlen($atributo['class-order']));
                $valueIdFk = $arrayValues["$tbIdent"];

                $obj = new $strClass;

                $arrayOrder = array(0 => $clorder);
                $arraywhere = array($clfk => "=" . $valueIdFk);
                $xml2 = simplexml_load_file(URI . "/src/config/dao.xml");
                foreach ($xml2->children() as $elemento2) {
                    if ($elemento2['name'] == get_class($obj)) {
                        $arrayrs = $obj -> getClassRows($elemento2, $arrayOrder, $arraywhere);
                        $this -> $atributo[0] = $arrayrs;
                    }
                }

            } else {
                if ($atributo["role"] == "fk" && strlen($arrayValues["$field"]) > 0) {
                    $strClass = substr($atributo['class-relation'], 0, strlen($atributo['class-relation']));
                    $obj = new $strClass;
                    $obj -> getById($arrayValues["$field"]);
                    $this -> $atributo[0] = $obj;
                    unset($obj);
                } else {
                    $this -> $atributo[0] = $arrayValues["$field"];
                }

            }

        }
        return true;
    }

    /*seta o bean sem lazy */
    function setBeanUnlazy($arrayValues, $class) {
        foreach ($class->children() as $atributo) {
            if ($atributo["role"] != "set") {
                $field = $atributo["tb-name"];
                $tbIdent = $class["tb-id"];
                $this -> $atributo[0] = $arrayValues["$field"];
            }
        }
        return true;
    }

    function xmlContruct($i, $objeto) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($objeto)) {
                return $this -> xmlObject($elemento, $i, $objeto);
            }
        }
    }

    /*xml do objeto completo*/
    function xmlObject($elemento, $i, $objeto) {
        $str = "";
        if ($i < 2) {
            $str = "<" . $elemento['name'] . ">";
            foreach ($elemento->children() as $item) {
                if ($item["role"] == "fk") {
                    $str .= $this -> xmlContruct($i + 1, $objeto -> $item[0]);
                } else if ($item["role"] == "set") {
                    $str .= "<" . $item[0] . ">";
                    foreach ($objeto->$item[0] as $objClasse) {
                        $str .= $this -> xmlContruct($i + 1, $objClasse);
                    }
                    $str .= "</" . $item[0] . ">";
                } else {
                    $str .= str_pad("<" . $item[0] . ">" . $objeto -> $item[0] . "</" . $item[0] . ">", strlen("<" . $item[0] . ">" . $objeto -> $item[0] . "</" . $item[0] . ">") + ($i * 4), " ", STR_PAD_LEFT);
                }

            }
            $str .= "</" . $elemento['name'] . ">";
        }
        return $str;
    }

    /*recupera um objeto da classe pelo id com lazy at� segundo nivel*/
    function getById($id) {
        if (strlen($id) > 0) {
            $xml = simplexml_load_file(URI . "/src/config/dao.xml");
            foreach ($xml->children() as $elemento) {
                if ($elemento['name'] == get_class($this)) {
                    $sql = "select " . $this -> getFieldsList($elemento) . " from " . $elemento['tb-name'] . " where " . $elemento['tb-id'] . " = $id";
                    $rs = $this -> DAO_ExecutarQuery($sql);
                    if ($this -> DAO_NumeroLinhas($rs) > 0) {
                        $arrayItem = $this -> DAO_GerarArray($rs);
                        $this -> setBean($arrayItem, $elemento);
                        return true;
                    } else {
                        return false;
                    }
                }
            }

        } else {
            return false;
        }
    }

    //metodo que recupera 1 registro por filtro e set o objeto
    function getRow($filtro = array()) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($this)) {

                //configura as clausulas where
                $where = "";
                if (count($filtro) > 0) {
                    $where = "where 1 = 1 ";
                    foreach ($filtro as $key => $value) {
                        $campo = $this -> getField($elemento, $key);
                        $where .= " and $campo $value	";
                    }
                }

                $sql = "select " . $this -> getFieldsList($elemento) . " from " . $elemento['tb-name'] . " $where limit 0, 1";
                $rs = $this -> DAO_ExecutarQuery($sql);

                if ($this -> DAO_NumeroLinhas($rs) > 0) {
                    $arrayItem = $this -> DAO_GerarArray($rs);
                    $this -> setBean($arrayItem, $elemento);
                    return true;
                } else
                    return false;

            }

        }
    }

    /*m�todo que recupera a lista de obejtos da classe */
    public function getRows($init = 0, $limit = 999, $order = array(), $filtro = array()) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($this)) {
                //configura a ordenacao
                $ordenacao = "";
                if (count($order) > 0) {
                    $ordenacao = " order by ";
                    foreach ($order as $key => $value) {
                        $campo = $this -> getField($elemento, $key);
                        $ordenacao .= $campo . " " . $value . ",";
                    }

                }
                $ordenacao = substr($ordenacao, 0, strlen($ordenacao) - 1);
                //configura as clausulas where
                $where = "";
                if (count($filtro) > 0) {
                    $where = "where 1 = 1 ";
                    foreach ($filtro as $key => $value) {
                        $campo = $this -> getField($elemento, $key);
                        $where .= " and $campo $value	";
                    }
                }

                $sql = "select " . $this -> getFieldsList($elemento) . " from " . $elemento['tb-name'] . " $where $ordenacao limit $init, $limit";
                $rs = $this -> DAO_ExecutarQuery($sql);
                $arrayItens = array();
                if ($this -> DAO_NumeroLinhas($rs) > 0) {
                    while ($arrayItem = $this -> DAO_GerarArray($rs)) {
                        $object = new $this;
                        $object -> setBean($arrayItem, $elemento);
                        array_push($arrayItens, $object);
                    }
                }
                return $arrayItens;
            }

        }

    }

    /*m�todo que recupera a quantidade de objetos obejtos da classe */
    function getNumRows($filtro = array()) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($this)) {

                //configura as clausulas where
                $where = "";
                if (count($filtro) > 0) {
                    $where = "where 1 = 1 ";

                    foreach ($filtro as $key => $value) {
                        $campo = $this -> getField($elemento, $key);
                        $where .= " and $campo $value	";
                    }
                }

                $sql = "select count(*) as total from " . $elemento['tb-name'] . " $where";
                $rs = $this -> DAO_ExecutarQuery($sql);
                $arrayItem = $this -> DAO_GerarArray($rs);
                return $arrayItem['total'];
            }

        }

    }

    /* m�todo que recupera uma array(lista) de objetos atraves de uma consulta sql*/
    function getSQL($sql) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        $arrayItens = array();
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($this)) {
                $rs = $this -> DAO_ExecutarQuery($sql);                
                if ($this -> DAO_NumeroLinhas($rs) > 0) {
                    while ($arrayItem = $this -> DAO_GerarArray($rs)) {
                        $object = new $this;
                        $object -> setBean($arrayItem, $elemento);
                        array_push($arrayItens, $object);
                    }
                }
            }
        }
        return $arrayItens;
    }

    /*m�todo que recupera os elementos do banco sem pesquisar por filhos */

    function getClassRows($elemento, $order = array(), $filtro = array()) {
        //configura a ordenacao
        if (count($order) > 0) {
            $ordenacao = " order by ";
            foreach ($order as $key => $value) {
                $campo = $this -> getField($elemento, $value);
                $ordenacao .= $campo . ",";
            }

        }
        $ordenacao = substr($ordenacao, 0, strlen($ordenacao) - 1);
        //configura as clausulas where
        if (count($filtro) > 0) {
            $where = "where 1 = 1 ";
            foreach ($filtro as $key => $value) {

                $campo = $this -> getField($elemento, $key);
                $where .= " and $campo $value	";
            }
        }

        $sql = "select " . $this -> getFieldsList($elemento) . " from " . $elemento['tb-name'] . " $where $ordenacao ";

        $rs = $this -> DAO_ExecutarQuery($sql);
        $arrayItens = array();
        if ($this -> DAO_NumeroLinhas($rs) > 0) {
            while ($arrayItem = $this -> DAO_GerarArray($rs)) {
                $object = new $this;
                $object -> setBeanUnlazy($arrayItem, $elemento);
                array_push($arrayItens, $object);
            }
        }
        return $arrayItens;

    }

    function save() {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($this)) {
                //recupera o nome do atributo id da class
                $id = $this -> getIdElementXML($elemento);
                if ($this -> $id != NULL) {
                    //update
                    $sql = "update " . $elemento['tb-name'] . " set ";
                    foreach ($elemento->children() as $atributo) {
                        if ($atributo['role'] != "id" && $atributo['role'] != "set") {
                            $sql .= $atributo['tb-name'] . " = ";
                            if ($atributo['role'] == "fk") {
                                $elementFk = $this -> getClassElementXML($atributo['class-relation']);
                                $idfk = $this -> getIdElementXML($elementFk);
                                if ($this -> $atributo[0] != NULL)
                                    $sql .= $this -> $atributo[0] -> $idfk;
                                else
                                    $sql .= 'NULL';
                                $sql .= ", ";
                            } else {
                                if ($atributo['role'] == "str" || $atributo['role'] == "date" || $atributo['role'] == "txt")
                                    $sql .= "'" . $this -> conn -> real_escape_string($this -> $atributo[0]) . "'";
                                else
                                    $sql .= strlen($this -> $atributo[0]) > 0 ? $this -> $atributo[0] : "NULL";
                                $sql .= ", ";
                            }
                        }
                    }
                    $sql = substr($sql, 0, strlen($sql) - 2);
                    $sql .= " where " . $elemento['tb-id'] . " = " . $this -> $id;
                    $this -> DAO_ExecutarQuery($sql);
                    return $this -> id;
                } else {
                    //insert
                    $sql = "insert into " . $elemento['tb-name'] . " (";
                    $campos = "";
                    foreach ($elemento->children() as $atributo) {
                        if ($atributo['role'] != "id" && $atributo['role'] != "set") {
                            $sql .= $atributo['tb-name'] . ", ";
                            if ($atributo['role'] == "fk") {
                                $elementFk = $this -> getClassElementXML($atributo['class-relation']);
                                
                                $idfk = $this -> getIdElementXML($elementFk);
                                if ($this -> $atributo[0] != NULL)
                                    $campos .= $this -> $atributo[0] -> $idfk;
                                else
                                    $campos .= 'NULL';
                                $campos .= ", ";
                            } else {
                                if ($atributo['role'] == "str" || $atributo['role'] == "date" || $atributo['role'] == "txt")
                                    $campos .= "'" . $this -> conn -> real_escape_string($this -> $atributo[0]) . "'";
                                else
                                    $campos .= strlen($this -> $atributo[0]) > 0 ? $this -> $atributo[0] : "NULL";
                                $campos .= ", ";
                            }
                        }
                    }
                    $sql = substr($sql, 0, strlen($sql) - 2);
                    $campos = substr($campos, 0, strlen($campos) - 2);
                    $sql .= ") values(" . $campos;

                    $sql .= ")";

                    $this -> DAO_ExecutarQuery($sql);
                    $this -> id = $this -> DAO_recuperaUltimoIdInserido();
                    return $this -> id;
                }
            }
        }

    }

    /*recupera um objeto da classe pelo id com lazy at� segundo nivel*/
    function delete($id) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            if ($elemento['name'] == get_class($this)) {
                $sql = "delete from " . $elemento['tb-name'] . " where " . $elemento['tb-id'] . " = $id";

                if (!$this -> DAO_ExecutarDelete($sql)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    function getIdElementXML($class) {
        foreach ($class->children() as $atributo) {
            if ($atributo['role'] == "id")
                return $atributo[0];
        }
    }

    function getClassElementXML($nameClass) {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->children() as $elemento) {
            $name = substr($elemento['name'], 0, strlen($elemento['name']));
            if ($name == $nameClass) {
                return $elemento;
            }
        }
    }

    function objectToArray($obj) {

        $jsonarray = array();
        foreach ($obj as $key => $value) {
            if (!is_object($value)) {
                $jsonarray[$key] = utf8_encode($value);
            } else {
                $jsonarray[$key] = $this -> objectToArray($value);
            }
        }

        unset($jsonarray['conn']);
        unset($jsonarray['remetente']);
        unset($jsonarray['carregando']);
        unset($jsonarray['URI']);
        unset($jsonarray['desenvolvimento']);
        unset($jsonarray['mensagem']);
        unset($jsonarray['HASH_URL']);
        unset($jsonarray['PAGINACAO']);

        return $jsonarray;
    }

    function updateDb() {
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");

        foreach ($xml->class as $class) {
            if (in_array($class['name'],$_REQUEST['tabela'])) {
                //desabilita constraint
                $sql = "SET FOREIGN_KEY_CHECKS = 0;" . chr(13);
                $this -> DAO_ExecutarQuery($sql);
                //apaga tabela
                $sql = "DROP TABLE IF EXISTS `" . $class['tb-name'] . "`;";
                $this -> DAO_ExecutarQuery($sql);
                //cria tabela
                $sql = "CREATE TABLE `" . $class['tb-name'] . "` (";
                $atributos = "";
                $index = "";
                foreach ($class->atrib as $atrib) {
                    switch ($atrib['role']) {
                        case 'txt' :
                            $atributos .= "`" . $atrib['tb-name'] . "` " . $atrib['type'] . " " . $atrib['nullable'] . ($atrib['default'] != "" ? " DEFAULT '" . $atrib['default'] . "'" : "") . ",";
                            break;
                        case 'date' :
                            $atributos .= "`" . $atrib['tb-name'] . "` " . $atrib['type'] . " " . $atrib['nullable'] . ($atrib['default'] != "" ? " DEFAULT '" . $atrib['default'] . "'" : "") . ",";
                            $atributos .= "KEY (`" . $atrib['tb-name'] . "`),";
                            break;
                        case 'id' :
                            $atributos .= "`" . $atrib['tb-name'] . "` " . $atrib['type'] . " (" . $atrib['length'] . ") " . $atrib['nullable'] . " AUTO_INCREMENT,";
                            $atributos .= "PRIMARY KEY (`" . $atrib['tb-name'] . "`),";
                            break;
                        case 'fk' :
                            $atributos .= "`" . $atrib['tb-name'] . "` " . $atrib['type'] . " (" . $atrib['length'] . ") " . $atrib['nullable'] . ",";
                            $atributos .= "KEY (`" . $atrib['tb-name'] . "`),";
                            break;
                        case 'number' :
                            $atributos .= "`" . $atrib['tb-name'] . "` " . $atrib['type'] . " (" . $atrib['length'] . ") " . $atrib['nullable'] . ($atrib['default'] != "" ? " DEFAULT '" . $atrib['default'] . "'" : "") . ",";
                            $atributos .= "KEY (`" . $atrib['tb-name'] . "`),";
                            break;
                        case 'str' :
                            $atributos .= "`" . $atrib['tb-name'] . "` " . $atrib['type'] . " (" . $atrib['length'] . ") " . $atrib['nullable'] . ($atrib['default'] != "" ? " DEFAULT '" . $atrib['default'] . "'" : "") . ",";
                            $atributos .= "KEY (`" . $atrib['tb-name'] . "`),";
                            break;
                        default :
                            break;
                    }

                }
                $sql .= substr($atributos, 0, -1) . ") ENGINE=InnoDB DEFAULT CHARSET=" . $class['charset'] . " AUTO_INCREMENT=" . $class['auto_increment'] . ";";                
                $this -> DAO_ExecutarQuery($sql);

                //habilita contranints
                $sql = "SET FOREIGN_KEY_CHECKS = 1;" . chr(13);
                $this -> DAO_ExecutarQuery($sql);

            }
        }
        foreach ($xml->class as $class) {
            if (in_array($class['name'],$_REQUEST['tabela'])) {
                foreach ($class->atrib as $atrib) {
                    if ($atrib['role'] == "fk") {
                        $sql = "ALTER TABLE `" . $class['tb-name'] . "` ADD FOREIGN KEY (`" . $atrib['tb-name'] . "`) REFERENCES `" . $atrib['tb-relation'] . "`(`" . $atrib['col-relation'] . "`) ON DELETE " . $atrib['on-delete'] . " ON UPDATE " . $atrib['on-update'] . ";";
                        $this -> DAO_ExecutarQuery($sql);
                    }
                }
            }
        }
    }

}
