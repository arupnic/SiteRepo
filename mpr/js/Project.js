$(function() {
  $('input[type="button"]').button();
  $('input[type="reset"]').button();
// +

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
  // Ajax call...............
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
                //option for Projects...
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
//start declaring the onclick methods.............
//for create new sector.........
  $('#CmdSaveSector').click(function() {
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
        'CmdSubmit': $("#CmdSaveSector").val(),
        'SectorName': $("#SectorName").val()
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#AjaxToken").val(DataResp.AjaxToken);
        $("#Msg").html(DataResp.Msg);
        $('#frmSector').trigger("reset");
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
//for create new Scheme.........
  $('#CmdSaveScheme').click(function() {
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
        'CmdSubmit': $("#CmdSaveScheme").val(),
        'DeptID': $("#DeptID").val(),
        'SectorID': $("#SectorID").val(),
        'SchemeName': $("#SchemeName").val()
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#AjaxToken").val(DataResp.AjaxToken);
        $("#Msg").html(DataResp.Msg);
        $('#frmScheme').trigger("reset");
        $("#DeptID").trigger("chosen:updated");
        $("#SectorID").trigger("chosen:updated");

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
//for create new Project.........
  $('#CmdSaveProject').click(function() {
    $.ajax({
      type: 'POST',
      url: 'AjaxSaveData.php',
      dataType: 'html',
      xhrFields: {withCredentials: true
      },
      //data: $("#frmProject").serialize(),
      data: {'FormToken': $('#FormToken').val(),
        'AjaxToken': $('#AjaxToken').val(),
        'CmdSubmit': $("#CmdSaveProject").val(),
        'SchemeID': $("#SchemeID").val(),
        'ProjectName': $("#ProjectName").val(),
        'ProjectCost': $("#ProjectCost").val(),
        'AlotmentAmount': $("#AlotmentAmount").val(),
        'StartDate': $("#StartDate").val(),
        'AlotmentDate': $("#AlotmentDate").val(),
        'TenderDate': $("#TenderDate").val(),
        'WorkOrderDate': $("#WorkOrderDate").val()
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#AjaxToken").val(DataResp.AjaxToken);
        $("#Msg").html(DataResp.Msg);
        $('#frmProject').trigger("reset");
        $("#SchemeID").trigger("chosen:updated");
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
//  $("form").on("submit", function(event) {
//    event.preventDefault();
//    $('#Msg').html('Saving Please Wait...');
//  });
});
