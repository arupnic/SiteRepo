$(function() {
  $('input[type="submit"]').button();
  $('input[type="reset"]').button();
  $('#CmdSaveUpdate').on("click", function() {
    $("#TxtAction").val($(this).val());
  });
  $('#StartDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $('#AlotmentDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $('#TenderDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $('#WorkOrderDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $('#ReportDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#DeptID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"});
  $("#SectorID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"});
  $("#SchemeID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"});
  $("#ProjectID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"});
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetChosenData'
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      $('#Error').html(data);
      delete data;
      // $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      var Options = '<option value=""></option>';
      $.each(DataResp.DeptID.Data,
              function(index, value) {
                //option for Departments...
                Options += '<option value="' + value.DeptID + '">'
                        + value.DeptID + ' - ' + value.DeptName
                        + '</option>';
              });
      $('#DeptID').html(Options)
              .trigger("chosen:updated");
      $('#DeptID').data('DeptID', DataResp.DeptID);
      //option for Sectors..
      Options = '<option value=""></option>';
      $.each(DataResp.SectorID.Data,
              function(index, value) {
                Options += '<option value="' + value.SectorID + '">'
                        + value.SectorID + ' - ' + value.SectorName
                        + '</option>';
              });
      $('#SectorID').html(Options)
              .trigger("chosen:updated");
      $('#SectorID').data('SectorID', DataResp.SectorID);
      //option for Schemes...
      Options = '<option value=""></option>';
      $.each(DataResp.SchemeID.Data,
              function(index, value) {
                Options += '<option value="' + value.SchemeID + '">'
                        + value.SchemeID + ' - ' + value.SchemeName
                        + '</option>';
              });
      $('#SchemeID').html(Options)
              .trigger("chosen:updated");
      $('#SchemeID').data('SchemeID', DataResp.SchemeID);
      //option for projects...
      Options = '<option value=""></option>';
      $.each(DataResp.ProjectID.Data,
              function(index, value) {
                Options += '<option value="' + value.ProjectID + '">'
                        + value.ProjectID + ' - ' + value.ProjectName
                        + '</option>';
              });
      $('#ProjectID').html(Options)
              .trigger("chosen:updated");
      $('#ProjectID').data('ProjectID', DataResp.ProjectID);
      delete DataResp;
      $("#Msg").html('');
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
  //calling ajax for saving data.............
  $("form").on("submit", function(event) {
    event.preventDefault();
    $('#Msg').html('Saving Please Wait...');
    /*
     if ($('#TxtAction').val() == "Create Sector") {
     //dialog show
     }
     else
     {

     }*/
    $.ajax({
      type: 'POST',
      url: 'AjaxSaveData.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      //data: $("#frmProject").serialize(),
      data: {
        'FormToken': $('#FormToken').val(),
        'AjaxToken': $('#AjaxToken').val(),
        'CmdSubmit': $("#TxtAction").val(),
        'SectorName': $("#SectorName").val(),
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#Ajax").val(DataResp.FormToken);
        $("#Msg").html(DataResp.Msg);
        $('#frmProject').trigger("reset");
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

});
