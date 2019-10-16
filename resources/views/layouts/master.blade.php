<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Atul Kumar">
    <link rel="icon" href="https://arax-image.s3.ap-south-1.amazonaws.com/email/3PZpJFqANX77ndMmWMUiyubZJv0F9UtQSXRgQkbv.png" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

@section('css')
    <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link href="{{ asset('dist/css/material-dashboard.min.css?v=0.2') }}" rel="stylesheet">
        <link href="{{ asset('dist/demo/demo.css?v=0.4')}}" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-material-datetimepicker.css') }}">
    @show

</head>
<?php flush(); ?>
<body class="">
<div class="search-inside animated bounceInUp loading" >
    <div class="search-overlay"></div>
    <div class="position-center-center">
        <div class="search" style="text-align:center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw" style="font-size:50px;color:#{{str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT)}}"></i>
            <span class="sr-only">please wait</span>
            <h4 class="loadingh1">please wait</h4>
        </div>
    </div>
</div>

<div class="search-ajax animated bounceInUp loading" >
    <div class="search-overlay"></div>
    <div class="position-center-center">
        <div class="search" style="text-align:center">
            <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw" style="font-size:100px;color:#{{str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT)}}"></i>
            <span class="sr-only">please wait</span>
            <h4 class="loadingh1">please wait</h4>
        </div>
    </div>
</div>


<div class="wrapper ">
    @include('sidebar')
    <div class="main-panel">
        <!-- Navbar -->
    @include('navbar')
    <!-- End Navbar -->
        <div class="content">
            <div class="">
                @yield('content')
            </div>
        </div>
        @include('footer')
    </div>
