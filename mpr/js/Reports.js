/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
google.load('visualization', '1', {packages: ['corechart']});
//xgoogle.setOnLoadCallback(drawVisualization);
$(function() {
  $('input[type="button"]').button();
  $('#CmdRefresh').click(function() {
    drawVisualization();
  });
//  $("#DeptID").chosen({width: "200px",
//    no_results_text: "Oops, nothing found!"});
//  $("#SectorID").chosen({width: "200px",
//    no_results_text: "Oops, nothing found!"});

  $("#ProjectID").chosen({width: "200px",
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
                        + '</option>';
              });
      $('#SchemeID').html(Options)
              .trigger("chosen:updated");
      $('#SchemeID').data('SchemeID', DataResp.SchemeID);

      //
      Options = '<option value=""></option>';
      $.each(DataResp.ProjectID.Data,
              function(index, value) {
                Options += '<option value="' + value.ProjectID + '">'
                        + '</option>';
              });
      $('#ProjectID').html(Options)
              .trigger("chosen:updated");
      $('#ProjectID').data('ProjectID', DataResp.ProjectID);
      //filter
      $("#SectorID,#DeptID").chosen({width: "200px",
        no_results_text: "Oops, nothing found!"})
              .change(function() {
                var Options = '<option value=""></option>';
                var SchemeID = $('#SchemeID').data('SchemeID');
                var SectorID = Number($(this).val());
                var DeptID = Number($(this).val());
                $.each(SchemeID.Data,
                        function(index, value) {
                          if ((value.SectorID === SectorID) && (value.DeptID === DeptID))
                          {
                            Options += '<option value="' + value.SchemeID + '">'
                                    + value.SchemeID + ' - ' + value.SchemeName
                                    + '</option>';
                          }
                        });
                $('#SchemeID').html(Options)
                        .trigger("chosen:updated");
              });
      //filter
      $("#SchemeID").chosen({width: "200px",
        no_results_text: "Oops, nothing found!"})
              .change(function() {
                var Options = '<option value=""></option>';
                var ProjectID = $('#ProjectID').data('ProjectID');
                var SchemeID = Number($(this).val());
                $.each(ProjectID.Data,
                        function(index, value) {
                          if (value.SchemeID === SchemeID) {
                            Options += '<option value="' + value.ProjectID + '">'
                                    + value.ProjectID + ' - ' + value.ProjectName
                                    + '</option>';
                          }
                        });
                $('#ProjectID').html(Options)
                        .trigger("chosen:updated");
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
});


/**
 *
 * @returns {undefined}
 */
function drawVisualization() {
  // Create and populate the data table.
  $.ajax({
    type: 'POST',
    url: 'AjaxData.php',
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

//      var Options = '<option value=""></option>';
//      $.each(DataResp.ProjectID,
//              function(index, value) {
//                Options += '<option value="' + value.SectorID + '">'
//                        + value.PhysicalProgress + value.FinancialProgress
//                        + '</option>';
//                for (var i = 0; i <= DataResp.Data.length; i++)
//                {
//                  for (var j = 0; j <= 3; j++)
//                  {
//                    dataChart.setValue(i, j, PhysicalProgress.val());
//                  }
//                }
//              });
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
