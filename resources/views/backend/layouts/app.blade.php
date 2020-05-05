<!DOCTYPE html>
@langrtl
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'Laravel Boilerplate')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(asset('css/backend.css')) }}
    {{ style('https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css') }}
    {{ style('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}
    {{ style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css') }}
    

    @stack('after-styles')
</head>

{{--
     * CoreUI BODY options, add following classes to body to change options
     * // Header options
     * 1. '.header-fixed'					- Fixed Header
     *
     * // Sidebar options
     * 1. '.sidebar-fixed'					- Fixed Sidebar
     * 2. '.sidebar-hidden'				- Hidden Sidebar
     * 3. '.sidebar-off-canvas'		    - Off Canvas Sidebar
     * 4. '.sidebar-minimized'			    - Minimized Sidebar (Only icons)
     * 5. '.sidebar-compact'			    - Compact Sidebar
     *
     * // Aside options
     * 1. '.aside-menu-fixed'			    - Fixed Aside Menu
     * 2. ''			    - Hidden Aside Menu
     * 3. '.aside-menu-off-canvas'	        - Off Canvas Aside Menu
     *
     * // Breadcrumb options
     * 1. '.breadcrumb-fixed'			    - Fixed Breadcrumb
     *
     * // Footer options
     * 1. '.footer-fixed'					- Fixed footer
--}}
<body class="app header-fixed sidebar-fixed aside-menu-off-canvas sidebar-lg-show">
    @include('backend.includes.header')

    <div class="app-body">
        @include('backend.includes.sidebar')

        <main class="main">
            @include('includes.partials.read-only')
            @include('includes.partials.logged-in-as')
            {!! Breadcrumbs::render() !!}

            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="content-header">
                        @yield('page-header')
                    </div><!--content-header-->

                    @include('includes.partials.messages')
                    @yield('content')
                </div><!--animated-->
            </div><!--container-fluid-->
        </main><!--main-->

        @include('backend.includes.aside')
    </div><!--app-body-->

    @include('backend.includes.footer')

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(asset('js/manifest.js')) !!}
    {!! script(asset('js/vendor.js')) !!}
    {!! script(asset('js/backend.js')) !!}
    {!! script(asset('backend/jquery-validation/js/jquery.validate.min.js')) !!}
    {!! script(asset('backend/jquery-validation/js/additional-methods.min.js')) !!}
    {!! script('https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js') !!}
    {!! script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js') !!}
    {!! script('https://cdn.jsdelivr.net/npm/sweetalert2@9') !!}

    <script>
        $(document).ready(function(e)
        {
            $("body").on("click", ".changeStatus", function(e)
            {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change the this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2eb85c',
                    cancelButtonColor: '#e55353',
                    confirmButtonText: 'Yes, change it!'
                    }).then((result) => {
                    if (result.value) {

                        $.get($(this).data("rowurl"), function(result)
                                    {
                                        Swal.fire(
                        'Success!',
                        '',
                        'success'
                        ).then(()=>{
                                        window.location.reload();
                        })
                                    },'JSON');

                        
                    }
            });

        });

        $("body").on("click", ".removeRow", function(e)
            {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2eb85c',
                    cancelButtonColor: '#e55353',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {

                        $.ajax(

    {

        url: $(this).data("rowurl"),

        type: 'DELETE',

        data: {


            "_token": '{{ csrf_token() }}'

        },

        success: function (){

            console.log("it Works");

        }

    });

                    //     $.post($(this).data("rowurl"),{_token:'{{ csrf_token() }}',_method:'DELETE'}, function(result)
                    //                 {
                    //                     Swal.fire(
                    //      'Success!',
                    //      '',
                    //      'success'
                    //      ).then(()=>{
                    //                      //window.location.reload();
                    //      })
                    // },'JSON');                        
                    }
            });
                
        });

    });
</script>

    @stack('after-scripts')
</body>
</html>
