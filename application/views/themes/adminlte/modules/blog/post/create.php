<section class="content">
<?php
$css = array(
  'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
  'plugins/sweet-alert/sweetalert2.min.css',
  'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'
);
$js = array(
  'bower_components/datatables.net/js/jquery.dataTables.min.js',
  'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
  'plugins/sweet-alert/sweetalert2.min.js',
  'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
  'js/helper.js'
);
echo $this->saga->theme->render_css($css);
echo $this->saga->theme->render_js($js);
?>
<!-- Small boxes (Stat box) -->
<div class="row">

  <form id="post-form">
  <div class="col-md-8 col-lg-9">
    <!-- Box -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">New Post</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <input type="text" name="post_title" id="post_title" autocomplete="off" required="" class="form-control input-lg" placeholder="Post title...">
        </div>
        <div class="form-group">
          <textarea name="post_content" id="post_content" autocomplete="off" required="" class="form-control"></textarea>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-lg-3">
    <!-- Box -->
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Property</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label for="">Slug</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-link"></i></span>
            <input type="text" name="icon_name" id="icon_name" autocomplete="off" class="form-control input-sm">
          </div>
        </div>
        <div class="form-group">
          <label for="">Category</label>
          <select name="post_category" id="post_category" class="form-control input-sm">
            <option value="">General</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Label</label>
          <select name="post_label" id="post_label" class="form-control input-sm">
            <option value="">General</option>
          </select>
        </div> 
        <div class="form-group">
          <label for="">Status</label>
          <select name="post_label" id="post_label" class="form-control input-sm">
            <option value="">General</option>
          </select>
        </div>                    
        <div class="form-group">
          <button class="btn btn-sm btn-primary btn-block" type="submit"> <i class="fas fa-save"></i> Save</button>
        </div>
      </div>
      <div class="overlay hidden" id="loading-overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div>
  </div>
  </form>
</div>
</section>

<script>
var loading = _getSelector('#loading-overlay');
let icon = $('#icon_name'),
    keyword = $('#icon_keyword'),
    post_title = $('#post_title'),
    post_content = $('#post_content'),
    post_slug = $('#post_slug'),
    post_category = $('#post_category'),
    post_label = $('#post_label'),
    post_status = $('#post_status'),
    post_type = $('#post_type')

/**
 * Save function
 *
 * @return void
 */
function save() {
  const data = {
    post_title: post_title,
    post_content: post_content,
    post_slug: post_slug,
    post_category: post_category,
    post_label: post_label,
    post_status: post_status,
    post_type: post_type
  }

  $.ajax({
    url: MODULE_URL + 'blog/post/save',
    type: 'POST',
    data: data,
    success: function(res) {
      console.log(res);
    }
  })
}

$(function(){
  $('#post-form').on('submit', function(e) {
    e.preventDefault();
    alert('sds')
  })
  $('#post_content').wysihtml5()
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