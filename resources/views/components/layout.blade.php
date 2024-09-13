<!DOCTYPE html>
<html lang="en">
@include('components.pagebody.head')

<body class="sb-nav-fixed">
    @include('components.pagebody.navbar')
    <div id="layoutSidenav">
        @include('components.sidebar.sidebaritem')
        <div id="layoutSidenav_content">
            <main>
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show alertbox" role="alert">
                    {{ session('success') }}<span id="alertmessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show alertbox" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
                @include('components.pagebody.header')


                {{$slot}}

            </main>
            @include('components.pagebody.footer')
        </div>
    </div>
    @include('components.pagebody.script')
</body>

</html>
