<!DOCTYPE html>

<html lang={{ str_replace('_', '-', app()->getLocale()) }}>
<head>
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'meetsite laravel') }}</title>


<!-- [Template CSS Files] -->
    
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" id="main-style-link" >
    <link rel="stylesheet" href="{{asset('assets/css/style-preset.css')}}" >
    

    <!--FONT AWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- BOOTSTRAP-->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    -->

    <!-- [Jquery] [DataTables] -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css" />
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js" ></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js" ></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/localization/messages_es.min.js" integrity="sha512-Kcb2OYCSBj5/343s73G4ue17xTxHhWeLwfzE8gDQh9EAbWyEt8Jh6cNgGt86XgjS0JRzIlARtVPLa+o57+HQ2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.bootstrap5.min.css" />
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
    <!-- Datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css')}}">
    <script src="{{ asset('assets/js/plugins/datepicker-full.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/locales/es.js"></script>



    <!--ESTO DEBERÍA IR EN FOOTER-->

    <script src="{{ asset('assets/js/plugins/popper.min.js')}}"></script>
    
    <!-- Required Js -->
    <script src="{{ asset ('assets/js/plugins/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.js')}}"></script>
    <script src="{{asset('assets/js/plugins/feather.min.js')}}"></script>

    <!--<script src="{{asset('assets/js/fonts/custom-font.js')}}"></script>-->
    <!--<script src="{{asset('assets/js/plugins/validate/jquery.validate.min.js')}}"></script>-->
    <!--<script src="{{asset('assets/js/plugins/validate/localization/messages_es.min.js')}}"></script>-->

    <style>

    /*SELECT ACADEMIAS*/

    .select-academia{
      width:100% !important;
      color: #ffffff !important;
    }
    .select-academia:hover{background-color: #0A879F !important;
                            color: #ffffff !important;
                            border:1px solid #fff;
                            padding:0 5px 0 5px;
                          }     
    .select-academia::before{background:none !important;}


    
  .offcanvas, .offcanvas-xxl, .offcanvas-xl, .offcanvas-lg, .offcanvas-md, .offcanvas-sm{
    --bs-offcanvas-width: 480px;
  }

  .datatable-table td, .datatable-table th, .table td, .table th {
     white-space:normal;
  }

  .pc-header .header-wrapper {
    background-color: #0A879F;
    color:#fff;
  }
  :root {
  --pc-header-color: #fff;

  }
  .offcanvas, .offcanvas.offcanvas-end{
    width: 70%;
  }
  .pc-sidebar{
    background-color: #fff !important;
  }
  .card{
    border-radius: 4px !important;
  }
  .dataTables_length, .dataTables_info{
    padding-left: 1em;
  }
  .dataTables_filter{
    padding-right: 1em;
  }
  .form-label {
    margin-bottom: 0.3rem;
  }
  .btn-sm{font-size:12px;}


  .card-table{padding:1rem;}

  .error{color:red;}
.select2-container--bootstrap-5{
  border: 1px solid #bec8d0;
  padding: 2px 2px;
  border-radius: 8px;
  }
  .select2-selection__choice{
    display: inline-block;
      vertical-align: middle;
      border-radius: 8px;
      padding: 4px 10px;
      font-size:0.8rem;      
      margin-right: 3.75px;
      margin-bottom: 3.75px;
      background-color: #0A879F !important;
      border: 1px solid #000 !important;
      padding:5px !important;
      color: #fff;
      word-break: break-all;
      box-sizing: border-box;
  }
  
    .select2-selection__rendered{
    flex-wrap: wrap;
    display: inline-flex !important;
    list-style:none !important;
    }

    .select2-selection__choice__remove{
    color:#fff !important;
    font-size:1rem;

    }


    /* Eliminar esquinas redondeadas de los eventos */
    .fc-event {
        border-radius: 0 !important; /* Quita el redondeo */
    }

    /* Eliminar redondeo en eventos específicos de la vista mensual */
    .fc-daygrid-event {
        border-radius: 0 !important; /* Quita el redondeo */
    }

    .fc-day-today {
    background-color:lightgray !important; 
    color: white !important; /* Opcional: cambiar color del texto */
    background-image: none !important; /* Opcional: quitar imagen de fondo */
    }


    </style>


</head>


<body  class="" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="null" >

        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
            <div class="loader-fill"></div>
            </div>
        </div>
    
        <!--PAGE SIDEMENU-->
        @isset($sidemenu)        
                {{ $sidemenu }}            
        @endisset

        <!--PAGE MENU-->
        @isset($menu)            
                {{ $menu }}            
        @endif


        @isset($sidemenu)
          <div class="pc-container">
              <div class="pc-content">
        @endisset
            <!--PAGE CONTENT--> 
            @if (session('success_messages'))
              @foreach (session('success_messages') as $message)
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message-{{ $loop->index }}">
                    <i class="fa-solid fa-circle-check"></i> {{ $message }}                    
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endforeach
            @endif
            @if (session('error_messages'))
              @foreach (session('error_messages') as $message)
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-message-{{ $loop->index }}">
                      <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              @endforeach
            @endif 
            {{ $slot }}        
        @isset($sidemenu)
            </div>
        </div>
        @endisset



    <script>
        document.querySelectorAll(".dataTable").forEach((item) => {
            $(item).DataTable({        
                autoWidth: false,
                columnDefs: [
                    { width: '100px', targets: 0 } // Columna 0 (primera)
                ],
                language: {url: 'https://cdn.datatables.net/plug-ins/2.1.4/i18n/es-ES.json'}          
            }); 
        });

        menu_click();



        //$(".select2").select2();

        $(document).ready(function() {
           $(".select2").select2({
              theme: 'bootstrap-5' // Usa el tema de Bootstrap 5
          });
});
    </script>
</body>

</html>