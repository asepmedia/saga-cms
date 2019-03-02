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
echo Theme::render_css($css);
echo Theme::render_js($js);
?>
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-md-4">
    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Filter Module</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <form action="">
          <div class="form-group">
            <label for="">Directory</label>
            <select class="form-control filter_module" id="filter_module" style="width: 100%;" data-placeholder="Select a Role">
            <option value="/">/</option>
            </select>  
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <!-- Box -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">List Module</h3>
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
            <th></th>
          </tr>
        </thead>
        <tbody id="module-list"></tbody>
      </table>
      </div>
    </div>
  </div>

</div>
</section>
<!-- Modal -->
<div id="moduleModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <input type="hidden" id="module_type_name" val="">
    <input type="hidden" id="module_type_path" val="/">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Module</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div id="wrapper-content">
              <div class="alert alert-warning alert-sm">Available Action</div>
              <div id="local-action">
              </div>
            </div>
            <div id="wrapper-new-action">
              <form id="form-add-action">
                <!-- -->
                <div id="back-btn">
                  <a onclick="add_action()" class="btn btn-danger btn-sm"><i class="fas fa-backspace"></i> Back to List</a>
                  <hr/>
                </div>
                <div class="form-group">
                  <label for="">Action Name</label>
                  <input type="text" id="module_child_name" class="form-control input-sm" disabled>
                </div>
                <input type="hidden" id="module_name">
                <input type="hidden" id="module_type">
                <div class="form-group">
                  <label for="">Action Role</label>
                  <select class="form-control inputrole" id="modal_menu_role" multiple="multiple" style="width: 100%;" data-placeholder="Select a Role">
                    <option value="1" >Superuser</option>
                    <option value="2" >Admin</option>
                    <option value="3" >Mod</option>
                    <option value="4" >Hide</option>
                  </select>                 
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-sm btn-primary pull-right" id="btn-save-action">
                    <span id="loading_spin_action" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
                    <span id="loading_save_action"><i class="fas fa-save"></i></span>
                  </button>
                  <div class="clearfix"></div>
                </div>
              </form>
            </div>
          </div>
          <!-- Content -->
          <div class="col-md-8">
            <div class="alert alert-sm hidden" id="alert_message"></div>
            <!-- <button onclick="add_action()" class="btn btn-primary btn-sm pull-right"> <i class="fas fa-plus"></i> Add Action</button> -->
            <div class="clearfix"></div><br/>
            <div class="table-responsive">
              <table class="table table-striped" id="table-action">
                <thead>
                  <th>Action</th>
                  <th>Role</th>
                  <th class="text-right">Action</th>
                </thead>
                <tbody id="action-list">
                </tbody>
              </table>
            </div>
          </div>
          <!-- End -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>
var wrapper = _getSelector('#wrapper-content');
var contentAppend = _getSelector('#wrapper-new-action');
var match = [];

function defaultClass()
{
  _removeClasses(wrapper, 'hidden');
  _addClasses(contentAppend, 'hidden');
  return 1;
}

function toggleClass(data)
{
  data.map(function(v) {
    $('#' + v).toggleClass('hidden');
  })
}
// function addClass()
// {
//   _addClasses(wrapper, 'hidden');
//   _removeClasses(contentAppend, 'hidden');
//   return 1;
// }

function add_action() {
  $('#wrapper-content').toggleClass('hidden');
  $('#wrapper-new-action').toggleClass('hidden');
}

function addToForm(name) {
  add_action();
  $('#module_child_name').val(name);
}

function saveFormAction()
{
  $('#btn-save-action').prop('disabled', true);
  var classes = ['loading_spin_action', 'loading_save_action'];
  toggleClass(classes);

  const data = {
    module_name: $('#module_name').val(),
    module_child_name: $('#module_child_name').val(),
    role: $('#modal_menu_role').val(),
  }
  
  $.ajax({
    url: MODULE_URL + 'role/add_role_action_module',
    type: 'POST',
    data: data,
    success: function(res) {
      $('#btn-save-action').prop('disabled', false);
      toggleClass(classes);
      var type = $('#module_type').val();
      var name = $('#module_name').val();
      match = [...match, $('#module_child_name').val()];
      getActionLocalList(type, match);
      actionList(name, type)
      add_action();
    }
  });
}

