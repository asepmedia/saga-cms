$(document).ready(function() {
  $('#widget_name').on('change', function() {
    if($(this).val() != 'Widget_system') {
      $('#widget_content').addClass('d-none');
    } else {
      $('#widget_content').removeClass('d-none');
    }
  });  
var updateOutput = function(e)
{
    var list   = e.length ? e : $(e.target),
        output = list.data('output');
    if (window.JSON) {
        var data = list.nestable('serialise');
        var jsonData = [];
        data.map(function(v, i) {
          jsonData = [...jsonData, {
            id: v.id,
            position: i + 1
          }];
        });
        output.val(window.JSON.stringify(jsonData));//, null, 2));
        var items = window.JSON.stringify(jsonData);
        var saveitem = { items: items };
        $.ajax({
          url: 'http://localhost/belajar/widget/v1/index.php/widget_plugin/update',
          type: 'POST',
          data: saveitem,
          success: function(res) {
            console.log(res);
          },
          error: function(err) {
            console.log(err);
          }
        })
    } else {
        output.val('JSON browser support required for this demo.');
    }
};
// activate Nestable for list 1
$('.widget-nestable').nestable({
    group: 1
})
.on('change', updateOutput);
// output initial serialised data
updateOutput($('#nestable').data('output', $('#nestable-output')));
});