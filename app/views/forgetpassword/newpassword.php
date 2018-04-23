    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Forget Password</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="/lms/assets/dist/img/ico/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="/lms/assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="/lms/assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="/lms/assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="/lms/assets/dist/img/ico/apple-touch-icon-144-precomposed.png">

        <!-- Bootstrap -->
        <link href="/lms/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- Bootstrap rtl -->
        <!--<link href="assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>-->
        <!-- Pe-icon-7-stroke -->
        <link href="/lms/assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <!-- style css -->
        <link href="/lms/assets/dist/css/styleBD.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style rtl -->
        <!--<link href="assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>-->


    </head>
    <body background="dp.jpg">
        <!-- Content Wrapper -->
        <div class="login-wrapper">
            <div class="container-center">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="view-header">
                            <div class="header-icon">
                                <i class="pe-7s-unlock"></i>
                            </div>
                            <div class="header-title">
                                <h3>Reset</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form id="resetform" method="POST" novalidate>
                            <div class="form-group">
                                
                                <input type="hidden" value="<?php echo $data; ?>" name="token">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" placeholder="Enter new password" title="Please enter new password" required="" value="" name="password" id="password" class="form-control" autofocus>
                                
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="password-re">Reenter Password</label>
                                <input type="password" placeholder="Enter new password" title="Please enter new password" required="" value=""  id="password-re" class="form-control">
                                
                            </div>
                            
                            <div>
                                <button class="btn btn-primary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <!-- jQuery -->
        <script src="/lms/assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="/lms/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/lms/assets/dist/js/common.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function () {

                // http.get("controller/controller.php?m=user&a=checkLogin", function(){
                //     window.location.replace('index.html');
                // });

                $('#resetform').submit(function(e){

                    e.preventDefault();
                    if($('#password').val() == $('#password-re').val()){
                        var data = $('#resetform').serialize();

                        http.post('/lms/forgotpassword/reset', data);
                    }
                    else{
                        alert('Password do not match');
                        $('#resetform').reset();
                    }
                });
            });
        </script>

    </body>
</html>
