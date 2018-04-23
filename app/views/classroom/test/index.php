
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Bdtask - Bootstrap Admin Template Dashboard</title>

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
        <link href="/lms/assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
        <!-- Start Theme Layout Style
        =====================================================================-->
        <!-- Theme style -->
        <link href="/lms/assets/dist/css/styleBD.css" rel="stylesheet" type="text/css"/>
        <link href="/lms/assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style rtl -->
        <!--<link href="/lms/assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>-->
        <!-- End Theme Layout Style
        =====================================================================-->
    </head>

    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="modal fade" id="reset-pw-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-body">

              </div>

            </div>
          </div>
        </div>


        <div class="wrapper">
            <header class="main-header">
              <a href="index.html" class="logo"> <!-- Logo -->
                <span class="logo-lg">
                      <img src="/lms/assets/dist/img/logo.png" class="my-logo" alt="">
                  </span>
              </a>
              <nav class="navbar navbar-static-top">
                <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <li class="mt6 mr10 cursor-default">
                                    <h5 class="pull-right mb0">Welcome</h5>
                                    <h4 class="mt0" id="profile-btn"><span></span></h4>
                                </li>
                                <li class="dropdown dropdown-user">
                                    <a href="dataTables.html#" class="dropdown-toggle" data-toggle="dropdown">
                                      <div class="inbox-avatar">
                                        <img src="/lms/profile/profilePicture" class="img-circle profile-image border-green" alt="">
                                      </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                      <li><a class="pointer" id="logout-btn"><i class="fa fa-key"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                    </div>
              </nav>
            </header>
            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper ml150 mr125">
                <!-- Main content -->
                <section class="content">
                    <div class="panel panel-bd">
                      <div class="panel-body">
                        <h3>1.Arrange the following statements in correct sequence??</h3>
                        <ul id="sortable" style="width:50%;">
                            <li class="" style="list-style: none;
    background: rgb(226, 219, 219);
    border-radius: 2px;
    padding: 8px 10px;
    margin-bottom:5px;
    border: 1px #bfc9d8 solid;"><span class="" style="font-size: 17px;
    font-weight: 500;
    font-family: 'Alegreya Sans', sans-serif;">Item 1</span></li>
    <li class="" style="list-style: none;
    background: rgb(226, 219, 219);
    border-radius: 2px;
    padding: 8px 10px;
    margin-bottom:5px;
    border: 1px #bfc9d8 solid;"><span class="" style="font-size: 17px;
    font-weight: 500;
    font-family: 'Alegreya Sans', sans-serif;">Item 2</span></li>
    <li class="" style="list-style: none;
    background: rgb(226, 219, 219);
    border-radius: 2px;
    padding: 8px 10px;
    margin-bottom:5px;
    border: 1px #bfc9d8 solid;"><span class="" style="font-size: 17px;
    font-weight: 500;
    font-family: 'Alegreya Sans', sans-serif;">Item 3</span></li>
    <li class="" style="list-style: none;
    background: rgb(226, 219, 219);
    border-radius: 2px;
    padding: 8px 10px;
    margin-bottom:5px;
    border: 1px #bfc9d8 solid;"><span class="" style="font-size: 17px;
    font-weight: 500;
    font-family: 'Alegreya Sans', sans-serif;">Item 4</span></li>
    <li class="" style="list-style: none;
    background: rgb(226, 219, 219);
    border-radius: 2px;
    padding: 8px 10px;
    margin-bottom:5px;
    border: 1px #bfc9d8 solid;"><span class="" style="font-size: 17px;
    font-weight: 500;
    font-family: 'Alegreya Sans', sans-serif;">Item 5</span></li>

    
                            
                        </ul>
                      </div>
                    </div>
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
        </div> <!-- ./wrapper -->
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
        <!-- Start Page Lavel Plugins
        =====================================================================-->
        <!-- End Page Lavel Plugins
        =====================================================================-->
        <!-- Start Theme label Script
        =====================================================================-->
        <!-- Dashboard js -->
        <script src="/lms/assets/dist/js/dashboard.js" type="text/javascript"></script>

        <script src="/lms/assets/dist/js/common.js" type="text/javascript"></script>
        <script src="/lms/assets/dist/js/base.js" type="text/javascript"></script>
        <!-- End Theme label Script
        =====================================================================-->
        <script type="text/javascript">




        jQuery(document).ready(function () {

            
                $( "#sortable" ).sortable();
                // $( "#sortable" ).disableSelection();
            

          var pathname = location.pathname;
          classroomConceptId = pathname.substr(pathname.lastIndexOf('/')).replace('/', '');
          pathname = pathname.substr(0,pathname.lastIndexOf('/'));
          classroomCurriculumId = pathname.substr(pathname.lastIndexOf('/')).replace('/', '');

          http.get(HOST_PATH + 'dashboard/getTest/'+classroomCurriculumId+'/' + classroomConceptId, function(data){
            data = JSON.parse(data);
            console.log(data);
            initComponents();


          });


        });
        </script>

    </body>


</html>
