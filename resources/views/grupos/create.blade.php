
    @php
        $imenu1 = 2;
        $imenu2 = 10;
    @endphp
    
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title"><i class="{{$menuitems[$imenu1]['submenu'][$imenu2]['icon']}}"></i>&nbsp;Nuevo {{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</h4>
            <div class="card-header-action">
                <a href="#" class="btn btn-sm btn-outline-danger close-ajax-sidepanel"><i class="fa-solid fa-ban"></i>&nbsp;Cancelar</a>
            </div>
        </div>

        <div class="card-body ">
            @include('grupos.partials.form')
        </div>

    </div>
