/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
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

  $('#CmdSaveUpdate').on("click", function() {
    $("#TxtAction").val($(this).val());
  });

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
      data: $("#frmDepartment").serialize()
    }).done(function(data) {
      try {
        var DataResp = $.parseJSON(data);
        delete data;
        $("#FormToken").val(DataResp.FormToken);
        $("#Ajax").val(DataResp.FormToken);
        $("#Msg").html(DataResp.Msg);
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
