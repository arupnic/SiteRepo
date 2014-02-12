$(function() {
  $('input[type="submit"]').button();
  $('input[type="reset"]').button();
  $("#HODMobile").numericInput();
  $("#DeptNumber").numericInput();
//calling ajax for saving data.............
  $("form").on("submit", function(event) {
    event.preventDefault();
    $('#Msg').html('Saving Please Wait...');
    $.ajax({
      type: 'POST',
      url: 'AjaxSaveData.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      //data: $("#frmDepartment").serialize(),
      data: {
        'FormToken': $('#FormToken').val(),
        'AjaxToken': $('#AjaxToken').val(),
        'CmdSubmit': 'Create Department',
        'DeptName': $("#DeptName").val(),
        'HODName': $("#HODName").val(),
        'HODMobile': $("#HODMobile").val(),
        'HODEmail': $("#HODEmail").val(),
        'DeptNumber': $("#DeptNumber").val(),
        'Strength': $("#Strength").val(),
        'DeptAddress': $("#DeptAddress").val()
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#Ajax").val(DataResp.FormToken);
        $("#Msg").html(DataResp.Msg + DataResp.CheckVal);
        if (DataResp.CheckVal === null)
        {
          $('#frmDepartment').trigger("reset");
        }
        delete DataResp;
      }
      catch (e) {
        $('#Msg').html('Server Error:' + e);
        $('#Error').html(data);
      }
    }).fail(function(msg) {
      $('#Msg').html(msg);
    });
  });
  $('#Msg').html('Loaded Successfully');
});