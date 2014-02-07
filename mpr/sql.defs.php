<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('MPR_Departments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Sectors'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Schemes'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Projects'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Progress'));
  $ObjDB->ddlQuery(SQLDefs('MenuData'));
  unset($ObjDB);
}

function SQLDefs($ObjectName) {
  $SqlDB = '';
  switch ($ObjectName) {
    case 'MPR_Departments':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`DeptID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`DeptName` VARCHAR(100) DEFAULT NULL,'
          . '`HODName` VARCHAR(100) DEFAULT NULL,'
          . '`HODMobile` VARCHAR(100) DEFAULT NULL,'
          . '`HODEmail` VARCHAR(100) DEFAULT NULL,'
          . '`DeptNumber` VARCHAR(100) DEFAULT NULL,'
          . '`Strength` VARCHAR(100) DEFAULT NULL,'
          . '`DeptAddress` VARCHAR(100) DEFAULT NULL,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . ' PRIMARY KEY (`DeptID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Sectors':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SectorID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`SectorName` VARCHAR(100) DEFAULT NULL,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . 'UNIQUE KEY `SectorName` (`SectorName`),'
          . ' PRIMARY KEY (`SectorID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Schemes':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SchemeID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`SchemeName` VARCHAR(100) DEFAULT NULL,'
          . '`DeptID` INT(10),'
          . '`SectorID` INT(10),'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . 'UNIQUE KEY `SchemeName` (`SchemeName`,`DeptID`,`SectorID`),'
          . ' PRIMARY KEY (`SchemeID`),'
          . ' KEY `DeptID` (`DeptID`),'
          . ' KEY `SectorID` (`SectorID`),'
          . ' CONSTRAINT `FK_SectorID` FOREIGN KEY (`SectorID`)'
          . ' REFERENCES `' . MySQL_Pre . 'MPR_Sectors` (`SectorID`)'
          . ' ON UPDATE CASCADE,'
          . ' CONSTRAINT `FK_DeptID` FOREIGN KEY (`DeptID`) '
          . ' REFERENCES `' . MySQL_Pre . 'MPR_Departments` (`DeptID`)'
          . ' ON UPDATE CASCADE'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Projects':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`ProjectID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`SchemeID` INT(10),'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . '`ProjectName` VARCHAR(100) DEFAULT NULL,'
          . '`ProjectCost` INT(10),'
          . '`StartDate` date,'
          . '`AlotmentAmount` INT(10),'
          . '`AlotmentDate` date,'
          . '`TenderDate` date,'
          . '`WorkOrderDate` date,'
          . ' PRIMARY KEY (`ProjectID`),'
          . ' UNIQUE KEY `ProjectName` (`ProjectName`,`SchemeID`),'
          . ' KEY `SchemeID` (`SchemeID`),'
          . ' CONSTRAINT `FK_SchemeID` FOREIGN KEY (`SchemeID`)'
          . ' REFERENCES `' . MySQL_Pre . 'MPR_Schemes` (`SchemeID`) '
          . ' ON UPDATE CASCADE'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_Progress':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`ReportID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . '`ReportDate` date,'
          . '`ProjectID` INT(10),'
          . '`PhysicalProgress` INT(10),'
          . '`FinancialProgress` INT(10),'
          . '`Remarks` VARCHAR(300) DEFAULT NULL,'
          . ' PRIMARY KEY (`ReportID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_UserMaps':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`DeptID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`DeptName` VARCHAR(100) DEFAULT NULL,'
          . ' PRIMARY KEY (`DeptID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MenuData':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MenuItems` '
          . '(`AppID`,`MenuOrder`,`AuthMenu`,`Caption`,`URL`,`Activated`) VALUES'
          . '(\'MPR\', 1, 0, \'Home\', \'index.php\', 1),'
          . '(\'MPR\', 2, 1, \'Department\', \'mpr/Department.php\', 1),'
          . '(\'MPR\', 3, 1, \'Sectors\', \'mpr/Sectors.php\', 1),'
          . '(\'MPR\', 4, 1, \'Schemes\', \'mpr/Schemes.php\', 1),'
          . '(\'MPR\', 5, 1, \'Projects\', \'mpr/Projects.php\', 1),'
          . '(\'MPR\', 6, 1, \'Progress\', \'mpr/Progress.php\', 1),'
          . '(\'MPR\', 7, 1, \'Reports\', \'mpr/Reports.php\', 1),'
          . '(\'MPR\', 8, 1, \'Log Out!\', \'login.php?LogOut=1\', 1);';
      break;
  }
  return $SqlDB;
}

?>
