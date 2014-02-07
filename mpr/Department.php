<?php
require_once __DIR__ . '/../lib.inc.php';

WebLib::AuthSession();
WebLib::Html5Header('Departments');
WebLib::IncludeCSS();
WebLib::JQueryInclude();
//WebLib::IncludeJS('mpr/js/forms.js');
WebLib::IncludeJS('mpr/js/Department.js');
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
        <h3>Create New Department</h3>
        <div class="FieldGroup">
          <label for="DeptName"><span class="myfont">Name of Department</span>
            <input type="text" name ="DeptName" id="DeptName"
                   placeholder="Name of Department" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="HODName"><span class="myfont">Name of The HOD</span>
            <input type="text" id="HODName" name="HODName" value=""
                   placeholder="Name of The HOD" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="HODMobile"><span class="myfont">Mobile Number Of HOD</span>
            <input type=text name="HODMobile" id="HODMobile" value=""
                   placeholder="Mobile Number" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="HODEmail"><span class="myfont">Email Of HOD</span>
            <input type=email name="HODEmail" id="HODEmail" value=""
                   placeholder="HOD Email" required/>
          </label>
        </div>

        <div class="FieldGroup">
          <label for="DeptNumber"><span class="myfont">Land Line Number Of Department</span>
            <input type=text name="DeptNumber" id="DeptNumber" value=""
                   placeholder="Landline Number" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="Strength"><span class="myfont">Staff Strength Of Department</span>
            <input type=text name="Strength" id="Strength" value=""
                   placeholder="Staff Strength" required/>
          </label>
        </div>
        <div class="FieldGroup">
          <label for="DeptAddress"><span class="myfont">Address Of Department</span>
            <textarea name="DeptAddress" id="DeptAddress" rows="5" cols="20"
                      placeholder="Enter Department Address here..." required></textarea>
          </label>
        </div>
        <div style="clear: both;"></div>
        <div class="formControl">
          <input type="submit" name="CmdSubmit" value="Create Department" id="CmdSaveUpdate">
          <input type="hidden" id="TxtAction" name="CmdSubmit" value="" />
          <input type="reset" name="CmdReset" value="Reset">
        </div>
        <input type="hidden" name="FormToken" id="FormToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'FormToken') ?>" />
        <input type="hidden" id="AjaxToken"
               value="<?php echo WebLib::GetVal($_SESSION, 'Token'); ?>" />
      </form>
      <pre id="Error">
      </pre>
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