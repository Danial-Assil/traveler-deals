<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $website_title }} &mdash; {{ $page_title }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/dash/css/chocolat.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/dash/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/dash/css/components.css') }}">
  @if( app()->getLocale() == 'ar')
  <link rel="stylesheet" href="{{ asset('assets/dash/css/rtl.css') }}">
  @endif
  <link rel="stylesheet" href="{{ asset('assets/dash/css/custom.css') }}">
  @if( app()->getLocale() == 'ar')
  <link rel="stylesheet" href="{{ asset('assets/dash/css/custom-rtl.css') }}">
  @endif
</head>

<body>
  <div id="app">

    <div class="main-wrapper">

      @include('dash.includes.header')
      @include('dash.includes.sidebar')

      @if(in_array('delete',$module_actions ))
      @include('dash.components.delete-item-modal')
      @endif
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @if($module_name != 'homes')
          <div class="section-header">
            <h1>{{ trans($module_name.'.module_title') }}</h1>
            @if( in_array('create',$module_actions ) )
            <div class="section-header-breadcrumb">
              <a class="btn btn-md btn-primary" href="{{ route($module_name.'.create') }}">{{ trans($module_name.'.new_item') }}</a>
            </div>
            @endif
          </div>
          @endif
          @yield('content')
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 <div class="bullet"></div> Developed By <a target="_blank" href="https://www.linkedin.com/in/hanan-al-slaiman-05a425163/">Hanan Al-Slaiman</a>
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('assets/dash/js/stisla.js') }}"></script>
  <script src="{{ asset('assets/dash/js/jquery.chocolat.min.js') }}"></script>

  <!-- JS Libraies -->

  <!-- <script src="{{ asset('assets/dash/js/page/bootstrap-modal.js') }}"></script> -->
  <!-- Template JS File -->
  <script src="{{ asset('assets/dash/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/dash/js/custom.js') }}"></script>
  <script src="{{ asset('assets/dash/js/requests.js') }}"></script>

  <!-- Page Specific JS File -->
  <!--   
  <script src="{{ asset('assets/dash/node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/dash/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/dash/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script> -->

</body>

</html>