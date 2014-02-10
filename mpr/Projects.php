<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Projects');
WebLib::IncludeCSS();
WebLib::IncludeCSS('css/chosen.css');
WebLib::JQueryInclude();
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeJS('mpr/js/Project.js');
WebLib::IncludeCSS('mpr/css/forms.css');
?>
</head>
<body>
  <div class="TopPanel">
    <div class="LeftPanelSide"></div>
    <div class="RightPanelSide"></div>
    <h1><?php echo AppTitle; ?></h1>
  </div>
  <div class="Header"></div>
  <?php
  WebLib::ShowMenuBar('MPR');
  ?>
  <div class="content">
    <span class="Message" id="Msg" style="float: right;">
      <b>Loading please wait...</b>
    </span>
    <div class="formWrapper">
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmSector" >
        <fieldset>
          <h3>Create New Sector</h3>
          <div class="FieldGroup">
            <label for="SectorName"><span class="myfont">Name of Sector</span>
              <input type="text" id="SectorName" name="SectorName"
                     placeholder="Name of Sector" size="25"/>
            </label>
          </div>
          <div style="clear: both;"></div>
          <hr/>
          <div class="formControl">
            <input type="button" name="CmdSubmit" value="Create Sector" id="CmdSaveSector">
            <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
            <input type="reset" name="CmdReset" value="Reset">
          </div>
          <input type="hidden" name="FormToken" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </fieldset>
      </form>
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmScheme" >
        <fieldset>
          <h3>Create New Scheme</h3>
          <div class="FieldGroup">
            <label for="DeptID"><span class="myfont">Select Name of Department</span>
              <select id="DeptID" name="DeptID"
                      data-placeholder="Select Department"
                      >
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="SectorID"><span class="myfont">Select Name of Sectors</span>
              <select id="SectorID" name="SectorID"
                      data-placeholder="Select Sector"
                      >
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="SchemeName"><span class="myfont">Name of Schemes</span>
              <input type="text" name="SchemeName" id="SchemeName"
                     placeholder="Name of Schemes"size="23"/>
            </label>
          </div>
          <div style="clear: both;"></div>
          <hr/>
          <div class="formControl">
            <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
            <input type="button" name="CmdSubmit" value="Create Scheme" id="CmdSaveScheme"/>
            <input type="reset" name="CmdReset" value="Reset">
          </div>
          <input type="hidden" name="FormToken" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </fieldset>
      </form>
      <form method="post" action="<?php
      echo WebLib::GetVal($_SERVER, 'PHP_SELF');
      ?>" id="frmProject" >
        <fieldset>
          <h3>Create New Project</h3>
          <?php
          $Data  = new MySQLiDB();
          $Data1 = new MySQLiDBHelper();
          ?>
          <div class="FieldGroup">
            <label for="SchemeID"><span class="myfont">Select Scheme</span>
              <select id="SchemeID" name="SchemeID"
                      data-placeholder="Select Scheme">
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="ProjectName"><span class="myfont">Name of Project</span>
              <input type="text" name="ProjectName" id="ProjectName"
                     placeholder="Name of Projects"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="ProjectCost"><span class="myfont">Project Cost</span>
              <input type="text" name="ProjectCost" id="ProjectCost"
                     placeholder="Project Cost"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AlotmentAmount"><span class="myfont">
                Project Allotment Amount</span>
              <input type="text" name="AlotmentAmount" id="AlotmentAmount"
                     placeholder="Project Allotment Amount"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="StartDate"><span class="myfont">Project Start Date</span>
              <input type="text" id="StartDate" name="StartDate"
                     placeholder="YYYY-MM-DD" size="12" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AlotmentDate"><span class="myfont">Project Allotment Date
              </span>
              <input type="text" id="AlotmentDate" name="AlotmentDate"
                     placeholder="YYYY-MM-DD" size="12"  />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="TenderDate"><span class="myfont">Project Tender Date</span>
              <input type="text" id="TenderDate" name="TenderDate"
                     placeholder="YYYY-MM-DD" size="12" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="WorkOrderDate"><span class="myfont">Project Work Order Date</span>
              <input type="text" id="WorkOrderDate" name="WorkOrderDate"
                     placeholder="YYYY-MM-DD"  size="12" />
            </label>
          </div>
          <div style="clear: both;"></div>
          <hr/>
    <!--          <pre id="Error">
          </pre>-->
          <div class="formControl">
            <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
            <input type="button" name="CmdSubmit" value="Create Project" id="CmdSaveProject">
            <input type="reset" name="CmdReset" value="Reset">
            <input type="hidden" name="FormToken" id="FormToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
            <input type="hidden" id="AjaxToken"
                   value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

