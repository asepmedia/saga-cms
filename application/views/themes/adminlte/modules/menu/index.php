<!-- Main content -->
<section class="content">
<?php
$css = array(
  'plugins/sortable/css/nestable.css',
  'plugins/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css',
  'plugins/sweet-alert/sweetalert2.min.css'
);
$js = array(
  'plugins/sortable/js/jquery.nestable.js',
  'plugins/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js',
  'plugins/sweet-alert/sweetalert2.min.js'
);
echo $this->saga->theme->render_css($css);
echo $this->saga->theme->render_js($js);
?>
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-4">
      <!-- Box -->
      <div class="box box-warning collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Options</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
        <menu id="nestable-menu">
          <h5>Menu Action</h5>
          <button type="button" class="btn btn-default btn-sm btn-block" data-action="expand-all"><i class="fas fa-toggle-on"></i> Expand All</button>
          <button type="button" class="btn btn-default btn-sm btn-block" data-action="collapse-all"><i class="fas fa-toggle-off"></i> Collapse All</button>
        </menu>
          <!-- <form action="">
            <div class="form-group">
              <label for="">Menu Title</label>
              <input type="text" id="" class="form-control" name="name">
            </div>
            <div class="form-group">
              <label for="">Menu Link</label>
              <input type="url" n="" class="form-control" name="link">
            </div>
            <div class="form-group">
              <label for="">Menu Icon</label>
              <input type="text" id="" class="form-control" name="icon">
            </div>
            <div class="form-group">
              <label for="">Menu Location</label>
              <select class="form-control" name="location" style="width: 100%;">
                  <option selected="selected" value="admin">Admin</option>
                  <option value="admin">Frontend</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Menu Type</label>
              <select class="form-control" name="type" style="width: 100%;">
                  <option selected="selected" value="menu">Label</option>
                  <option value="menu">Menu</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Parent</label>
              <select class="form-control select2" style="width: 100%;">
                  <option selected="selected">Widget</option>
                  <option>Other Menu</option>
                  <option>Plugin</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Role</label>
              <select class="form-control select2" multiple="multiple" style="width: 100%;" data-placeholder="Select a Role">
                  <option>Superuser</option>
                  <option>User</option>
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-sm pull-right">Save</button>
            </div>
          </form> -->
        <!-- /.box-body -->
        <!-- Loading (remove the following to stop the loading)-->
        <div class="overlay hidden">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <!-- end loading -->
      </div>
      </div>
      <!-- /.box -->

    </div>
    <div class="col-md-8">
      <!-- Content -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Menu Management</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <!-- <menu id="nestable-menu">
          <button type="button" class="btn btn-default btn-sm" data-action="expand-all">Expand All</button>
          <button type="button" class="btn btn-default btn-sm" data-action="collapse-all">Collapse All</button>
        </menu> -->
          <div class="cf nestable-lissts">
              <div class="dd" id="nestable">
                <!-- <menu id="nestable-menu">
                  <button type="button" class="btn btn-default btn-sm" data-action="expand-all">Expand All</button>
                  <button type="button" class="btn btn-default btn-sm" data-action="collapse-all">Collapse All</button>
                </menu> -->
                  <button onclick="addmenu(0, 'menu', 'admin')" class="btn btn-sm btn-danger pull-left"><i class="fa fa-plus"></i> Add Label</button>
                  <button id="save-menus" class="btn btn-sm btn-primary pull-right">
                  <span id="save_menu_text">
                  <i class="fa fa-send"></i> Save
                  </span>
                  <div class="hidden" id="save_menu_loading">
                    <span>
                    <i class="fas fa-spinner fa-spin"></i> Loading...
                    </span>
                  </div>
                  </button>
                  <div class="clearfix"></div>
                  <hr/>
                  <ol class="dd-list" id="admin-menu-render">
                  </ol>
              </div>
          </div>
            <!-- End -->
        </div>
      </div>
      <!-- End Content -->
    </div>
  </div>
  <!-- End Box --> 
</section>
<!-- Modal -->
<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Module</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div id="module-list"></div>
          </div>
          <!-- Content -->
          <div class="col-md-8">
            <div class="alert alert-info">
              <div id="module-name"></div>
            </div>
            <div class="cf nestable-lissts">
              <div class="dd" id="nestable2">
                    <ol class="dd-list" id="module-menu-render">
                    </ol>
              </div>
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

