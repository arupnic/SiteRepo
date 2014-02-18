/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  $('input[type="submit"]').button();
  $('input[type="button"]').button();
  $('input[type="delete"]').button();
  $('input[type="reset"]').button();

  $("#SectorID").chosen({width: "250px",
    no_results_text: "Oops, nothing found!"});
  $('#StartDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
  $('#EndDate').datepicker({
    dateFormat: 'dd-mm-yy',
    showOn: "both",
    buttonImage: "images/calendar.gif",
    buttonImageOnly: true
  });
////** fetch setor dara.*****************
//  $.ajax({
//    type: 'POST',
//    url: 'AjaxData.php',
//    dataType: 'html',
//    xhrFields: {
//      withCredentials: true
//    },
//    data: {
//      'AjaxToken': $('#AjaxToken').val(),
//      'CallAPI': 'GetChosenData'
//    }
//  }).done(function(data) {
//    try {
//      var DataResp = $.parseJSON(data);
//      $('#Error').html(data);
//      delete data;
//      // $('#AjaxToken').val(DataResp.AjaxToken);
//      $('#Msg').html(DataResp.Msg);
//      $('#ED').html(DataResp.RT);
//      var Options = '<option value=""></option>';
//
//      //option for Sectors..
//      Options = '<option value=""></option>';
//      $.each(DataResp.SectorID.Data,
//              function(index, value) {
//                Options += '<option value="' + value.SectorID + '">'
//                        + value.SectorID + ' - ' + value.SectorName
//                        + '</option>';
//              });
//      $('#SectorID').html(Options)
//              .trigger("chosen:updated");
//      $('#SectorID').data('SectorID', DataResp.SectorID);
//      $("#example_wrapper").hide();
//
//      delete DataResp;
//      $("#Msg").html('');
//    }
//    catch (e) {
//      $('#Msg').html('Server Error:' + e);
//      $('#Error').html(data);
//    }
//  }).fail(function(msg) {
//    $('#Msg').html(msg);
//  });
//********************************
  //***********make data table..
  var dataSet = new Array();
  $('#example').dataTable({
    "data": dataSet,
    "columns": [
      {"data": "SchemeID"},
      {"data": "SchemeName"},
      {"data": "ReportDate"},
      {"data": "PhysicalProgress"},
      {"data": "FinancialProgress"},
      {"data": "Remarks"},
    ],
    "pagingType": "full_numbers",
    "jQueryUI": true,
    "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
    "scrollY": 600/*,
     "paging": false,
     "jQueryUI": true,*/
  });
  $('#CreateReport').click(function(event) {
    event.preventDefault();
    $('#Msg').html('Please Wait...');
    $.ajax({
      type: 'POST',
      url: 'AjaxData.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'AjaxToken': $('#AjaxToken').val(),
        'CallAPI': 'GetReportTable',
      }
    })
            .done(function(data) {
              try {
                // $('#ReportID').data('SectorID', DataResp.SectorID);
                var DataResp = $.parseJSON(data);
                delete data;
                $('#AjaxToken').val(DataResp.AjaxToken);
                $('#Msg').html(DataResp.Msg);
                $('#ED').html(DataResp.RT);
                $("#Msg").show();
                $("#example_wrapper").show();
                var dataTableReport = $('#example').dataTable();
                oSettings = dataTableReport.fnSettings();
                dataTableReport.fnClearTable(this);
                for (var i = 0; i < DataResp.Data.length; i++) {
                  dataTableReport.oApi._fnAddData(oSettings, DataResp.Data[i]);
                }
                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                dataTableReport.fnDraw();

                delete DataResp;
              }
              catch (e) {
                $('#Msg').html('Server Error:' + e);
                $('#Error').html(data);
              }
            })
            .fail(function(msg) {
              $('#Msg').html(msg);
            });
  });

});
