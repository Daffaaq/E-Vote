@include('Superadmin.layouts.header')
@include('Superadmin.layouts.sidebar')
<div id="layoutSidenav_content">
    <main>
        @yield('content') <!-- Ini adalah tempat untuk konten yang akan digantikan -->
    </main>
</div>
{{-- @include('Superadmin.layouts.content') --}}
@include('Superadmin.layouts.footer')
