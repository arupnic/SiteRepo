/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function(b)
{
  var c = {allowFloat: false, allowNegative: false};
  b.fn.numericInput = function(e)
  {
    var f = b.extend({}, c, e);
    var d = f.allowFloat;
    var g = f.allowNegative;
    this.keypress(function(j)
    {
      var i = j.which;
      var h = b(this).val();
      if (i > 0 && (i < 48 || i > 57))
      {
        if (d == true && i == 46) {
          if (g == true && a(this) == 0 && h.charAt(0) == "-")
          {
            return false
          }
          if (h.match(/[.]/)) {
            return false
          }
        } else {
          if (g == true && i == 45)
          {
            if (h.charAt(0) == "-") {
              return false
            }
            if (a(this) != 0) {
              return false
            }
          } else
          {
            if (i == 8) {
              return true
            } else {
              return false
            }
          }
        }
      } else {
        if (i > 0 && (i >= 48 && i <= 57))
        {
          if (g == true && h.charAt(0) == "-" && a(this) == 0) {
            return false
          }
        }
      }
    });
    return this
  };
  function a(d)
  {
    if (d.selectionStart) {
      return d.selectionStart
    }
    else {
      if (document.selection) {
        d.focus();
        var f = document.selection.createRange();
        if (f == null) {
          return 0
        }
        var e = d.createTextRange(), g = e.duplicate();
        e.moveToBookmark(f.getBookmark());
        g.setEndPoint("EndToStart", e);
        return g.text.length
      }
    }
    return 0
  }
}(jQuery));

