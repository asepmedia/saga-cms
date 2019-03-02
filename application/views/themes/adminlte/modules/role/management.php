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
  <div class="col-md-4 col-lg-4">
    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Add Role</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <form id="icon-form">
          <div class="form-group">
            <label for="">Name</label>
              <input type="text" name="role_name" id="role_name" autocomplete="off" required="" class="form-control input-sm">
          </div>
          <div class="form-group">
            <label for="">Description</label>
              <input type="text" name="role_description" id="role_description" autocomplete="off" required="" class="form-control input-sm">
          </div>
          <div class="form-group">
            <button class="btn btn-sm btn-primary pull-right" type="submit"> <i class="fas fa-save"></i> Save</button>
          </div>
        </form>
      </div>
      <div class="overlay hidden" id="loading-overlay">
          <i class="fas fa-refresh fa-spin"></i>
        </div>
    </div>
  </div>

  <div class="col-md-8 col-lg-8">
    <!-- Box -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">List Roles</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
      <table id="icon-list" class="table  table-striped">
        <thead>
          <tr>
            <th>Name </th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="role-list">
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

/**
 * Role list function
 *
 */
function role_list() {
  var roles = '';
  $.get(MODULE_URL + 'role/role_list', function(res) {
    var data = res.results;
    for(var i in data) {
      roles += `
        <tr>
          <td width="35%">${data[i].role_name}</td>
          <td width="35%">${data[i].role_description}</td>
          <td width="30%" class="text-right">
            <button class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i></button>
            <button class="btn btn-sm btn-info"> <i class="far fa-eye"></i></button>
            <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
          </td>
        </tr>      
      `;
    }
    $('#role-list').html(roles);
    $('#icon-list').DataTable()
  });
}

$(function(){
  role_list();
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
    // $.ajax({
    //   url: MODULE_URL + 'icon/create',
    //   type: 'POST',
    //   data: data,
    //   success: function(res) {
    //     $('#icon-form').find("input[type=text], textarea").val("");
    //     swalert('success', res.message);
    //     _addClasses(loading, 'hidden');
    //   }
    // });
  })
});
</script>