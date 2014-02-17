<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);

require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Progress');
WebLib::IncludeCSS();
WebLib::JQueryInclude();

//WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeJS('mpr/js/progress.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
WebLib::IncludeCSS('css/chosen.css');
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
      <b>Loaded Successfully..</b>
    </span>
    <div class="formWrapper">
      <form method="post" id="frmProgress"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>"
            id="frmProgress" >
        <h3>Process </h3>
        <?php
        include __DIR__ . '/DataMPR.php';
        WebLib::ShowMsg();
        $Data  = new MySQLiDB();
        $Data1 = new MySQLiDBHelper();
        ?>
        <div class="FieldGroup">
          <div class="FieldGroup">
            <label for="SchemeID">
              <span class="myfont">Scheme Name</span>
              <select name="SchemeID" id="SchemeID"
                      data-placeholder="Select Scheme">
              </select>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="ReportDate">
              <span class="myfont">Report Date</span>
              <input type="text" id="ReportDate" name="ReportDate"
                     placeholder="YYYY-MM-DD" size="12" required />
            </label>
          </div>
          <div class="FieldGroup">
            <label for="LastReportDate">
              <span class="myfont">Last Report Date</span>
              <input type="text" id="LastReportDate" name="LastReportDate"
                     placeholder="LastReportDate" size="12" readonly="readonly"/>
            </label>
          </div>
          <div style="clear: both;"></div>

          <h3 id="lblPhysicalProgress">Physical Progress</h3>
          <input type="hidden" name="PhysicalProgress"
                 id="PhysicalProgress" />
          <div style="clear: both;"></div>
          <div id="PhysicalSlider" class="jQuery-Slider"></div>

          <h3 id="lblFinancialProgress">Financial Progress</h3>
          <input type="hidden" name="FinancialProgress"
                 id="FinancialProgress" />
          <div id="FinancialSlider" class="jQuery-Slider"></div>
          <div class="FieldGroup">
            <label for="OldRemarks">
              <span class="myfont">Old Remarks</span>
              <input type="text" name="OldRemarks" id="OldRemarks"
                     placeholder="OldRemarks" readonly="readonly"/>
            </label>
          </div>
          <div class="FieldGroup">
            <label for="Remarks">
              <span class="myfont">Give a New Remarks Here..!</span>
              <input type="text" name="Remarks" id="Remarks"
                     placeholder="Remarks" required/>
            </label>
          </div>
          <div class="FieldGroup">
            <input type="hidden" id="ProgressID" name="ProgressID"/>
          </div>
        </div>
        <div style="clear: both;"></div>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Save Progress" id="CmdSaveUpdate">
          <input type="hidden" id="TxtAction" name="CmdSubmit" value=" " />
          <input type="button" value="Refresh"  id="Reload">
        </div>
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
        <input type="hidden" name="AjaxToken" id="AjaxToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
<!--        <pre id="Error">
        </pre>-->
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