<div id="addMenu" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="module_menu_heading"></h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="modal_menu_id" value="">
          <input type="hidden" id="modal_menu_action" value="">
          <div class="form-group">
            <label for="">Menu Title</label>
            <input type="text" class="form-control" name="name" id="modal_menu_title" value="sds">
          </div>
          <div class="form-group">
            <label for="">Menu Link</label>
            <input type="url" class="form-control" name="link" id="modal_menu_link" value="sds">
          </div>
          <div class="form-group">
            <label for="">Menu Icon</label>
            <div id="icon-wrapper-search"></div>
          </div>
          <input type="hidden" id="modal_menu_location">
          <input type="hidden" id="modal_menu_type">
          <input type="hidden" id="modal_menu_parent">
          <input type="hidden" id="modal_menu_position">
          <input type="hidden" id="modal_menu_icon">
          <div class="form-group">
            <label for="">Display for</label>
            <select class="form-control select2" id="modal_menu_role" multiple="multiple" style="width: 100%;" data-placeholder="Select a Role">
                <option value="1">Superuser</option>
                <option value="2">Admin</option>
                <option value="3">Mod</option>
                <option value="4">Hide</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button id="modal_save_menu" class="btn btn-primary btn-sm pull-right" onclick="save_add_menu()">
        <div class="overlay">
          <span id="modal_loading_save">Save Menu</span>
        </div>
        </button>
      </div>
    </div>

  </div>
</div>
<!-- End Main Section -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
<script>
var menu_module_list = [];
function swalert(type, msg)
{
  const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
  });

  toast({
    type: type,
    title: msg
  })  
}
function add_module(name = '', modules = 0)
{
  $('#myModal').modal('show');
  $('#module-name').html(name)
  get_module_method(modules);
}
function save_add_menu()
{
  $('#modal_save_menu').prop('disabled', true);
  $('#modal_loading_save').html(`
    <i class="fa fa-refresh fa-spin"></i>
    <span>Loading...</span>
  `);
  const data = {
    name: $('#modal_menu_title').val(),
    icon: $('#modal_menu_icon').val(),
    link: $('#modal_menu_link').val(),
    parent: $('#modal_menu_parent').val(),
    location: $('#modal_menu_location').val(),
    type: $('#modal_menu_type').val(),
    position: $('#modal_menu_position').val(),
    role: $('#modal_menu_role').val(),
    id: $('#modal_menu_id').val()
  }

  console.log(data)

  $.ajax({
    url: $('#modal_menu_action').val(),
    type: 'POST',
    data: data,
    success: function(res) {
      get_menu();
      $('#addMenu').modal('hide');
      $('#modal_save_menu').prop('disabled', false);
      $('#modal_loading_save').html(`
        <span>Add Menu</span>
      `);
      swalert('success', res.message)
    },
    error: function(res) {
      console.log(res)
      $('#modal_save_menu').prop('disabled', false);
      $('#modal_loading_save').html(`
        <span>Add Menu</span>
      `);
    }
  })
}

function get_module_method(modules)
{
  $.ajax({
    url: 'http://localhost/project/saga/modules/method?module='+modules+'&type=modules',
    type: 'GET',
    success: function(res) {
      var data = JSON.parse(res);
      var str = '';
      if(data.length > 0) {
        data.map(function(v) {
        str += `
          <div>
            <h5 class="pull-left">${v}</h5>
            <button onclick="add_module_to_list('${v}')" class="btn btn-default pull-right btn-sm"> <i class="fa fa-plus"></i></button>
            <div class="clearfix"></div>
          </div>
        `;
        });
        $('#module-list').html(str);
      } else {
        $('#module-list').html('Module tidak memiliki halaman.');
      }
    }
  })  
}

function generate_module_list(data)
{
  data.map(function(v, i) {
    $('#module-menu-render').append(`
    <li class="dd-item dd3-item" data-id="13">
        <div class="dd-handle dd3-handle"></div><div class="dd3-content" onclick="delete_module_from_list(${i})">${v.name}</div>
    </li> 
  `);
  })  
}
function add_module_to_list(name = '') {
  menu_module_list = [...menu_module_list, {
    name: name,
    link: 'http://module.m',
    icon: 'fa fa-circle-o',
  }];
  generate_module_list(menu_module_list);
}

function delete_module_from_list(i) {
  menu_module_list.splice(i, 1);
  console.log(menu_module_list)
  generate_module_list(menu_module_list);
}

function addmenu(parent, type, location) {
  $('#modal_menu_location').val(location);
  $('#modal_menu_parent').val(parent);
  $('#modal_menu_type').val(type);
  $('#modal_menu_title').val('');
  $('#modal_menu_link').val('');
  $('#modal_menu_action').val(MODULE_URL + 'menu/create');
  $('#module_menu_heading').html('Add Menu');
  $('#addMenu').modal('show');
}
function editdata(id) {
  $('#modal_menu_action').val(MODULE_URL + 'menu/update?id=' + id);
  $('#module_menu_heading').html('Edit Menu');
  $.ajax({
    url: MODULE_URL + 'menu/detail?id=' + id,
    type: 'GET',
    success: function(res) {
      $('#modal_menu_id').val(res.data.menu.id);
      $('#modal_menu_title').val(res.data.menu.name);
      $('#modal_menu_link').val(res.data.menu.link);
      $('#modal_menu_icon').val(res.data.menu.icon);
      $('#modal_menu_location').val(res.data.menu.location);
      $('#modal_menu_parent').val(res.data.menu.parent);
      $('#modal_menu_type').val(res.data.menu.type);
      $('#modal_menu_position').val(res.data.menu.position);
      var role = [];
      $.each(res.data.role, function(k, v) {     
        role = [...role,v.role_id];
      })
      $('#modal_menu_role').val(role).select2();
      $('#addMenu').modal('show');
    }
  })
}

