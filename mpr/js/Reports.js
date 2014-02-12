/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
google.load('visualization', '1', {packages: ['corechart']});
//google.setOnLoadCallback(drawVisualization);
$(function() {
  $('#CmdRefresh').click(function() {
    drawVisualization();
  });
  $("#DeptID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"});
  $("#SectorID").chosen({width: "250px",
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
      'CallAPI': 'GetComboData'
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
      $('#ProjectID').data('Reports', DataResp.Reports);

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
  $("#SchemeID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"})
          .change(function() {
            var SchemeID = Number($(this).val());
            var Reports = $('#ProjectID').data('Reports');
            $.each(Reports.Data,
                    function(index, value) {
                      if (value.SchemeID === SchemeID)

                      {
                        Options += '<option value="' + value.ProjectID + '">'
                                + value.ProjectID + ' - ' + value.ProjectName
                                + '</option>';
                      }
                    });
          });
  /** * //
   $("#BranchName").chosen({width: "418px",
   no_results_text: "Oops, nothing found!"
   }).change(function() {
   var BranchSL = Number($(this).val());
   var IFSC = $('#BranchName').data('BranchName');
   $.each(IFSC,
   function(index, value) {
   if (value.BranchSL === BranchSL) {
   $("#IFSC").val(value.IFSC);
   return false;
   }
   });
   });
   */
});

/**
 *
 * @returns {undefined}
 */
function drawVisualization() {
  // Create and populate the data table.
  $.ajax({
    type: 'POST',
    url: 'AjaxMpr.php',
    dataType: 'html',
    xhrFields: {
      withCredentials: true
    },
    data: {
      'FormToken': $('#FormToken').val(),
      'CmdSubmit': 'GetREPORTData',
      'ProjectID': $('#ProjectID').val()
    }
  }).done(function(data) {
    try {
      var DataResp = $.parseJSON(data);
      delete data;
      $('#AjaxToken').val(DataResp.AjaxToken);
      $('#Msg').html(DataResp.Msg);
      $('#ED').html(DataResp.RT);
      var dataChart = new google.visualization.DataTable();
      dataChart.addColumn('string', 'Month');
      dataChart.addColumn('number', 'Physical Progress');
      dataChart.addColumn('number', 'Financial Progress');
      dataChart.addRows(3);
      dataChart.setValue(0, 0, 'January');
      dataChart.setValue(0, 1, 16);
      dataChart.setValue(0, 2, 93);
      dataChart.setValue(1, 0, 'February');
      dataChart.setValue(1, 1, 13);
      dataChart.setValue(1, 2, 112);
      dataChart.setValue(2, 0, 'March');
      dataChart.setValue(2, 1, 15);
      dataChart.setValue(2, 2, 116);

      // Create and draw the visualization.
      var ac = new google.visualization.ComboChart(document.getElementById('visualization'));
      ac.draw(dataChart, {
        title: 'Monthly Progress Report',
        width: 600,
        height: 400,
        vAxis: {title: "Progress"},
        hAxis: {title: "Month"},
        seriesType: "bars",
        series: {5: {type: "line"}}
      });
      delete DataResp;
      $("#Msg").hide();
    }
    catch (e) {
      $('#Msg').html('Server Error:' + e);
      $('#Error').html(data);
    }
  }).fail(function(msg) {
    $('#Msg').html(msg);
  });
}