function showModal(name, type = '') {
  var classes = ['loading_spin_' + name, 'loading_save_' + name];
  toggleClass(classes);
  $('#module_child_name').val('');
  $('#module_name').val(name);
  $('#module_type').val(type);
  $('#local-action').html(''); 
  $('#btn-show-modal-'+name).prop('disabled', true)
  defaultClass();
  actionList(name, type)
  setTimeout(function(){
    toggleClass(classes);
  }, 500);    
  //$('#moduleModal').modal('show');
}

function actionList(name = 'role', type)
{
  $.ajax({
    url: MODULE_URL + 'role/action_list?module=' + name,
    type: 'GET',
    success: function(res) {
      setTimeout(function(){
        // console.log(res.data)
        createRow(res.data, type)
        $('#moduleModal').modal('show')
        $('#btn-show-modal-'+name).prop('disabled', false)
      }, 500);      
    }
  });
}

function actionLocalList(name = 'Role_module')
{
  var path = $('#module_type_path').val();
  return new Promise(function(resolve, reject) {
    $.ajax({
      url: MODULE_URL + 'module/method?module=' + name + '&path=' + path,
      type: 'GET',
      success: resolve,
      error: reject
    });     
  }) 
}

function saveRole(id = 0)
{
  // $('#modal_loading_spin').toggleClass('hidden');
  // $('#modal_loading_save').toggleClass('hidden');
  var classes = ['modal_loading_spin_' + id, 'modal_btn_' + id];
  toggleClass(classes);
  const data = {
    id: id,
    role: $('#role_value' + id).val()
  }

  var icon = '<i class="fas fa-info-circle"></i> ';

  $.ajax({
    url: MODULE_URL + 'role/update_role_module',
    type: 'POST',
    data: data,
    success: function(res) {
      if(res.status == 1) {
        // $('#alert_message').removeClass('hidden').addClass('alert-success').html(icon + res.message)
        swalert('success', res.message)
      } else {
        // $('#alert_message').removeClass('hidden').addClass('alert-danger').html(icon + 'Failed updated.')
        swalert('error', 'Error update role')
      }
      toggleClass(classes);
    },
    error: function(err) {
      swalert('error', 'Error update role')
    }
  })
}

