/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  var OldPhysicalProgress;
  var OldFinancialProgress;
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
    $('#frmProgress').trigger("reset");
    $("#SchemeID").trigger("chosen:updated");
    $('#PhysicalSlider').slider("value", 0);
    $('#FinancialSlider').slider("value", 0);
    $("#lblPhysicalProgress").html("Physical Progress:");
    $("#lblFinancialProgress").html("Physical Progress: ");
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
      $.each(DataResp.Schemes.Data,
              function(index, value) {
                //option for Schemes...
                Options += '<option value="' + value.SchemeID + '">'
                        + value.SchemeID + ' - ' + value.SchemeName
                        + '</option>';
              });
      $('#SchemeID').html(Options)
              .trigger("chosen:updated");
      $('#SchemeID').data('Schemes', DataResp.Schemes);
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
  // set the slider min value depand on the Scheme name.......
  $("#SchemeID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"
  }).change(function() {
    var SchemeID = Number($(this).val());
    var Progress = $('#ProgressID').data('Progress');
    $.each(Progress.Data,
            function(index, value) {
              if (value.SchemeID === SchemeID)
              {
                $('#PhysicalSlider').slider("value", value.PhysicalProgress);
                $('#FinancialSlider').slider("value", value.FinancialProgress);
                $("#lblPhysicalProgress").html("Physical Progress: " +
                        value.PhysicalProgress + "%");
                $("#lblFinancialProgress").html("Financial Progress: " +
                        value.FinancialProgress + "%");
                $('#LastReportDate').val(value.ReportDate);
                $('#OldRemarks').val(value.Remarks);
                $("#FinancialProgress").val(value.FinancialProgress);
                $("#PhysicalProgress").val(value.PhysicalProgress);
                OldPhysicalProgress = (value.PhysicalProgress);
                OldFinancialProgress = (value.FinancialProgress);
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
        'SchemeID': $("#SchemeID").val(),
        'ReportDate': $("#ReportDate").val(),
        'PhysicalProgress': $("#PhysicalProgress").val(),
        'FinancialProgress': $("#FinancialProgress").val(),
        'Remarks': $("#Remarks").val(),
        'OldPhysicalProgress': OldPhysicalProgress,
        'OldFinancialProgress': OldFinancialProgress
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
          $("#SchemeID").trigger("chosen:updated");
          $('#PhysicalSlider').slider("value", 0);
          $('#FinancialSlider').slider("value", 0);
          $("#lblPhysicalProgress").html("Physical Progress:");
          $("#lblFinancialProgress").html("Physical Progress: ");
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
