<?php
class Zurc {
    public function retornaTipo($filename) {
        $arr = explode(".", $filename);
        $retorno = "txt";
        if (count($arr) > 1) {
            $ext = strtolower(substr($arr[1], 0, 3));
            $retorno = $ext;
        }
        return $retorno;
    }

    public function dirToArray($dir, &$result = NULL) {
        if ($result == null)
            $result = array();

        $cdir = scandir($dir, SCANDIR_SORT_ASCENDING);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $this -> dirToArray($dir . DIRECTORY_SEPARATOR . $value, $result);
                } else {
                    array_push($result, $dir . DIRECTORY_SEPARATOR . $value);
                }
            }
        }

        return $result;
    }

    public function loadClass() {
        $dir = URI . "/src/model";
        $classes = $this -> dirToArray($dir);
        foreach ($classes as $key => $class) {
            require_once ($class);
        }
    }

    public function controllers() {

        if (isset($_SERVER['REDIRECT_URL'])) {
            $file = "src/control/" . str_replace(PASTA, "", substr(str_replace("-", "/",$_SERVER['REDIRECT_URL']), 1)) . ".php";
            
            if (file_exists($file)) {
                try {
                    include ($file);
                } catch(Exception $e) {
                    if(DESENVOLVIMENTO)
                    throw new Exception("<b>Mensagem de erro:</b> ".$e->getMessage()."<br/><b>Arquivo:</b> ".$e->getFile()."<br/><b>Linha:</b> ".$e->getLine() , 500);
                    else
                        throw new Exception("Erro na aplicacao, iremos trabalhar para solucionar este problema.", 500);
                    
                        
                }
                
            } else {
                throw new Exception("A funcionalidade solicitada não existe.", 404);
            }
        }else{
             try {    
            include ("src/control/" .str_replace("-", "/",MAIN_CONTROLE) . ".php");
            } catch(Exception $e) {
                if(DESENVOLVIMENTO)
                throw new Exception("<b>Mensagem de erro:</b> ".$e->getMessage()."<br/><b>Arquivo:</b> ".$e->getFile()."<br/><b>Linha:</b> ".$e->getLine(), 500);
                else
                        throw new Exception("Erro na aplicacao, iremos trabalhar para solucionar este problema.", 500);
            }
        }

    }

    public function createClass(){
        $xml = simplexml_load_file(URI . "/src/config/dao.xml");
        foreach ($xml->class as $class) {
            if(!file_exists(URI."/src/model/myapp/".strtolower($class['name']).".php")){
                $file = fopen(URI."/src/model/myapp/".strtolower($class['name']).".php", "x");
                fwrite($file, "<?php ".chr(13)."class ".$class['name']." extends Dao {".chr(13));
                 foreach ($class->atrib as $atrib) {
                    if ($atrib['role'] != "id") {
                           if ($atrib['role'] == "fk") {
                                   fwrite($file, " var $".$atrib." = NULL;".chr(13));
                           }else{     
                                fwrite($file, " var $".$atrib.";".chr(13));
                           }
                    }     
                 }
                fwrite($file,"}");
                fclose($file);
            }       
                
        }
    }
    public function start(){
       // $conn = Conexao::init();
		
    }
    public function end(){
        //$conn->connection->commit();
    }
  	public function updateDb(){
  		if(BD){
  		    $this->createClass();
  			$dao = new Dao();
			$dao->updateDb();
  		}
  	}
  	
    public function executaScript(){
        if(BD){
            $dao = new Dao();
            $file = file_get_contents($_FILES['arquivo']['tmp_name']);
            $arraySql = explode(";", $file);
            foreach ($arraySql as $key => $sql) {
                if(strlen(trim($sql)) > 0){
                $dao->DAO_ExecutarQuery($sql);
                }    
            }
            
            
            
            
        }
    }

}
