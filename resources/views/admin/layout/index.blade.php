<?php ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin</title>

    <!-- Core CSS - Include with every page -->
    <link href="/asset/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/asset/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Tables -->
    <link href="/asset/admin/css/plugins/dataTables/dataTables.bootstrap.css" 
    rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="/asset/admin/css/sb-admin.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        <!-- navbar  !--->
        @include('admin.layout.header')
        <!-- End Header -->

        <!-- Page Content -->
        @yield('content')
        <!-- End Page Content -->
    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="/asset/admin/js/jquery-1.10.2.js">
    </script>
    <script src="/asset/admin/js/bootstrap.min.js">
    </script>
    <script src="/asset/admin/js/plugins/metisMenu/jquery.metisMenu.js">
    </script>

    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="/asset/admin/js/plugins/dataTables/jquery.dataTables.js">
    </script>
    <script src="/asset/admin/js/plugins/dataTables/dataTables.bootstrap.js">
    </script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="/asset/admin/js/sb-admin.js">
    </script>

    <!-- ckeditor -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
</body>

</html>