</div>
<!--   Core JS Files   -->
@section('js')
    <script src="{{ asset('dist/js/core/jquery.min.js')}}"></script>
    <script src="{{ asset('dist/js/core/popper.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <script src="{{ asset('dist/js/core/bootstrap-material-design.min.js')}}"></script>
    <script src="{{ asset('dist/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('dist/js/plugins/moment.min.js')}}"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('dist/js/core/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{ asset('dist/js/plugins/sweetalert2.js')}}"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('dist/js/plugins/jquery.validate.min.js')}}"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('dist/js/plugins/jquery.bootstrap-wizard.js')}}"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('dist/js/plugins/bootstrap-selectpicker.js')}}"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('dist/js/plugins/bootstrap-datetimepicker.min.js')}}"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{ asset('dist/js/plugins/jquery.dataTables.min.js')}}"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('dist/js/plugins/bootstrap-tagsinput.js')}}"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('dist/js/plugins/jasny-bootstrap.min.js')}}"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('dist/js/plugins/fullcalendar.min.js')}}"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('dist/js/plugins/jquery-jvectormap.js')}}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('dist/js/plugins/nouislider.min.js')}}"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="{{ asset('dist/js/core.js')}}"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{ asset('dist/js/plugins/arrive.min.js')}}"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script src="{{ asset('dist/js/buttons.js')}}"></script>
    <!-- Chartist JS -->
    <script src="{{ asset('dist/js/plugins/chartist.min.js')}}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('dist/js/plugins/bootstrap-notify.js')}}"></script>

    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('dist/js/material-dashboard.min.js?v=2.1.1')}}" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('dist/demo/demo.js')}}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.15/js/mdb.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <script src="{{ asset('dist/js/tinymce.min.js') }}"></script>
    {{--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=xkds93b1eznt3jr556u240t019664ptrrdgks5nz70rei56w"></script>--}}
    {{--<script src="https://cloud.tinymce.com/5-testing/tinymce.min.js"></script>--}}
    <script>tinymce.init({ selector:'#summernote',height: 200, plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor'
            ],
            valid_children : "+body[style]"
        });</script>
    <script>
        window.onload = ()=> {
            $('.search-inside').hide(0);

        };

        $(window).on('keydown',function(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if(evt.ctrlKey && charCode == 192 ){
                $('.userId').toggle();
            }
        });

        $(document).ready(function() {

            if('{{ session('sidebar-collapsed') }}'){
                setTimeout(function () {
                    $('.main-panel').css('width','100%');
                    $('#collapse-sidebar').text('keyboard_arrow_right')
                },100);
            }
            else{
                setTimeout(function () {
                    $('.sidebar').show();
                    $('#collapse-sidebar').text('keyboard_arrow_left')
                },100);
                $('.main-panel').css('width','calc(100% - 260px)');
            }

            var now = new Date();
            var hrs = now.getHours();
            var msg = "";

            if (hrs >  0) msg = "Morning Sunshine!"; // REALLY early
            if (hrs >  6) msg = "Good Morning";      // After 6am
            if (hrs > 12) msg = "Good Afternoon";    // After 12pm
            if (hrs >= 16) msg = "Good Evening";      // After 4pm
            if (hrs > 22) msg = "Go to bed!";        // After 10pm
            $('.wish').text(msg);

            /*$('form').submit(function(){
             $('.search-inside').show(0);
            });*/

            $("#form").validate();

            $().ready(function() {
                $sidebar = $('.sidebar');

                $sidebar_img_container = $sidebar.find('.sidebar-background');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                    if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                        $('.fixed-plugin .dropdown').addClass('open');
                    }

                }

                $('.fixed-plugin a').click(function(event) {
                    // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .active-color span').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-color', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data-color', new_color);
                    }
                });

                $('.fixed-plugin .background-color .badge').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('background-color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data-background-color', new_color);
                    }
                });

                $('.fixed-plugin .img-holder').click(function() {
                    $full_page_background = $('.full-page-background');

                    $(this).parent('li').siblings().removeClass('active');
                    $(this).parent('li').addClass('active');


                    var new_image = $(this).find("img").attr('src');

                    if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        $sidebar_img_container.fadeOut('fast', function() {
                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $sidebar_img_container.fadeIn('fast');
                        });
                    }

                    if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $full_page_background.fadeOut('fast', function() {
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                            $full_page_background.fadeIn('fast');
                        });
                    }

                    if ($('.switch-sidebar-image input:checked').length == 0) {
                        var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                        var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                        $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                        $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                    }
                });

                $('.switch-sidebar-image input').change(function() {
                    $full_page_background = $('.full-page-background');

                    $input = $(this);

                    if ($input.is(':checked')) {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar_img_container.fadeIn('fast');
                            $sidebar.attr('data-image', '#');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page_background.fadeIn('fast');
                            $full_page.attr('data-image', '#');
                        }

                        background_image = true;
                    } else {
                        if ($sidebar_img_container.length != 0) {
                            $sidebar.removeAttr('data-image');
                            $sidebar_img_container.fadeOut('fast');
                        }

                        if ($full_page_background.length != 0) {
                            $full_page.removeAttr('data-image', '#');
                            $full_page_background.fadeOut('fast');
                        }

                        background_image = false;
                    }
                });

                $('.switch-sidebar-mini input').change(function() {
                    $body = $('body');

                    $input = $(this);

                    if (md.misc.sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        md.misc.sidebar_mini_active = false;

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                    } else {

                        $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                        setTimeout(function() {
                            $('body').addClass('sidebar-mini');

                            md.misc.sidebar_mini_active = true;
                        }, 300);
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);

                });

                $('#collapse-sidebar').on('click',function () {

                    if($('.sidebar').is(':visible')) {
                        $('.sidebar').fadeOut();

                        /*$.ajax({
                            url : '{{ url('sidebar/collapsed/1') }}',
                            success: function (response) {}
                        });*/
                        setTimeout(function () {
                            $('.main-panel').css('width','100%');
                            $('#collapse-sidebar').text('keyboard_arrow_right')
                        },200);
                    }
                    else{
                        setTimeout(function () {
                            $('.sidebar').fadeIn();
                            /*$.ajax({
                                url : '{{ url('sidebar/collapsed/0') }}',
                                success: function (response) {}
                            });*/
                            $('#collapse-sidebar').text('keyboard_arrow_left')
                        },200);
                        $('.main-panel').css('width','calc(100% - 260px)');
                    }
                })
            });

            $('body').find(':input').prop('autocomplete','off');
            if ($(window).width() <= 992) {
                $('.sidebar').fadeOut();
                $('.main-panel').css('width','100%');
            }
        });


    </script>
    <!-- Sharrre libray -->

    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
    </noscript>
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();

        });
    </script>

@show
</body>
</html>
