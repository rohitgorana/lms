
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>A2Z LMS | Classroom</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="/lms/assets/dist/img/ico/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="/lms/assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="/lms/assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="/lms/assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="/lms/assets/dist/img/ico/apple-touch-icon-144-precomposed.png">

        <!-- Start Global Mandatory Style
        =====================================================================-->
        <!-- jquery-ui css -->
        <link href="/lms/assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap -->
        <link href="/lms/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap rtl -->
        <!--<link href="/lms/assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
        <!-- Lobipanel css -->
        <link href="/lms/assets/plugins/lobipanel/lobipanel.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pace css -->
        <link href="/lms/assets/plugins/pace/flash.css" rel="stylesheet" type="text/css"/>
        <!-- Font Awesome -->
        <link href="/lms/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- Pe-icon -->
        <link href="/lms/assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- Themify icons -->
        <link href="/lms/assets/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
        <!-- End Global Mandatory Style
        =====================================================================-->
        <!-- Start Theme Layout Style
        =====================================================================-->
        <!-- Theme style -->
        <link href="/lms/assets/dist/css/styleBD.css" rel="stylesheet" type="text/css"/>
        <link href="/lms/assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
        <link href="http://vjs.zencdn.net/5.19/video-js.css" rel="stylesheet">
        <!-- Theme style rtl -->
        <!--<link href="/lms/assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>-->
        <!-- End Theme Layout Style
        =====================================================================-->
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header position-fixed w100">
                <a href="/lms/dashboard" class="logo alt-logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <!--<b>A</b>BD-->
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <span class="logo-lg">
                        <img src="/lms/assets/dist/img/logo.png" alt="" class="my-logo">
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top alt-navbar">
                    <a href="dashboard" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="mlr10 center">
                      <i class="fa fa-angle-left disable pointer p10 fs20 contentNavPane" id="prevBtn" disabled></i>
                      <h3 class="header-text" id="contentTitle"></h3>
                      <i class="fa fa-angle-right pointer p10 fs2-2 contentNavPane" id="nextBtn"></i>
                      <div class="navbar-custom-menu pull-right">
                              <ul class="nav navbar-nav">
                                  <li class="mt6 mr10 cursor-default">
                                      <h5 class="pull-right mb0">Welcome</h5>
                                      <h4 class="mt0" id="profile-btn"><span></span></h4>
                                  </li>
                                  <li class="dropdown dropdown-user">
                                      <a href="dataTables.html#" class="dropdown-toggle" data-toggle="dropdown">
                                        <div class="inbox-avatar">
                                          <img src="/lms/assets/dist/img/user.jpg" class="img-circle border-green" alt="">
                                        </div>
                                      </a>
                                      <ul class="dropdown-menu">
                                        <li><a class="pointer" href="profile"><i class="fa fa-edit"></i><span>Profile</span></a></li>
                                        <li><a class="pointer" id="logout-btn"><i class="fa fa-key"></i> Logout</a></li>
                                      </ul>
                                  </li>
                              </ul>
                      </div>
                      <div class="pull-right mt10 mr10 fs1-1">
                        <ul class="nav nav-tabs">


                        </ul>
                      </div>
                    </div>
                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar position-fixed alt-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- sidebar menu -->
                    <ul class="sidebar-menu" id="sidebar">
                      <li class="header p0"><div class="profile-widget">
                                        <div class="panel panel-bd mb0 br0">


                                            <div class="panel-footer">
                                                <div class="btn-group btn-group-justified">
                                                    <a class="btn btn-default ptb10" id="sidebar-courses-btn" role="button"><i class="fa fa-folder fs20"></i></a>
                                                    <a class="btn btn-default ptb10" id="sidebar-class-content-btn" role="button"><i class="fa fa-list-ul fs20"></i></a>

                                                </div>
                                            </div>
                                        </div>
                                    </div></li>
                               <div class="scroll">
                                  <ul id="sidebar-courses" class="sidebar-menu" style="display:none">

                                  </ul>

                                  <ul id="sidebar-class-content" class="sidebar-menu" >

                                  </ul>
                              </div>



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
                <strong>Copyright � 2016-2017 <a href="notification.html#">bdtask</a>.</strong> All rights reserved. <i class="fa fa-heart color-green"></i>
            </footer> -->
        </div>
        <!-- ./wrapper -->
        <!-- Start Core Plugins
        =====================================================================-->
        <!-- jQuery -->
        <script src="/lms/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <!-- jquery-ui -->
        <script src="/lms/assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="/lms/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- lobipanel -->
        <script src="/lms/assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
        <!-- Pace js -->
        <script src="/lms/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="/lms/assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="/lms/assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminBD frame -->
        <script src="/lms/assets/dist/js/frame.js" type="text/javascript"></script>
        <!-- End Core Plugins
        =====================================================================-->

        <!-- Start Theme label Script
        =====================================================================-->
        <!-- Dashboard js -->
        <script src="/lms/assets/dist/js/dashboard.js" type="text/javascript"></script>
        <script src="/lms/assets/dist/js/common.js" type="text/javascript"></script>
        <script src="/lms/assets/dist/js/base.js" type="text/javascript"></script>

        <script src="http://vjs.zencdn.net/ie8/1.1/videojs-ie8.min.js"></script>
        <script src="http://vjs.zencdn.net/5.19/video.js"></script>

        <!-- End Theme label Script
        =====================================================================-->
        <script>
          var classroomCurriculum = null, classroomTopicId = null, classroomSubtopicId = null;
          var classroomData = null, classroomContent = null;
          var subtopicTutor = new tutor({
                videoFetchURL: "",
                questionFetchURL: "",
                questionSubmitURL:""
            });
          subtopicTutor.on('finish', function(){
            loadContent(++currentSubtopicIndex);
          });
          var currentSubtopicIndex = 0;
          $(document).ready(function(){

            var pathname = location.pathname;
            classroomTopicId = pathname.substr(pathname.lastIndexOf('/')).replace('/', '');
            pathname = pathname.substr(0,pathname.lastIndexOf('/'));
            classroomCurriculum = pathname.substr(pathname.lastIndexOf('/')).replace('/', '');
            
            http.get(HOST_PATH + 'classroom/getTopic/'+classroomCurriculum+'/' + classroomTopicId, function(data){
              data = JSON.parse(data);
              console.log(data);
              $('#profile-btn span').text(data.user.fullname);
              classroomData = data.content.classroomData;
              classroomContent = data.content.content;

              initComponents();


            });







            
          });

          function initComponents(){
            //SIDEBAR THINGS
            var sidebarClassContentMarkup = '';
            for (var i = 0; i < classroomContent.length; i++) {
              sidebarClassContentMarkup += `<li class="${i == $('#player').attr('data-index')?'active':'contentItem'} ellipsis" data-index="${i}" data-id="` + classroomContent[i].id + `"><a class="pointer classroom-sidebar-content"><i class="fa ${classroomContent[i].access == 'open'?'fa-unlock':'fa-lock'}"></i><span>` + classroomContent[i].name + `</span></a></li>`;
            }
            
            $('#sidebar-class-content').append(sidebarClassContentMarkup);

            $('.contentItem').click(function(){
              var index = $(this).attr('data-index');
              loadContent(index);
            });

            $('#sidebar-courses').attach(new sidebarContent(classroomData),'', function(args){
              $('#player').each(function(){
                delete this;
                $(this).remove();
              });


              sessionStorage.setItem('content', args.id);
              http.get(HOST_PATH + 'classroom/getdata/'+sessionStorage.getItem('curriculum')+'/'+args.id, function(data){
                data = JSON.parse(data);
                $('#profile-btn span').text(data.user.fullname);
                initComponents(data);
              });
            });

            // $('.sidebarItem[data-id='+sessionStorage.getItem('content')+']').parents('ul.treeview-menu').each(function(){$(this).prev().trigger('click');});
            // $('.sidebarItem[data-id='+sessionStorage.getItem('content')+']').each(function(){$(this).addClass('active');});
            // var offset = $('.sidebarItem[data-id='+sessionStorage.getItem('content')+']').offset();
            // offset.left -= 20;
            // offset.top -= 20;
            // $('#sidebar-courses').animate({
            //   scrollTop: offset.top,
            //   scrollLeft: offset.left
            // });

            $('#sidebar-class-content-btn').click(function(){
              $('#sidebar-courses').css('display', 'none');
              $('#sidebar-class-content').css('display', 'block');
            });

            $('#sidebar-courses-btn').click(function(){
              $('#sidebar-class-content').css('display', 'none');
              $('#sidebar-courses').css('display', 'block');
            });
            $('.scroll').slimScroll({
                size: '3px',
                height: '80vh'
            });

            //END SIDEBAR THINGS

            //LOGOUT 
            $('#logout-btn').click(function(){
              http.get('/lms/logout');
            });

            //LOAD CONTENT
            loadContent(0);

            //NEXT PREV BUTTONS
            $('#nextBtn').click(function () {
              var target = $(".tab-pane.active").attr('id');

              switch (target) {
                case 'video':
                var index = parseInt($('#player').attr('data-index')) + 1;
                changeVideo(index);
                break;

                case 'book':
                var index = parseInt($('#pdfViewer').attr('data-index')) + 1;
                changeBook(index);
                break;

                
              }

            });

            $('#prevBtn').click(function () {

              var target = $(".tab-pane.active").attr('id');

              switch (target) {
                case 'video':
                var index = parseInt($('#player').attr('data-index')) - 1;
                changeVideo(index);

                break;

                case 'book':
                var index = parseInt($('#pdfViewer').attr('data-index')) - 1;
                changeBook(index);
                break;

               
              }   



            });

          }

          function loadContent(index){
            $('.contentItem.active').removeClass('active');
            $('.contentItem[data-index='+index+']').addClass('active');
            currentSubtopicIndex = index;
            var content = classroomContent[index].content;
            classroomSubtopicId = classroomContent[index].id;
            $('.nav-tabs').empty();
            $('.tab-content').empty();
            $('.contentNavPane').hide();
            $('#contentTitle').empty();
            videolist = [];
            booklist = [];
            

           

            if (!Array.isArray(content)) {
                if (content.hasOwnProperty('webm') || content.hasOwnProperty('mp4')) {
                    videolist = videolist.concat(content['webm'] || content['mp4']);
                    $('.nav-tabs').append('<li class="pointer"><a href="#video" data-toggle="tab"><i class="fa fa-play"></i></a></li>');
                    $('.tab-content').append(`<div class="tab-pane fade in" id="video">
                        <div class="panel-body p-0">
                            ${subtopicTutor.get()}
                        </div>
                        </div>`);

                    subtopicTutor.init();
                    
                }

              if (content.hasOwnProperty('pdf')) {
                  booklist = booklist.concat(content['pdf']);
                  $('.nav-tabs').append('<li class="pointer"><a href="#book" data-toggle="tab"><i class="fa fa-book"></i></a></li>');
                  $('.tab-content').append(`<div class="tab-pane fade in" id="book">
                      <div class="panel-body p-0">
                          <iframe style="height:90vh" id="pdfViewer" src = "" width='100%' data-index="0"  allowfullscreen webkitallowfullscreen></iframe>
                      </div>
                      </div>`);
              }



              changeVideo(0);
              changeBook(0);
              
              $('.tab-content .tab-pane:first').addClass('active');
              $('.nav-tabs li:first').addClass('active');

            

              $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                  var target = $(e.target).attr("href") // activated tab
                  switch (target) {
                      case '#video':
                          if (videolist.length > 1)
                              $('.contentNavPane').show();
                          else
                              $('.contentNavPane').hide();
                          var currentIndex = parseInt($('#player').attr('data-index'));
                          $('#contentTitle').text(videolist[currentIndex].name);

                          break;

                      case '#book':
                          if (booklist.length > 1)
                              $('.contentNavPane').show();
                          else
                              $('.contentNavPane').hide();

                          var currentIndex = parseInt($('#pdfViewer').attr('data-index'));
                          $('#contentTitle').text(booklist[currentIndex].name);
                          break;

                     
                  }

                  resetContentNavs(target.substring(1));
              });
            

              var target = $(".tab-pane.active").attr('id');
              switch (target) {
                  case 'video':
                      if (videolist.length > 1)
                          $('.contentNavPane').show();

                      else
                          $('.contentNavPane').hide();
                      break;

                  case 'book':
                      if (booklist.length > 1)
                          $('.contentNavPane').show();
                      else
                          $('.contentNavPane').hide();
                      break;

                  
              }
            }
            else {
                $('.content').append('<p class="empty-message">Content Not Available</p>');
            }

          }

         

          function resetContentNavs(target) {

            switch (target) {
                case 'video':
                    var currentIndex = $('#player').attr('data-index');
                    if (currentIndex == 0)
                        $('#prevBtn').addClass('disable');
                    else
                        $('#prevBtn').removeClass('disable');

                    if (currentIndex == videolist.length - 1)
                        $('#nextBtn').addClass('disable');
                    else
                        $('#nextBtn').removeClass('disable');

                    break;

                case 'book':
                    var currentIndex = $('#pdfViewer').attr('data-index');
                    if (currentIndex == 0)
                        $('#prevBtn').addClass('disable');
                    else
                        $('#prevBtn').removeClass('disable');

                    if (currentIndex == booklist.length - 1)
                        $('#nextBtn').addClass('disable');
                    else
                        $('#nextBtn').removeClass('disable');
                    break;

                case 'quiz':
                    var currentIndex = $('#quiz').attr('data-index');
                    if (currentIndex == 0)
                        $('#prevBtn').addClass('disable');
                    else
                        $('#prevBtn').removeClass('disable');

                    if (currentIndex == quizlist.length - 1)
                        $('#nextBtn').addClass('disable');
                    else
                        $('#nextBtn').removeClass('disable');
                    break;
            }
          }

          function changeVideo(index) {
              if (videolist[index] != undefined) {
                subtopicTutor.changeMedia(HOST_PATH + 'watch?curr=' + classroomCurriculum + '&id=' + videolist[index].id, 
                    {
                        fetchURL:HOST_PATH + 'classroom/getPracticeQuestion/'+ classroomCurriculum +'/' + classroomSubtopicId,
                        submitURL:HOST_PATH + 'classroom/checkPracticeQuestion/'+ classroomCurriculum +'/' + classroomSubtopicId
                    }
                );
                
                $('#player').attr('data-index', index);
                $('#contentTitle').text(videolist[index].name);
                resetContentNavs('video');
              }
          }
          function changeBook(index) {
              if (booklist[index] != undefined) {
                  $('.tab-pane#book div').empty().append(`<iframe style="height:90vh" id="pdfViewer" src = "" width='100%' data-index="0"  allowfullscreen webkitallowfullscreen></iframe>`);
                  $('#pdfViewer').attr('src', '/lms/assets/plugins/ViewerJS/#' + location.protocol + '//' + location.hostname + HOST_PATH + 'watch?curr=' + sessionStorage.getItem('curriculum') + '&id=' + booklist[index].id);
                  $('#pdfViewer').attr('data-index', index);
                  $('#contentTitle').text(booklist[index].name);
                  resetContentNavs('book');
              }
          }

        
        </script>
    </body>
</html>
