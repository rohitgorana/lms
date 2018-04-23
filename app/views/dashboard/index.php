<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>A2Z LMS | Dashboard</title>

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
        <link href="assets/dist/css/styleBD.css" rel="stylesheet" type="text/css"/>
        <link href="assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/bootstrap-tour/bootstrap-tour.min.css" rel="stylesheet" type="text/css"/>




        <link href="assets/plugins/datatables/dataTables.min.css" rel="stylesheet" type="text/css"/>

        <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>

        <link href="assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/contextmenu/jquery.contextMenu.min.css" rel="stylesheet" type="text/css"/>

        <link href="assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/finderJS/finderjs.css" rel="stylesheet" type="text/css"/>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" lazyload>
        <link href="http://vjs.zencdn.net/5.19/video-js.css" rel="stylesheet">


    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="modal fade" id="large-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

              </div>
              <div class="modal-body">

              </div>

            </div>
          </div>
        </div>
        <div class="modal fade" id="utility-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title">Modal title</h1>
              </div>
              <div class="modal-body">

              </div>

            </div>
          </div>
        </div>

        <div class="modal fade" id="sub-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title">Modal title</h1>
              </div>
              <div class="modal-body">

              </div>

            </div>
          </div>
        </div>
        <div class="modal fade" id="small-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h1 class="modal-title">Modal title</h1>
              </div>
              <div class="modal-body">

              </div>

            </div>
          </div>
        </div>

        <div class="wrapper">

            <header class="main-header">

                <a href="index.html" class="logo alt-logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="logo-lg">
                        <!--<b>Admin</b>BD-->
                        <img src="assets/dist/img/logo.png" alt="" class="my-logo">
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top alt-navbar">


                    <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="fl mlr10">
                        <h3 id="SectionTitle">DASHBOARD</h3>
                    </div>
                    <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <li class="mt6 mr10 cursor-default">
                                    <h5 class="pull-right mb0">Welcome</h5>
                                    <h4 class="mt0" id="profile-btn"><span></span></h4>
                                </li>
                                <li class="dropdown dropdown-user">
                                    <a href="dataTables.html#" class="dropdown-toggle" data-toggle="dropdown">
                                      <div class="inbox-avatar">
                                        <img src="profile/profilePicture" class="img-circle border-green" alt="">
                                      </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="pointer" href="profile"><i class="fa fa-edit"></i><span>Profile</span></a></li>
                                      <li><a class="pointer" id="logout-btn"><i class="fa fa-key"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                    </div>
                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar alt-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <ul class="sidebar-menu">

                    </ul>
                </div> <!-- /.sidebar -->
            </aside>
            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper alt-content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">





                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 m-b-20 context-menu-one" id="mainContent">
                          <!-- Nav tabs -->

                      </div>
                  </div>
                </section>
            </div>
      </div>
        <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <script src="assets/dist/js/frame.js" type="text/javascript"></script>
        <script src="assets/plugins/bootstrap-tour/bootstrap-tour.min.js" type="text/javascript"></script>

        <script src="assets/plugins/sweetalert/sweetalert.min.js" type="text/javascript"></script>
        <script src="assets/plugins/datatables/dataTables.min.js" type="text/javascript"></script>
        <script src="assets/plugins/Nestable/jquery.nestable.js" type="text/javascript"></script>
        <script src="assets/dist/js/dashboard.js" type="text/javascript"></script>
        <script src="assets/dist/js/common.js" type="text/javascript"></script>
        <script src="assets/dist/js/base.js" type="text/javascript"></script>
        <script src="assets/plugins/contextmenu/jquery.contextMenu.min.js" type="text/javascript"></script>
        <script src="assets/plugins/dropzone/dropzone.js" type="text/javascript"></script>
        <script src="assets/plugins/modernizr/modernizr.custom.js"></script>
        <script src="assets/plugins/modernizr/toucheffects.js"></script>
        <script src="assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
        <script src="http://vjs.zencdn.net/ie8/1.1/videojs-ie8.min.js"></script>
        <script src="http://vjs.zencdn.net/5.19/video.js"></script>

        <!-- <script src="assets/plugins/finderjs/finder.min.js"></script> -->



        <script type="text/javascript">
        $(document).ready(function () {


          $(document).on('show.bs.modal', '.modal', function () {
              var zIndex = 1040 + (10 * $('.modal:visible').length);
              $(this).css('z-index', zIndex);
              setTimeout(function() {
                  $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
              }, 0);
          });

          $('#logout-btn').click(function(){

              http.get('/lms/logout');
          });

            http.get(HOST_PATH + 'dashboard/getdata', function(data){
                var cover = function(args){};

                if(data.map.type == 'local'){

                    cover =  function(args){

                        window.explorer.path = [];

                        http.get(HOST_PATH + 'dashboard/'+args.method, function(data){
                          console.log(data);
                          for(var element in data.main){
                            element = new this[element](data.main[element], data.additional);
                            $('#mainContent').empty().attach(element,args.id);

                          }

                          for(var element in data.header){
                              element = new this[element](data.header[element], data.additional);
                              $('.content-header').empty().attach(element,args.id);
                          }

                          $('#utility-modal').find('h1').text('ADD NEW ' + args.id.toUpperCase());
                          $('#utility-modal').find('.modal-body').empty().attach(new addNewForm(args.id,data.additional),args.id);
                        });




                    };
                }
                else if(data.map.type == 'alternate'){

                    cover =  function(args){

                        var getParams = '';
                        getParams = data.map.params.map(function(param){
                            return '/'+args[param];
                        }).join('');
                        

                        http.get(HOST_PATH + 'dashboard/'+args.method + getParams, function(data){
                            console.log(data);
                            for(var element in data.main){
                                element = new this[element](data.main[element], data.additional);
                                $('#mainContent').empty().attach(element,args.id);
                            }

                            for(var element in data.header){
                                element = new this[element](data.header[element], data.additional);
                                $('.content-header').empty().attach(element,args.id);
                            }

                            
                        });




                    };
                }
                else{
                    cover =  function(args){
                      sessionStorage.setItem('curriculum', args.curr);
                      sessionStorage.setItem('content', args.id);
                        window.location.href = data.map.route ;
                    };
                    for(var element in data.main){
                        element = new this[element](data.main[element]);
                        $('#mainContent').empty().attach(element);

                    }

                    for(var element in data.header){
                        element = new this[element](data.header[element]);
                        $('.content-header').empty().attach(element);
                    }

                }


                $('.sidebar-menu').attach(new sidebarContent(data.sidebar),'', cover);
                $('#profile-btn span').text(data.user.fullname);
                if(data.map.type == 'local')
                  $('.sidebarItem:first').trigger('click');
                else if(data.map.type == 'alternate'){
                    for(var element in data.main){
                        element = new this[element](data.main[element]);
                        $('#mainContent').empty().attach(element);

                    }
                }




                if(getCookie('visited')== ""){
                  createCookie('visited', 'yes', 1);
                }




            });



        });
        </script>
    </body>
</html>
