<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{asset('asset/bootstrap/css/bootstrap.min.css')}}">
        <script src="{{asset('asset/jq/jquery-3.3.1.min.js')}}"></script>
        <script src="{{asset('asset/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('asset/plugin/swal/sweetalert2.all.js')}}"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (is_user_logged_in())
                <div class="top-right links">
                   <p>Logged</p>
                </div>
            @else
                <div class="top-right links">
                    <p>not logged in</div>
            @endif
            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
                <button id="testAjax" class="btn btn-primary">Click</button>
                <button id="getPost" class="btn btn-primary">Get data post</button>

                <h2>Modal Example</h2>
                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Signin</button>
                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content col-md-12" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Please type your info</h4>
                            </div>
                            <form action="" id="formSignIn">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="user_login" placeholder="Your Email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="user_password" placeholder="Your Password">
                                </div>
                            </form>
                            <div class="modal-body">
                                <button id="singIn" class="btn btn-primary">SignIn</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
    <script >
        $('#testAjax').click(function () {
            $.ajax({
                url:"<?php echo admin_url('admin-ajax.php')?>",
                method: 'POST',
                data:{
                    action : "handler_laravel",
                    name : "test",
                    method :'GetUser',
                },
                dataType : 'json',
                success : function (data) {
                    console.log(data);
                    $.each(data, function(i,item) {
                        console.log(item);
                    });
                }
            });
        });
        $('#getPost').click(function () {
            $.ajax({
                url:"<?php echo admin_url('admin-ajax.php')?>",
                method: 'POST',
                data:{
                    action : "handler_laravel",
                    name : "test",
                    method :'GetPost',
                },
                dataType : 'json',
                success : function (data) {
                    console.log(data);
                    $.each(data, function(i,item) {
                        console.log(item);
                    });
                }
            });
        });
        $('#singIn').click(function () {
            $.ajax({
                        url:"<?php echo admin_url('admin-ajax.php')?>",
                        method: 'POST',
                        data:{
                            action : "handler_laravel",
                            name : "test",
                            method :'SignIn',
                            user_login : $("input[name='user_login']").val(),
                            user_password : $("input[name='user_password']").val()
                        },
                        dataType : 'json',
                        beforeSend : function () {
                            swal({
                                title :  'singing'
                            });
                            swal.showLoading();
                        },
                        success : function (data) {
                            if (data.errors) {
                                swal({
                                    title : 'Error',
                                    type:'warning',
                                    html : data.mess
                                });
                            } else{
                                swal({
                                    title : 'Success',
                                    type:'success',
                                    html : data.mess
                                }).then( function () {
                                        location.reload()
                                    }
                                );
                            }
                        }
                    });
        });
    </script>
</html>
