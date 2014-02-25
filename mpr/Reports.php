<?php
//ini_set('display_errors', '1');
//error_reporting(E_ALL);

require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Reports');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
WebLib::IncludeCSS('css/chosen.css');
WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeCSS('mpr/css/forms.css');
WebLib::IncludeJS('js/chosen.jquery.min.js');
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
WebLib::IncludeJS('mpr/js/Reports.js');
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
    <?php
    if (WebLib::GetVal($_SESSION, 'Token') === null) {
      $_SESSION['Token'] = md5($_SERVER['REMOTE_ADDR'] . session_id() . $_SESSION['ET']);
    }
    ?>
    <div class="formWrapper">
      <form id="frmModify" method="post" autocomplete="off"
            action="<?php
            echo WebLib::GetVal($_SERVER, 'PHP_SELF');
            ?>" >
        <h3>Process </h3>
        <span class="Message" id="Msg" style="float: right;">
          <b>Loading please wait...</b>
        </span>
        <?php
        include __DIR__ . '/DataMPR.php';
        WebLib::ShowMsg();
        ?>

        <div class="FieldGroup">
          <label for="SectorName"><strong>Sector</strong></label><br/>
          <select name="SectorName" id="SectorID" data-placeholder="Select Sector">
          </select>
        </div>
        <div class="FieldGroup">
          <label for="DeptName"><strong>Department</strong></label><br/>
          <select name="Deptname" id="DeptID" data-placeholder="Select Department">
          </select>
        </div>
        <div class="FieldGroup">
          <label for="SchemeName"><strong>Scheme</strong></label><br/>
          <select name="SchemeName" id="SchemeID" data-placeholder="Select Sector">
          </select>
        </div>
        <div class="FieldGroup">
          <br/>
          <input type="button" id="CmdRefresh" name="CmdRefresh" value="Refresh"/>
          <input type="hidden" id="FormToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
          <input type="hidden" id="AjaxToken"
                 value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
        </div>
        <div style="clear: both;"></div>
        <div id="visualization" style="width:400; height:300"></div>
      </form>
    </div>
    <pre id="Error">
    </pre>
  </div>
  <div class="pageinfo">
    <?php WebLib::PageInfo(); ?>
  </div>
  <div class="footer">
    <?php WebLib::FooterInfo(); ?>
  </div>
</body>
</html>