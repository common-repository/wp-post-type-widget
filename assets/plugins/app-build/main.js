( function( $ ) {
$(window).on('load', function() {
    init_main_body_class();
    init_body_class();
    init_page_name_as_class();
    init_table_class();
});
$(window).on('load resize', function() {
    set_body_small();
});
function is_mobile() {
     if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
         return true;
     }
     return false;
}
function init_main_body_class(){
    $('body').addClass('mmwcptwd');
    $('body').addClass('mmwcptwd-desktop-device');
    
}
function init_body_class(){
    if(is_mobile() == true){
        $('body').addClass('mmwcptwd-mobile-device');
    }
}
function set_body_small() {
    if ($(this).width() < 769) {
        $(".mmwcptwd-mobile-device .mmwcptwd-wrapper").addClass('mmwcptwd-mobile-small-page');
    } else {
        $(".mmwcptwd-desktop-device .mmwcptwd-wrapper").removeClass('mmwcptwd-mobile-small-page');
    }
}
function init_page_name_as_class() {
    var pageCurrentUrl = window.location.href;
    var removeDomainSegment = pageCurrentUrl.substr(pageCurrentUrl.lastIndexOf('/') + 1);
    var lastSegment = removeDomainSegment.split('.').slice(0, -1).join('.')
    $('.mmwcptwd-wrapper').addClass('mmwcptwd-page-'+lastSegment);
}
function init_table_class() {
    var pageCurrentUrl = window.location.href;
    var removeDomainSegment = pageCurrentUrl.substr(pageCurrentUrl.lastIndexOf('/') + 1);
    var lastSegment = removeDomainSegment.split('.').slice(0, -1).join('.')
    $('table').addClass('mmwcptwd-'+lastSegment);
}
// Datatables inline/offline lazy load images
function DataTablesOfflineLazyLoadImages(nRow, aData, iDisplayIndex) {
    var img = $('img.img-table-loading', nRow);
    img.attr('src', img.data('orig'));
    img.prev('div').addClass('hide');
    return nRow;
}
function initDataTableInline() {
  $("#cptwdTable").DataTable(
    {
     "ordering": false,
      "processing": true,
      'paginate': true,
      "responsive": true,
      "autoWidth": false,
      "order": [0, 'DESC'],
      "fnRowCallback": DataTablesOfflineLazyLoadImages,
      "language": {
          "lengthMenu": "_MENU_",
          "emptyTable": "Hooray, no data here!",
          "zeroRecords": "No matching records found",
          "info": "_START_-_END_/_TOTAL_",
          "infoEmpty": "",
          "infoFiltered": "(filtered from _MAX_ total records)",
          "loadingRecords" : 'Loading...',
          "search" : '<div class="input-group float-right"><span class="input-group-addon"><span class="fa fa-search"></span></span>',
          "searchPlaceholder" : "Search...",
          "processing" : '<div class="dt-loader"></div>',
          paginate: {
              next: '<span class="pagination-default">&#x276f;</span>',
              previous: '<span class="pagination-default">&#x276e;</span>'
          },

      }
    }

  );
}
initDataTableInline();
// Init tooltips
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    // Init popovers
    $("body").popover({
        selector: '[data-toggle="popover"]',
    });

} )( jQuery );

window.addEventListener("load", function() {
   var tabs = document.querySelectorAll("ul.nav-tabs > li");
    for (var i = 0; i < tabs.length; i++) {
      tabs[i].addEventListener("click",switchTab)
    }
    function switchTab(event){
      event.preventDefault();
      document.querySelector("ul.nav-tabs li.active").classList.remove("active");
      document.querySelector(".tab-pane.active").classList.remove("active")
      var clickedTab = event.currentTarget,
          clickedLinked = event.target.getAttribute("href");
          clickedTab.classList.add("active");
          document.querySelector(clickedLinked).classList.add("active")
    }
});
