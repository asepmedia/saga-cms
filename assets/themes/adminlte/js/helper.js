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

/**
 * 
 * @param {*} type 
 * @param {*} msg 
 */
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