<?php ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog Demo</title>

    <!-- Core CSS - Include with every page -->
    <link href="/asset_admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/asset_admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Tables -->
    <link href="/asset_admin/css/plugins/dataTables/dataTables.bootstrap.css" 
    rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="/asset_admin/css/sb-admin.css" rel="stylesheet">

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
    <script src="/asset_admin/js/jquery-1.10.2.js">
    </script>
    <script src="/asset_admin/js/bootstrap.min.js">
    </script>
    <script src="/asset_admin/js/plugins/metisMenu/jquery.metisMenu.js">
    </script>

    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="/asset_admin/js/plugins/dataTables/jquery.dataTables.js">
    </script>
    <script src="/asset_admin/js/plugins/dataTables/dataTables.bootstrap.js">
    </script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="/asset_admin/js/sb-admin.js">
    </script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>

</body>

</html>