function getActionLocalList(type, match)
{
  // $('#local-action').html('');
  actionLocalList(type).then(function(res) {
    if(res.length > 0) {
      var action = res.filter( function( el ) {
        return !match.includes( el );
      } );
      var str = '';
      action.map(function(v, i) {
      str +=`
        <div>
          <h5 class="pull-left">${v}</h5>
          <button class="btn btn-sm pull-right" onclick="addToForm('${v}')"> <i class="fas fa-plus"></i></button>
          <div class="clearfix"></div>      
        </div>
      `;
    });
      $('#local-action').html(str).css({
        minHeight: '0px',
        maxHeight: '600px',
        overflowY: 'scroll'
      });
      if(res.length != 0 && action.length <= 0) {
        $('#local-action').html('All action has been used.');
      } 
    } else {
      $('#local-action').html('This module doesn\'t have action.');
    }
  });   
}
function createRow(data, type)
{
  var row = '';
  var id = [];
  var roles = [];
  data.map(function(v, i){
    id = [...id, i]
    match =  [...match, v.module_child_name]
    roles = [...roles, {
      id: v.id,
      role: v.role
    }];
    row += `
      <tr>
        <td width="20%">${v.module_child_name}</td>
        <td width="60%">
        <select class="form-control select2 select_role${i}" data-id="${v.id}" id="role_value${v.id}" multiple="multiple" style="width: 100%;" data-placeholder="Select a Role"></select>                    
        </td>
        <td width="20%">
          <!--<button title="save" class="btn btn-sm btn-warning" onclick="saveRole(${v.id})">
          <div>
            <span id="modal_loading_spin" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
            <span id="modal_loading_save"><i class="fas fa-save"></i></span>
          </div>
          </button>-->
          <button title="delete" id="modal_btn_${v.id}" class="btn btn-sm btn-danger btn-block"> <i class="fas fa-trash"></i></button>
          <button disabled title="updating" id="modal_loading_spin_${v.id}" class="hidden btn btn-sm btn-info btn-block"><span><i class="fas fa-spinner fa-spin"></i> Updating..</span></button>
        </td>
      </tr>    
    `;
    
  });

  getActionLocalList(type, match);

  var table = $('#table-action').DataTable();
  table.destroy();
  $('#action-list').html(row);
  table = $('#table-action').DataTable();
  id.map(function(v) {
    $('.select_role' + v).select2({
        ajax: {
          url: MODULE_URL + 'role/role_list',
          dataType: 'json',
          type: "GET",
          data: function (params) {
            return {
              q: params.term, // search term
              page: params.page
            };
          },       
          processResults: function (data) {
              return {
                  results: $.map(data.results, function (item) {
                      return {
                          text: item.role_name,
                          id: item.id
                      }
                  })
              };
          },
          cache: true          
        },
        minimumInputLength: 0,
    });
    var current = [];

    roles[v].role.map(function(data){
      current = [...current, data.role_id];
      $('.select_role' + v).append(new Option(data.role_name, data.role_id, true, true)).trigger('change');
    });

    $('.select_role' + v).on('change', function(){
      saveRole(roles[v].id)
    })
  });
}

function list_module(path = '/') {
  var path_name = $('#module_type_path').val();
  var type = path_name.length > 0 ? path_name.split('/').join('_') + '_' : path_name;
  $.ajax({
      url: MODULE_URL + 'module/list_module?path=' + path,
      type: 'GET',
      success: function(res) {
        str = '';
        res.map(function(v) {
          str += `
          <tr>
            <td>
              ${v.name}
            </td>
            <td class="text-right">
              <button onclick="showModal('${type}${v.name.toLowerCase()}', '${v.class_name}')" class="btn btn-sm btn-primary" id="btn-show-modal-${v.name.toLowerCase()}"> 
                <span id="loading_spin_${type}${v.name.toLowerCase()}" class="hidden"><i class="fas fa-spinner fa-spin"></i></span>
                <span id="loading_save_${type}${v.name.toLowerCase()}>"><i class="fa fa-edit"></i></span>
              </button>
            </td>
          </tr>
          `;
        });

        $('#module-list').html(str);
        $('#icon-list').DataTable()
      }
    });  
}
$(function(){
  list_module();

  $('form#form-add-action').on('submit', function(e) {
    e.preventDefault();
    saveFormAction();
  })

  var data_dir = [];
  $.ajax({
    url: MODULE_URL + 'module/dir',
    type: 'GET',
    success: function(res) {
      res.map(function(v) {
        data_dir = [...data_dir, {
          id: v,
          text: v
        }];
      })
      $('.filter_module').select2({
          data: data_dir
      }).on('change', function() {
        var module_type = $(this).val().replace('/', '');
        var type = module_type.length > 0 ? module_type + '_' : module_type;
        var module_type_name = $('#module_type_name').val(type);
        $('#module_type_path').val(module_type);
        list_module($(this).val());
      });  
    }
  });

  $('.inputrole').select2({
        ajax: {
          url: MODULE_URL + 'role/role_list',
          dataType: 'json',
          type: "GET",
          data: function (params) {
            return {
              q: params.term, // search term
              page: params.page
            };
          },       
          processResults: function (data) {
              return {
                  results: $.map(data.results, function (item) {
                      return {
                          text: item.role_name,
                          id: item.id
                      }
                  })
              };
          },
          cache: true          
        },
        minimumInputLength: 0,
    });
});
</script>