<?php
/**
 * SysGen - System Generator with Formdin Framework
 * Download Formdin Framework: https://github.com/bjverde/formDin
 *
 * @author  Bjverde <bjverde@yahoo.com.br>
 * @license https://github.com/bjverde/sysgen/blob/master/LICENSE GPL-3.0
 * @link    https://github.com/bjverde/sysgen
 *
 * PHP Version 5.6
 */

class CreateApiRoutesCall extends TCreateFileContent
{
    private $listTableNames;

    public function __construct($listTableNames)
    {
        $this->setListTableNames($listTableNames);
        $this->setFileName('routes.php');
        $path = TGeneratorHelper::getPathNewSystem().DS.'api'.DS;
        $this->setFilePath($path);
    }
    //--------------------------------------------------------------------------------------
    public function setListTableNames($listTableNames)
    {
        TGeneratorHelper::validateListTableNames($listTableNames);
        $this->listTableNames = $listTableNames;
    }
    public function getListTableNames()
    {
        return $this->listTableNames;
    }
    //--------------------------------------------------------------------------------------
    private function addClass()
    {
        $listTableNames = $this->getListTableNames();
        foreach ($listTableNames['TABLE_NAME'] as $tableName) {
            $this->addLine(ESP.','.$tableName.'API');
        }
    }
    //--------------------------------------------------------------------------------------
    private function addFileRouter()
    {
        $listTableNames = $this->getListTableNames();
        foreach ($listTableNames['TABLE_NAME'] as $tableName) {
            $this->addLine('require_once \'routes\'.DS.\''.$tableName.'.route.php\';');
        }
    }
    //--------------------------------------------------------------------------------------
    public function show($print = false)
    {
        $this->lines=null;
        $this->addLine('<?php');
        $this->addSysGenHeaderNote();
        $this->addBlankLine();
        $this->addLine('use Controllers\{');
        $this->addLine(ESP.'SysinfoAPI');
        $this->addClass();
        $this->addLine('};');
        $this->addBlankLine();
        $this->addLine('$app = new \Slim\App(slimConfiguration());');
        $this->addBlankLine();
        $this->addLine('$app->get(\'/sysinfo\', SysinfoAPI::class . \':getInfo\');');
        $this->addBlankLine();
        $this->addFileRouter();
        $this->addBlankLine();
        $this->addLine('$app->run();');
        if ($print) {
            echo $this->getLinesString();
        } else {
            return $this->getLinesString();
        }
    }
}