function get_menu()
{
  $.ajax({
    url: MODULE_URL + 'menu/menus',
    type: 'GET',
    success: function(res) {
      var data = JSON.parse(res);
      if(data.length > 0) {
        $('#admin-menu-render').html(`
         ${recursive_menu(data)}
        `);
      } else {
        $('#admin-menu-render').html('')
      }
    }
  })
}

function delete_menu(id) {
  $('#loading' + id).removeClass('hidden');
  $.ajax({
    url: MODULE_URL + 'menu/delete?id=' + id,
    type: 'POST',
    complete: function() {
      get_menu();
      swalert('success', 'Success delete menu')
    }
  })  
}
function recursive_menu(data, parent = 0) {
  var str = '';
  data.map(function(v, i) {
    str += `
      <li class="dd-item dd3-item" data-id="${v.id}" data-name="${v.name}">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content"><span><i class="${v.icon}"></i> ${v.name}</span>
        <div class="overlay hidden" id="loading${v.id}">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
        <span class="pull-right">
        <span style="cursor:pointer" class="text-right text-primary" onclick="addmenu(${v.id}, 'menu', '${v.location}')"><i class="fa fa-plus"></i> </span> &nbsp;
        <span style="cursor:pointer" class="text-right text-warning" onclick="editdata('${v.id}')"><i class="fa fa-edit"></i> </span> &nbsp;
    `;
      if(v.system != 1) {
        str += `
        <span style="cursor:pointer" class="text-right text-danger" onclick="delete_menu('${v.id}')"><i class="fa fa-trash"></i> </span></span>
        `;
      }
    str += '</div>';
      if(v.child.length > 0) {
        str += '<ol class="dd-list">';
        str += recursive_menu(v.child);
        str += '</ol>';
      }
    str += '</li>';
  });

  return str;
}

function recursive(data)
{
var jsonData = [];
data.map(function(v, i) {
  jsonData = [...jsonData, {
    id: v.id,
    name: v.name,
    position: i + 1,
    location: v.location,
    children: v.children != undefined ? recursive(v.children) : [],
  }];
});

return jsonData;
}

function flat(data) {
var r = [];
data.map(function(v, i) {
  r = [...r,['s']];
  if(v.children.length > 0) {
    flat(v.children)
  }
});
return r;
}

$(document).ready(function()
{
  $('#icon-wrapper-search').iconpicker({
      arrowClass: 'btn-danger',
      arrowPrevIconClass: 'fa fa-angle-left',
      arrowNextIconClass: 'fa fa-angle-right',
      cols: 10,
      footer: true,
      header: true,
      icon: 'fa fa-bomb',
      iconset: 'fontawesome5',
      labelHeader: '{0} of {1} pages',
      labelFooter: '{0} - {1} of {2} icons',
      placement: 'bottom',
      rows: 5,
      search: true,
      searchText: 'Search',
      selectedClass: 'btn-success',
      unselectedClass: ''
  });
  $('#icon-wrapper-search').on('change', function(e) {
      $('#modal_menu_icon').val(e.icon);
  });
  // $('.icp-auto').iconpicker({
  //   title: 'With custom options',
  //   selectedCustomClass: 'label label-success',
  //   icons: [
  //     {
  //       title: "fa fa-github",
  //       searchTerms: ['repository', 'code']
  //     },
  //     {
  //       title: "fa fa-circle-o",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-gear",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-dashboard",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-file",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-image",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-book",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-bookmark",
  //       searchTerms: ['circle', 'null']
  //     },
  //     {
  //       title: "fa fa-map-marker",
  //       searchTerms: ['circle', 'null']
  //     },
  //   ]
  // });
  get_menu();
    var serialize_menus;
    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
          serialize_menus = window.JSON.stringify(list.nestable('serialize'));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    $('#save-menus').on('click', function() {
      _addClasses(_getSelector('#save_menu_text'), 'hidden')
      _removeClasses(_getSelector('#save_menu_loading'), 'hidden')
			$.ajax({
        url: MODULE_URL + 'menu/save_position',
        type: 'POST',
        data: {
          menus: serialize_menus
        },
        success: function(res) {
          swalert('success', res.message)
        },
        error: function(err) {
          swalert('error', res.message)
        },
        complete: function(){
          _addClasses(_getSelector('#save_menu_loading'), 'hidden')
          _removeClasses(_getSelector('#save_menu_text'), 'hidden')
        }
      })
		});
    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable2').nestable();

});

/**
 * 
 * @param {*} dom 
 */
function _removeClasses(dom, type) {
  for (var i = 0; i < dom.length; i++) {
    dom[i].classList.remove(type)
  }
}

/**
 * 
 * @param {*} dom 
 */
function _addClasses(dom, type) {
  for (var i = 0; i < dom.length; i++) {
    dom[i].classList.add(type)
  }
}

function _getSelector(name) {
  return document.querySelectorAll(name);
}
</script>