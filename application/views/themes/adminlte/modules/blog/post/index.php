<section class="content">
<?php
$css = array(
  'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
  'plugins/sweet-alert/sweetalert2.min.css'
);
$js = array(
  'bower_components/datatables.net/js/jquery.dataTables.min.js',
  'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
  'plugins/sweet-alert/sweetalert2.min.js',
  'js/helper.js'
);
echo $this->saga->theme->render_css($css);
echo $this->saga->theme->render_js($js);
?>
<!-- Small boxes (Stat box) -->
<div class="row">

  <div class="col-md-12">
    <!-- Box -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Post Lists</h3>
        <div class="box-tools pull-right">
          <a href="" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New Post</a>
        </div>
      </div>
      <div class="box-body">
      <table id="icon-list" class="table  table-striped">
        <thead>
          <tr>
            <th>Title </th>
            <th>Author</th>
            <th>Type</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> Lorem ipsum dolor sit amet consectetur. </td>
            <td>Asep Yayat</td>
            <td>Post</td>
            <td>Publish</td>
            <td class="text-right">
              <button class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i></button>
              <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
  </div>

</div>
</section>

<script>
var loading = _getSelector('#loading-overlay');
let icon = $('#icon_name'),
    keyword = $('#icon_keyword');
$(function(){
  $('#icon-list').DataTable()

  icon.on('change', function() {
    $('#preview-icon').html('<i class="fa '+$(this).val()+'"></i>')
  });

  $('#icon-form').on('submit', function(e) {
    _removeClasses(loading, 'hidden');
    e.preventDefault();

    const data = {
      name: icon.val(),
      keyword: keyword.val()
    }
    $.ajax({
      url: MODULE_URL + 'icon/create',
      type: 'POST',
      data: data,
      success: function(res) {
        $('#icon-form').find("input[type=text], textarea").val("");
        swalert('success', res.message);
        _addClasses(loading, 'hidden');
      }
    });
  })
});
</script>