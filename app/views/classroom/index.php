<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>A2Z LMS | Classroom</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/dist/img/ico/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="assets/dist/img/ico/apple-touch-icon-144-precomposed.png">

        <!-- Start Global Mandatory Style
        =====================================================================-->
        <!-- jquery-ui css -->
        <link href="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap rtl -->
        <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
        <!-- Lobipanel css -->
        <link href="assets/plugins/lobipanel/lobipanel.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pace css -->
        <link href="assets/plugins/pace/flash.css" rel="stylesheet" type="text/css"/>
        <!-- Font Awesome -->
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="assets/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
        <!-- End Global Mandatory Style
        =====================================================================-->
        <!-- Start Theme Layout Style
        =====================================================================-->
        <!-- Theme style -->
        <link href="assets/dist/css/styleBD.css" rel="stylesheet" type="text/css"/>
        <link href="assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
        <link href="http://vjs.zencdn.net/5.19/video-js.css" rel="stylesheet">
        <!-- Theme style rtl -->
        <!--<link href="assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>-->
        <!-- End Theme Layout Style
        =====================================================================-->
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header position-fixed w100">
                <a href="dashboard" class="logo alt-logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <!--<b>A</b>BD-->
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <span class="logo-lg">
                        <img src="assets/dist/img/logo.png" alt="" class="my-logo">
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top alt-navbar">
                    <a href="dashboard" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="dis-inl-block mt10">
                          <ul id="content-btn-list">

                          </ul>
                      </div>



                    <div class="navbar-custom-menu pull-right">
                            <ul class="nav navbar-nav">
                                <li class="mt6 mr10 cursor-default">
                                    <h5 class="pull-right mb0">Welcome</h5>
                                    <h4 class="mt0" id="profile-btn"><span></span></h4>
                                </li>
                                <li class="dropdown dropdown-user">
                                    <a href="dataTables.html#" class="dropdown-toggle" data-toggle="dropdown">
                                      <div class="inbox-avatar">
                                        <img src="assets/dist/img/user.jpg" class="img-circle border-green" alt="">
                                      </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="pointer"><i class="fa fa-edit"></i><span>Profile</span></a></li>
                                      <li><a class="pointer" id="logout-btn"><i class="fa fa-key"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                    </div>
                    <div class="pull-right mt10 mr10 fs1-1">
                      <ul class="nav nav-tabs">

                      </ul>
                    </div>
                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar position-fixed alt-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- sidebar menu -->
                    <ul class="sidebar-menu scroll" id="sidebar">




                    </ul>
                </div> <!-- /.sidebar -->
            </aside>
            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper alt-content-wrapper">
                <!-- Main content -->
                <section class="content p0">


                    <div class="tab-content pt60">

                    </div>
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
            <!-- <footer class="main-footer alt-footer">
                <div class="pull-right hidden-xs"> <b>Version</b> 1.0</div>
                <strong>Copyright © 2016-2017 <a href="notification.html#">bdtask</a>.</strong> All rights reserved. <i class="fa fa-heart color-green"></i>
            </footer> -->
        </div>
        <!-- ./wrapper -->
        <!-- Start Core Plugins
        =====================================================================-->
        <!-- jQuery -->
        <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <!-- jquery-ui -->
        <script src="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- lobipanel -->
        <script src="assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
        <!-- Pace js -->
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminBD frame -->
        <script src="assets/dist/js/frame.js" type="text/javascript"></script>
        <!-- End Core Plugins
        =====================================================================-->

        <!-- Start Theme label Script
        =====================================================================-->
        <!-- Dashboard js -->
        <script src="assets/dist/js/dashboard.js" type="text/javascript"></script>
        <script src="assets/dist/js/common.js" type="text/javascript"></script>
        <script src="assets/dist/js/base.js" type="text/javascript"></script>

        <script src="http://vjs.zencdn.net/ie8/1.1/videojs-ie8.min.js"></script>
        <script src="http://vjs.zencdn.net/5.19/video.js"></script>

        <!-- End Theme label Script
        =====================================================================-->
        <script>
            var videolist = [];
            var booklist = [];
            var quizlist = [];

            $(document).ready(function () {

                "use strict"; // Start of use strict

                // Message
                $('.scroll').slimScroll({
                    size: '3px',
                    height: '100vh'
//                    position: 'left'
                });
                $('#logout-btn').click(function(){

                    http.get('/lms/logout');
                });
                http.get(HOST_PATH + 'classroom/getdata/'+sessionStorage.getItem('curriculum')+'/' + sessionStorage.getItem('content'), function(data){
                  data = JSON.parse(data);
                  $('#profile-btn span').text(data.user.fullname);
                  initComponents(data.content);
                });









            function initComponents(data){

                $('.nav-tabs').empty();
                $('.tab-content').empty();
                $('#sidebar').empty();
                $('.contentNavPane').hide();
                $('#contentTitle').empty();
                videolist = [];
                booklist = [];
                quizlist = [];

                var classroomData = data.classroomData;
                var content = data.content;
                if(!Array.isArray(content)){

                  for (var media in content) {
                    if(media == 'webm' || media == 'mp4'){
                      videolist = videolist.concat(content[media]);
                      $('.nav-tabs').append('<li class="pointer"><a href="#video" data-toggle="tab"><i class="fa fa-play"></i></a></li>');
                      $('.tab-content').append(`<div class="tab-pane fade in" id="video">
                      <div class="panel-body p-0">
                      <video class="video-player video-js vjs-default-skin" preload="none" id="player" src="" data-index="0" controls width="100%"></video>
                      </div>
                      </div>`);
                      videojs($('.video-js')[0], {}, function(){});
                      $('video').on('contextmenu', function(e) {
                          e.preventDefault();
                      });
                    }
                    else if(media == 'pdf'){
                      booklist = booklist.concat(content[media]);
                      $('.nav-tabs').append('<li class="pointer"><a href="#book" data-toggle="tab"><i class="fa fa-book"></i></a></li>');
                      $('.tab-content').append(`<div class="tab-pane fade in" id="book">
                      <div class="panel-body p-0">
                        <iframe style="height:90vh" id="pdfViewer" src = "" width='100%' data-index="0"  allowfullscreen webkitallowfullscreen></iframe>
                      </div>
                      </div>`);
                    }
                    else if(media == 'quiz'){
                      quizlist = quizlist.concat(content[media]);
                      $('.nav-tabs').append('<li class="pointer"><a href="#quiz" data-toggle="tab"><i class="fa fa-check-square-o"></i></a></li>');
                      $('.tab-content').append(`<div class="tab-pane fade in" id="quiz">

                      </div>`);
                    }




                  }
                  changeVideo(0);
                  changeBook(0);
                  changeQuiz(0);
                  $('.tab-content .tab-pane:first').addClass('active');
                  $('.nav-tabs li:first').addClass('active');
                  var target = $(".tab-pane.active").attr('id');
                  switch(target){
                    case 'video' :
                      $('#content-btn-list').empty();
                      for (var i = 0; i < videolist.length; i++) {
                        $('#content-btn-list').append(`<li class="content-btn" onclick="changeVideo(${i})">
                              <span class="content-btn-title">${videolist[i].name}</span>
                          </li>`);
                      }
                      break;

                    case 'book' :
                      $('#content-btn-list').empty();
                      for (var i = 0; i < booklist.length; i++) {
                        $('#content-btn-list').append(`<li class="content-btn" onclick="changeBook(${i})">
                            <span class="content-btn-title">${booklist[i].name}</span>
                        </li>`);
                      }
                      break;

                    case 'quiz' :
                      $('#content-btn-list').empty();
                      for (var i = 0; i < quizlist.length; i++) {
                        $('#content-btn-list').append(`<li class="content-btn" onclick="changeQuiz(${i})">
                            <span class="content-btn-title">${quizlist[i].name}</span>
                        </li>`);
                      }
                      break;
                  }

                  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    var target = $(e.target).attr("href") // activated tab
                    switch(target){
                      case '#video' :
                        $('#content-btn-list').empty();
                        for (var i = 0; i < videolist.length; i++) {
                          $('#content-btn-list').append(`<li class="content-btn" onclick="changeVideo(${i})">
                              <span class="content-btn-title">${videolist[i].name}</span>
                          </li>`);
                        }
                        var currentIndex = parseInt($('#player').attr('data-index'));


                        break;

                      case '#book' :
                        $('#content-btn-list').empty();
                        for (var i = 0; i < booklist.length; i++) {
                          $('#content-btn-list').append(`<li class="content-btn" onclick="changeBook(${i})">
                              <span class="content-btn-title">${booklist[i].name}</span>
                          </li>`);
                        }

                        var currentIndex = parseInt($('#pdfViewer').attr('data-index'));

                        break;

                      case '#quiz' :
                        $('#content-btn-list').empty();
                        for (var i = 0; i < quizlist.length; i++) {
                          $('#content-btn-list').append(`<li class="content-btn" onclick="changeQuiz(${i})">
                              <span class="content-btn-title">${quizlist[i].name}</span>
                          </li>`);
                        }

                        var currentIndex = parseInt($('#quiz').attr('data-index'));

                        break;
                    }


                  });


                }
                else{
                  $('.content').append('<p class="empty-message">Content Not Available</p>');
                }




                $('.sidebar-menu').attach(new sidebarContent(classroomData),'', function(args){
                  $('#player').each(function(){
                		delete this;
                		$(this).remove();
                	});


                  sessionStorage.setItem('content', args.id);
                  http.get(HOST_PATH + 'classroom/getdata/'+sessionStorage.getItem('curriculum')+'/'+args.id, function(data){
                      data = JSON.parse(data);
                      initComponents(data);
                  });
                });





            }
          });
          function changeQuiz(index){
            if(quizlist[index] != undefined){
              http.get(HOST_PATH + 'classroom/getQuiz/' + quizlist[index].id + '/' + sessionStorage.getItem('curriculum'), function(data){
                var q = new quiz(data);
                $('#quiz').empty().attach(new form({
                  id: 'quizForm',
                  action: 'classroom/submitQuiz',
                  elements:[
                    {
                      type: 'hidden',
                      value: sessionStorage.getItem('curriculum'),
                      name: 'curr'
                    },
                    {
                      type: 'hidden',
                      value: quizlist[index].id,
                      name: 'quiz'
                    },
                    {
                      type: 'custom',
                      markup: q.get()
                    }
                  ],
                  onsuccess: function(data){
                    alert('You have scored: ' + data + '%');
                  }

                }));
              });
              $('#quiz').attr('data-index', index);
              // $('#contentTitle').text(quizlist[index].name);
              // resetContentNavs('quiz');
            }
          }
          function changeVideo(index){
            if(videolist[index] != undefined){
              $('#player video').attr('src', HOST_PATH + 'watch?curr='+sessionStorage.getItem('curriculum')+'&id='+videolist[index].id);
              $('#player').attr('data-index', index);
              // $('#contentTitle').text(videolist[index].name);
              // resetContentNavs('video');
            }
          }
          function changeBook(index){
            if(booklist[index] != undefined){
              $('.tab-pane#book div').empty().append(`<iframe style="height:90vh" id="pdfViewer" src = "" width='100%' data-index="0"  allowfullscreen webkitallowfullscreen></iframe>`);
              $('#pdfViewer').attr('src', 'assets/plugins/ViewerJS/#'+ location.protocol + '//' +location.hostname +HOST_PATH + 'watch?curr='+sessionStorage.getItem('curriculum')+'&id='+booklist[index].id);
              $('#pdfViewer').attr('data-index', index);
              // $('#contentTitle').text(booklist[index].name);
              // resetContentNavs('book');
            }
          }
        </script>
    </body>
</html>
