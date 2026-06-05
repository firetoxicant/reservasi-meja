<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'AYAM BOLO BEBEK')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/tailwind.output.css" />
    <link rel="stylesheet" href="{{asset('assets/izitoast/css/iziToast.min.css')}}">
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="../../assets/js/init-alpine.js"></script>
    <script src="{{asset('assets/izitoast/js/iziToast.min.js')}}"></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen}"
    >
      <!-- Desktop sidebar -->
      @include('layouts.sidebar')
      <!-- Mobile sidebar -->
      <!-- Backdrop -->
      @include('layouts.mobile-sidebar')
      <div class="flex flex-col flex-1">
        @include('layouts.topbar')
        <main class="h-full pb-16 overflow-y-auto">
          @yield('content')
          <!-- <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Blank
            </h2>
          </div> -->
        </main>
        @if(session('success'))
        <script>
          iziToast.success({
          title: 'Berhasil',
          message: '{{session('success')}}',
          position: 'topRight'
          });
        </script>
        @elseif(session('error'))
        <script>
          iziToast.error({
          title: 'Gagal',
          message: '{{session('error')}}',
          position: 'topRight'
          });
        </script>
        @endif
        @include('layouts.footer')