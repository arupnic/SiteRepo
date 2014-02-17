<?php

function CreateSchemas() {
  $ObjDB = new MySQLiDBHelper();
  $ObjDB->ddlQuery(SQLDefs('MPR_Departments'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Sectors'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Schemes'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Progress'));
  $ObjDB->ddlQuery(SQLDefs('MPR_Blocks'));
  $ObjDB->ddlQuery(SQLDefs('MPR_DataBlocks'));
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
    case 'MPR_Blocks':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`BlockID` varchar(3) NOT NULL,'
          . '`BlockName` varchar(25) DEFAULT NULL,'
          . '`SubDivnCode` varchar(4) DEFAULT NULL,'
          . ' PRIMARY KEY (`BlockID`)'
          . ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
      break;
    case 'MPR_DataBlocks':
      $SqlDB = 'INSERT INTO `' . MySQL_Pre . 'MPR_Blocks` '
          . '(`BlockID`, `BlockName`, `SubDivnCode`) VALUES'
          . '(\'0bm\', \'OTHERS\', NULL),'
          . '(\'B01\', \'MIDNAPORE SADAR\', \'1501\'),'
          . '(\'B02\', \'KESHPUR\', \'1501\'),'
          . '(\'B03\', \'SALBONI\', \'1501\'),'
          . '(\'B04\', \'GARHBETA-I\', \'1501\'),'
          . '(\'B05\', \'GARHBETA-II\', \'1501\'),'
          . '(\'B06\', \'GARHBETA-III\', \'1501\'),'
          . '(\'B07\', \'KHARAGPUR-I\', \'1502\'),'
          . '(\'B08\', \'KHARAGPUR-II\', \'1502\'),'
          . '(\'B09\', \'DEBRA\', \'1502\'),'
          . '(\'B10\', \'SABONG\', \'1502\'),'
          . '(\'B11\', \'PINGLA\', \'1502\'),'
          . '(\'B12\', \'KESHIARY\', \'1502\'),'
          . '(\'B13\', \'DANTAN-I\', \'1502\'),'
          . '(\'B14\', \'DANTAN-II\', \'1502\'),'
          . '(\'B15\', \'NARAYANGARH\', \'1502\'),'
          . '(\'B16\', \'MOHANPUR\', \'1502\'),'
          . '(\'B17\', \'GHATAL\', \'1503\'),'
          . '(\'B18\', \'CHANDRAKONA-I\', \'1503\'),'
          . '(\'B19\', \'CHANDRAKONA-II\', \'1503\'),'
          . '(\'B20\', \'DASPUR-I\', \'1503\'),'
          . '(\'B21\', \'DASPUR-II\', \'1503\'),'
          . '(\'B22\', \'JHARGRAM\', \'1504\'),'
          . '(\'B23\', \'BINPUR-I\', \'1504\'),'
          . '(\'B24\', \'BINPUR-II\', \'1504\'),'
          . '(\'B25\', \'GOPIBALLAVPUR-I\', \'1504\'),'
          . '(\'B26\', \'GOPIBALLAVPUR-II\', \'1504\'),'
          . '(\'B27\', \'NAYAGRAM\', \'1504\'),'
          . '(\'B28\', \'SANKRAIL\', \'1504\'),'
          . '(\'B29\', \'JAMBONI\', \'1504\'),'
          . '(\'M01\', \'MIDNAPORE MUNICIPALITY\', \'1501\'),'
          . '(\'M02\', \'KHARAGPUR MUNICIPALITY\', \'1502\'),'
          . '(\'M03\', \'JHARGRAM MUNICIPALITY\', \'1504\'),'
          . '(\'M04\', \'CHANDRAKONA MUNICIPALITY\', \'1503\'),'
          . '(\'M05\', \'KHIRPAI MUNICIPALITY\', \'1503\'),'
          . '(\'M06\', \'RAMJIBANPUR MUNICIPALITY\', \'1503\'),'
          . '(\'M07\', \'KHARAR MUNICIPALITY\', \'1503\'),'
          . '(\'M08\', \'GHATAL MUNICIPALITY\', \'1503\');';
      break;
    case 'MPR_Schemes':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`SchemeID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`SchemeName` VARCHAR(100) DEFAULT NULL,'
          . '`DeptID` INT(10),'
          . '`SectorID` INT(10),'
          . '`BlockID` VARCHAR(10),'
          . '`Executive` VARCHAR(10),'
          . '`PhysicalTargetNo` INT(10),'
          . '`SchemeCost` INT(10),'
          . '`StartDate` date,'
          . '`AlotmentAmount` INT(10),'
          . '`AlotmentDate` date,'
          . '`TenderDate` date,'
          . '`WorkOrderDate` date,'
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
    case 'MPR_Progress':
      $SqlDB = 'CREATE TABLE IF NOT EXISTS `' . MySQL_Pre . $ObjectName . '` ('
          . '`ReportID` int(10) NOT NULL AUTO_INCREMENT,'
          . '`UserMapID` INT(10) DEFAULT 1,'
          . '`ProjectID` INT(10),'
          . '`ReportDate` date,'
          . '`PhysicalProgress` INT(10),'
          . '`FinancialProgress` INT(10),'
          . '`Remarks` VARCHAR(300) DEFAULT NULL,'
          . ' PRIMARY KEY (`ReportID`),'
          . ' CONSTRAINT `FK_ProjectID` FOREIGN KEY (`ProjectID`)'
          . ' REFERENCES `' . MySQL_Pre . 'MPR_Projects` (`ProjectID`) '
          . ' ON UPDATE CASCADE'
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
