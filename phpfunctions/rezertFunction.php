<?php

class className extends JobRouter\Engine\Runtime\PhpFunction\RuleExecutionFunction
{
	public function execute($rowId = null)
	{
        $dwdocid = $this->getTableValue('import_dwdocid');
        
        $externalDB = $this->getDBConnection('Docuware_Verbindung');
        $sql = 'SELECT MANDANT, JAHR, KATEGORIE_1, KATEGORIE_2, KATEGORIE_3, KATEGORIE_4, BETREFF
                FROM Jahresabschluss
                WHERE DWDOCID = :dwdocid ';
        $parameters = [
            'dwdocid' => $dwdocid
        ];
    
        $types = [];
        $result = $externalDB->preparedSelect($sql, $parameters, $types);

        while ($row = $externalDB->fetchRow($result)) {
            $this->setTableValue('mandant', $row['MANDANT']);
            $this->setTableValue('financialYear', $row['JAHR']);
            $this->setTableValue('category1', $row['KATEGORIE_1']);
            $this->setTableValue('category2', $row['KATEGORIE_2']);
            $this->setTableValue('category3', $row['KATEGORIE_3']);
            $this->setTableValue('category4', $row['KATEGORIE_4']);
            $this->setTableValue('subject', $row['BETREFF']);
        }
	}
}
?>