<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
//WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeJS('mpr/js/mpr.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
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
      ?>" id="frmDepartment" ><?php
            include __DIR__ . '/DataMPR.php';
            WebLib::ShowMsg();
            ?>
        <h3>Create New Project</h3>
        <?php
        $Data  = new MySQLiDB();
        $Data1 = new MySQLiDBHelper();
        ?>
        <div class="FieldGroup">
          <label for="SchemeName"><span class="myfont">Select Scheme</span>
            <select id="SchemeID" name="SchemeID"
                    data-placeholder="Select Scheme">
            </select>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="ProjectName"><span id="myfont">Name of Project</span>
            <input type="text" name="ProjectName" id="ProjectName"
                   placeholder="Name of Projects"/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="ProjectCost"><span id="myfont">Project Cost</span>
            <input type="text" name="ProjectCost" id="ProjectCost"
                   placeholder="Project Cost"/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="AlotmentAmount"><span id="myfont">
              Project Allotment Amount</span>
            <input type="text" name="AlotmentAmount" id="AlotmentAmount"
                   placeholder="Project Allotment Amount"/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="StartDate"><span id="myfont">Project Start Date</span>
            <input type="text" id="StartDate" name="StartDate"
                   placeholder="YYYY-MM-DD" size="12" />
          </label>
        </div>
        <div class="FieldGroup">
          <label for="AlotmentDate"><span id="myfont">Project Allotment Date
            </span>
            <input type="text" id="AlotmentDate" name="AlotmentDate"
                   placeholder="YYYY-MM-DD" size="12"  />
          </label>
        </div>
        <div class="FieldGroup">
          <label for="TenderDate"><span id="myfont">Project Tender Date</span>
            <input type="text" id="TenderDate" name="TenderDate"
                   placeholder="YYYY-MM-DD" size="12" />
          </label>
        </div>
        <div class="FieldGroup">
          <label for="WorkOrderDate"><span id="myfont">Project Work Order Date</span>
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
          <input type="submit" name="CmdSubmit" value="Create Project" id="CmdSaveUpdate">
          <input type="reset" name="CmdReset" value="Reset">
          <input type="hidden" name="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </div>
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

