<!DOCTYPE html>
<html lang="en">



@include('layouts.head')


<body class="fixed-left">
    @include('layouts.toopbar')


    @include('layouts.sidebar')

    @if (session('success'))
        <div id="successAlert" class="alert alert-success" style="position: fixed; top: 80px; right: 470px;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div id="errorAlert" class="alert alert-danger" style="position: fixed; top: 80px; right: 470px;">
            {{ session('error') }}
        </div>
    @endif
    @yield('content')

    @include('layouts.footer')


    <script>
        // Auto-dismiss success message after 4 seconds
        @if (session('success'))
            setTimeout(function() {
                document.getElementById('successAlert').style.display = 'none';
            }, 4000);
        @endif

        // Auto-dismiss error message after 4 seconds
        @if (session('error'))
            setTimeout(function() {
                document.getElementById('errorAlert').style.display = 'none';
            }, 4000);
        @endif
    </script>


</body>
