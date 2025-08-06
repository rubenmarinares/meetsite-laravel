<x-app-layout>

    @php
        $imenu1 = 2;
        $imenu2 = 0;
        $tab=intval(request()->get('tab',0));
    @endphp
    
    <x-slot name="sidemenu">
        @include('partials.sidemenu')             
    </x-slot>

    <x-slot name="menu">
        @include('partials.menu')             
    </x-slot>

    <div class="page-header d-print-none mb-3">
    <div class="">
      <div class="row g-2  align-items-center">
        <div class="col">          
          <h2 class="page-title">
            {{$academia->academia}} 
          </h2>
        </div>

      </div>
    </div>
  </div>


  

  <div class="row">
    <div class="col-12">      
      <div class="card">
        <div class="card-body">          
            <ul class="nav nav-tabs invoice-tab border-bottom mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link  @if($tab==0) active @endif" id="academias-tab-0" data-bs-toggle="tab" data-bs-target="#academias-tab-0-pane" type="button" role="tab" aria-controls="analytics-tab-0-pane" aria-selected="true">
                        <span class="d-flex align-items-center gap-2"><i class="fas fa-school"></i>Academia</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($tab==1) active @endif" id="academias-tab-1" data-bs-toggle="tab" data-bs-target="#academias-tab-1-pane" type="button" role="tab" aria-controls="analytics-tab-1-pane" aria-selected="false" tabindex="-1">
                        <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-person-chalkboard"></i>Profesores <span class="badge text-bg-primary">{{ count($profesores) ?? 0 }}</span></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($tab==2) active @endif" id="academias-tab-2" data-bs-toggle="tab" data-bs-target="#academias-tab-2-pane" type="button" role="tab" aria-controls="analytics-tab-2-pane" aria-selected="false" tabindex="-1">
                      <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-graduation-cap"></i>Alumnos <span class="badge text-bg-primary">{{ count($alumnos) ?? 0 }}</span></span>
                  </button>
                </li>
                
            </ul>
            
            <div class="tab-content">
              <!--PANEL ACADEMIAS-->
              <div class="tab-pane fade @if($tab==0) active show @endif" id="academias-tab-0-pane" role="tabpanel" aria-labelledby="academias-tab-0" tabindex="0">

                <div class="card mt-2">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title"><i class="fas fa-school"></i>&nbsp;Academia</h4>
                    <div class="card-header-action">
                      <a href="{{route('academias.edit',$academia)}}" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa-solid fa-pencil"></i>&nbsp;Editar </a>
                    </div>                    
                  </div>
                  <div class="card-body">
                    <p>Academia: {{$academia->academia}} {{$academia->id}}</p>                    
                  </div>
                </div>
              </div>
              <!--FIN PANEL ACADEMIAS-->
              <!--PANEL PROFESORES-->
              <div class="tab-pane fade  @if($tab==1) active show @endif " id="academias-tab-1-pane" role="tabpanel" aria-labelledby="academias-tab-1" tabindex="1">
                <div class="card mt-2">                  
                  @include('profesores.index')
                </div>
              </div>
              <!-- FIN PANEL PROFESORES-->
              <!--PANEL ALUMNOS-->
              <div class="tab-pane fade  @if($tab==2) active show @endif " id="academias-tab-2-pane" role="tabpanel" aria-labelledby="academias-tab-2" tabindex="2">
                <div class="card mt-2">                  
                  @include('alumnos.index')
                </div>
              </div>
              <!--FIN PANEL ALUMNOS-->





        </div>
      </div>
    </div>
  </div>




</x-app-layout>