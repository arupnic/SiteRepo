/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();
  $('#ReportDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $("#PhysicalSlider").slider({
    range: "min",
    value: 0,
    min: 0,
    max: 100,
    slide: function(event, ui) {
      $("#lblPhysicalProgress").html("Physical Progress: " + ui.value + "%");
      $("#PhysicalProgress").val(ui.value);
    }
  });
  $("#FinancialSlider").slider({
    range: "min",
    value: 0,
    min: 0,
    max: 100,
    slide: function(event, ui) {
      $("#lblFinancialProgress").html("Financial Progress: " + ui.value + "%");
      $("#FinancialProgress").val(ui.value);
    }
  });
//  $('#CmdDel').on("click", function() {
//    $("#TxtAction").val($(this).val());
//  });
  $('#Reload').click(function() {
    location.reload()
  });
  $('#CmdSaveUpdate').on("click", function() {
    $("#TxtAction").val($(this).val());
  });
//calling Ajax for fetching the project data...
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'AjaxToken': $('#AjaxToken').val(),
      'CallAPI': 'GetProjectData'
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
      $.each(DataResp.Projects.Data,
              function(index, value) {
                //option for Projects...
                Options += '<option value="' + value.ProjectID + '">'
                        + value.ProjectID + ' - ' + value.ProjectName
                        + '</option>';
              });
      $('#ProjectID').html(Options)
              .trigger("chosen:updated");
      $('#ProjectID').data('Projects', DataResp.Projects);
      $('#ProgressID').data('Progress', DataResp.Progress);
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
  // set the slider min value depand on the project name.......
  $("#ProjectID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var ProjectID = Number($(this).val());
    var Progress = $('#ProgressID').data('Progress');
    $.each(Progress.Data,
            function(index, value) {
              if (value.ProjectID === ProjectID)
              {
                $('#PhysicalSlider').slider("value", value.PhysicalProgress);
                $('#FinancialSlider').slider("value", value.FinancialProgress);
                $("#lblPhysicalProgress").html("Physical Progress: " +
                        value.PhysicalProgress + "%");
                $("#lblFinancialProgress").html("Financial Progress: " +
                        value.FinancialProgress + "%");
                $('#LastReportDate').val(value.ReportDate);
                $('#OldRemarks').val(value.Remarks);
                return false;
              }
            });
  });

  //****************************************
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
        'CmdSubmit': 'Save Progress',
        'ProjectID': $("#ProjectID").val(),
        'ReportDate': $("#ReportDate").val(),
        'PhysicalProgress': $("#PhysicalProgress").val(),
        'FinancialProgress': $("#FinancialProgress").val(),
        'Remarks': $("#Remarks").val()
      }
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#AjaxToken").val(DataResp.AjaxToken);
        $("#Msg").html(DataResp.Msg);
        if (DataResp.CheckVal === null)
        {
          $('#frmProgress').trigger("reset");
          $("#ProjectID").trigger("chosen:updated");
          $('#PhysicalSlider').slider("value", 0);
          $('#FinancialSlider').slider("value", 0);
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
});
