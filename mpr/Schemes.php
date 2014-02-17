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
      ?>"
            id="frmScheme" >
        <fieldset>
          <h3>Create New Scheme</h3>
          <div class="FieldGroup">
            <label for="DeptID"><span class="myfont">Select Name of Department</span>
              <select id="DeptID" name="DeptID"
                      data-placeholder="Select Department"required
                      >
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="SectorID"><span class="myfont">Select Name of Sectors</span>
              <select id="SectorID" name="SectorID"
                      data-placeholder="Select Sector"required
                      >
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="BlockID"><span class="myfont">Select Name of Block</span>
              <select id="BlockID" name="BlockID"
                      data-placeholder="Select Block"required>
              </select></label>
          </div>
          <div class="FieldGroup">
            <label for="SchemeName"><span class="myfont">Name of Schemes</span>
              <input type="text" name="SchemeName" id="SchemeName"
                     placeholder="Name of Schemes"size="23"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="PhysicalTargetNo"><span class="myfont">Physical Target No</span>
              <input type="text" name="PhysicalTargetNo" id="PhysicalTargetNo"
                     placeholder="Physical Target No"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Executive"><span class="myfont">Executive Agency-Deptt./BDO</span>
              <input type="text" name="Executive" id="Executive"
                     placeholder="Executive Agency"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="SchemeCost"><span class="myfont">Scheme Estimated Cost</span>
              <input type="text" name="SchemeCost" id="SchemeCost"
                     placeholder="Scheme Cost"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AlotmentAmount"><span class="myfont">
                Scheme Allotment Amount</span>
              <input type="text" name="AlotmentAmount" id="AlotmentAmount"
                     placeholder="Scheme Allotment Amount"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="StartDate"><span class="myfont">Scheme Start Date</span>
              <input type="text" id="StartDate" name="StartDate"
                     placeholder="YYYY-MM-DD" size="12" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="AlotmentDate"><span class="myfont">Scheme Allotment Date
              </span>
              <input type="text" id="AlotmentDate" name="AlotmentDate"
                     placeholder="YYYY-MM-DD" size="12"  />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="TenderDate"><span class="myfont">Scheme Tender Date</span>
              <input type="text" id="TenderDate" name="TenderDate"
                     placeholder="YYYY-MM-DD" size="12" />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="WorkOrderDate"><span class="myfont">Scheme Work Order Date</span>
              <input type="text" id="WorkOrderDate" name="WorkOrderDate"
                     placeholder="YYYY-MM-DD"  size="12" />
            </label>
          </div>
          <div style="clear: both;"></div>
          <hr/>
          <div class="formControl">
            <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
            <input type="button" name="CmdSubmit" value="Create Scheme" id="CmdSaveScheme"/>
            <input type="button" name="CmdReset" id="CmdReset" value="Reset">
          </div>
          <input type="hidden" name="FormToken" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </fieldset>
      </form>
    </div>
  </div>
  <div class="pageinfo">
    <?php WebLib:: PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>

