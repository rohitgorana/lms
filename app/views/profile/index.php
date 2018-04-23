
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Bdtask - Bootstrap Admin Template Dashboard</title>

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
        <link href="assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
        <!-- Start Theme Layout Style
        =====================================================================-->
        <!-- Theme style -->
        <link href="assets/dist/css/styleBD.css" rel="stylesheet" type="text/css"/>
        <link href="assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style rtl -->
        <!--<link href="assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>-->
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
                      <img src="assets/dist/img/logo.png" class="my-logo" alt="">
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
                                        <img src="profile/profilePicture" class="img-circle profile-image border-green" alt="">
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
                          <div class="center">
                              <img src="profile/profilePicture" class="profile-image" style="border-radius:50%;"alt="">
                          </div>

                          <div class="center mtb10">
                            <form id="picture-form" class="dis-inl">
                                <label class="change-profile-img-tag" for="picture-select">Change Photo</label>
                                <input type="file" id="picture-select" name="picture" style="display: none;">
                            </form>
                            <div class="dis-inl-block pointer" id="reset-password">
                              <h5 class="reset-password-tag">Reset Password</h5>
                            </div>
                          </div>

                          <form class="" id="profile-form">
                            <div class="form-group">
                                            <label for="profile-fullname">Name :</label>
                                            <input class="form-control" type="text" id="profile-fullname" name="name">

                            </div>
                            <div class="form-group">
                                            <label for="profile-username">Username :</label>
                                            <input class="form-control" type="text"  id="profile-username" name="username">

                            </div>
                            <div class="form-group">
                                            <label for="profile-email">Email :</label>
                                            <input class="form-control" type="email" name="email" id="profile-email">

                            </div>
                            <div class="form-group">
                                            <label for="profile-contact">Phone Number :</label>
                                            <input class="form-control" type="tel" name="contact" id="profile-contact">

                            </div>
                            <button type="submit" class="btn btn-primary center quiz-btn">Submit</button>
                          </form>
                        </div>
                      </div>
                    </div>
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
        </div> <!-- ./wrapper -->
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
        <!-- Start Page Lavel Plugins
        =====================================================================-->
        <!-- End Page Lavel Plugins
        =====================================================================-->
        <!-- Start Theme label Script
        =====================================================================-->
        <!-- Dashboard js -->
        <script src="assets/dist/js/dashboard.js" type="text/javascript"></script>

        <script src="assets/dist/js/common.js" type="text/javascript"></script>
        <script src="assets/dist/js/base.js" type="text/javascript"></script>
        <!-- End Theme label Script
        =====================================================================-->
        <script type="text/javascript">




        jQuery(document).ready(function () {
          var pictureForm = document.getElementById('picture-form');
          var fileSelect = document.getElementById('picture-select');

          fileSelect.onchange= function(event){

            $('#picture-form').trigger('submit');
          }



           $('#picture-form').submit(function(event) {

            event.preventDefault();


            var files = fileSelect.files;
            var formData = new FormData();
            formData.set('picture', files[0], files[0].name);


            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'profile/updateProfilePicture', true);

            xhr.onreadystatechange  = function () {
              if (this.status === 200) {
                $('.profile-image').attr('src', 'profile/profilePicture');

              } else {
                alert('An error occurred!');
              }
            };

            xhr.send(formData);
          });


          http.get(HOST_PATH + `profile/getData`, function(data){
            data = JSON.parse(data);
            initComponents(data);
          });

          $('#reset-pw-modal').find('.modal-body').empty().attach(new form({
            id: 'resetPwForm',
            action: 'profile/changePassword',
            elements:[
              {
                type: 'password',
                name: 'old-pw',
                placeholder : 'Old Password'
              },
              {
                type: 'password',
                name: 'new-pw',
                placeholder : 'New Password'
              },
              {
                type: 'submit',
                placeholder : 'Reset'
              }
            ],
            onsuccess: function(data){
              $('#reset-pw-modal').modal('toggle');

            }

          }));

          $('#reset-password').click(function(){

            $('#reset-pw-modal').modal('toggle');
          });

          $('#logout-btn').click(function(){

              http.get('/lms/logout');
          });

          function initComponents(data){
            $('#profile-btn span').text(data.fullname);
            for (var key in data) {
              if (data.hasOwnProperty(key)) {
                $('#profile-'+key.toLowerCase()).val(data[key]);
              }
            }
          }

          $('#profile-form').on('submit', function(e){
            e.preventDefault();
            var data = $(this).serialize();
            http.post(HOST_PATH + 'profile/updateProfile', data, function(){
              alert('Success');
            });

          });



        });
        </script>

    </body>


</html>
