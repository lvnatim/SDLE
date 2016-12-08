jQuery(document).ready(function($) {

var POSTS_PER_PAGE = 48;
var NUM_POSTS;
var MAX_PAGES;

function $_GET(param) {
  var vars = {};
  window.location.href.replace( location.hash, '' ).replace( 
    /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
    function( m, key, value ) { // callback
      vars[key] = value !== undefined ? value : '';
    }
  );

  if ( param ) return vars[param] ? vars[param] : null;
  return vars;
}

function setActivePage(curPage){
  $('.pagelist').removeClass('active');
  $('.pagelist').eq(curPage).addClass('active');
}

$.ajax({
  method: 'GET',
  url: my_ajax_object.ajax_url,
  data: {
    action: 'get_listings_count'
  },
  success: function(data){
    NUM_POSTS = parseInt(data);
    MAX_PAGES = Math.ceil(NUM_POSTS/POSTS_PER_PAGE);
    setUpEventListeners();
  }
})

var saleDate = moment.tz("2016-12-25 00:00", "America/Los_Angeles");
$('#countdown').countdown(saleDate.toDate(), function(event) {
  $(this).html(event.strftime('%D : %H : %M : %S'));
});

$('.cart-time').each(function(index){
  var unixTime = $(this).text();
  var date = unixTime * 1000;
  var saleDate = moment.tz(date, "America/Los_Angeles");
  $(this).countdown(saleDate.toDate(), function(event) {
    $(this).html(event.strftime('%M:%S'));
  });
});

var curPage;

if($_GET('page_num')){
  curPage = parseInt($_GET('page_num'));
  setActivePage(curPage);
} else {
  curPage = 0;
  setActivePage(curPage);
}

function getNewPage(pageNum){
  $.ajax({
    method: 'GET',
    url: my_ajax_object.ajax_url,
    data: {
      action: 'get_listings',
      page_num: pageNum,
    },
    success: function(data){
      $('#listings').html(data);
      setActivePage(pageNum);
    },
    error: function(data){
      console.log("There was an error loading the images.");
    }
  })
}

function setUpEventListeners(){
  $('.next').on('click', function(e){
    curPage += 1;
    curPage = curPage == MAX_PAGES ? curPage = 0 : curPage;
    getNewPage(curPage);
  })
  $('.previous').on('click', function(e){
    curPage -= 1;
    curPage = curPage < 0 ? curPage = (MAX_PAGES-1) : curPage;
    getNewPage(curPage);
  })
  $('.pagelist').on('click',function(e){
    var newPage = $(this).data('page');
    if(newPage !== curPage){
      getNewPage(newPage);  
      curPage = newPage;
    }
  })
}

function addFilter(name){
  var className = "." + name;
  var idName = "#" + name;
  $(idName).hover(
    function(){
      $(this).addClass('active');
      $('.authenticity-image').not(className).addClass('active');
      $('.authenticity-overlay').addClass('active');
    },
    function(){
      $(this).removeClass('active');
      $('.authenticity-image').removeClass('active');
      $('.authenticity-overlay').removeClass('active');
    }
  );
}

addFilter("back");
addFilter("certificate");
addFilter("signature");
addFilter("stamp");

});