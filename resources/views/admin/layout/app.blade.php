<!DOCTYPE html>
<html lang="en">

@include('admin.layout.head')

<body>
    <div class="container-fluid position-relative d-flex flex-column min-vh-100 p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @include('admin.layout.sidebar')

        <!-- Content Start -->
        <div class="content flex-grow-1">
            @includeIf('admin.layout.navbar')

            <!-- Main Content Start -->
            @yield('content')
            <!-- Main Content End -->
        </div>
        <!-- Content End -->

        <div class="content content-2">
            @include('admin.layout.footer')
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    @include('admin.layout.js')

    @stack('scripts')
</body>

</html>
