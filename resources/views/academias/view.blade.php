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

          {{ session('academia_set') }}
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
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($tab==3) active @endif" id="academias-tab-3" data-bs-toggle="tab" data-bs-target="#academias-tab-3-pane" type="button" role="tab" aria-controls="analytics-tab-3-pane" aria-selected="false" tabindex="-1">
                      <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-book-bookmark"></i>Asignaturas <span class="badge text-bg-primary">{{ count($asignaturas) ?? 0 }}</span></span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($tab==4) active @endif" id="academias-tab-4" data-bs-toggle="tab" data-bs-target="#academias-tab-4-pane" type="button" role="tab" aria-controls="analytics-tab-4-pane" aria-selected="false" tabindex="-1">
                      <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-chalkboard-user"></i>Aulas <span class="badge text-bg-primary">{{ count($aulas) ?? 0 }}</span></span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($tab==5) active @endif" id="academias-tab-5" data-bs-toggle="tab" data-bs-target="#academias-tab-5-pane" type="button" role="tab" aria-controls="analytics-tab-5-pane" aria-selected="false" tabindex="-1">
                      <span class="d-flex align-items-center gap-2"><i class="fas fa-user-tag"></i>Clientes <span class="badge text-bg-primary">{{ count($clientes) ?? 0 }}</span></span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($tab==6) active @endif" id="academias-tab-6" data-bs-toggle="tab" data-bs-target="#academias-tab-6-pane" type="button" role="tab" aria-controls="analytics-tab-6-pane" aria-selected="false" tabindex="-1">
                      <span class="d-flex align-items-center gap-2"><i class="fas fa-folder"></i>Grupos <span class="badge text-bg-primary">{{ count($grupos) ?? 0 }}</span></span>
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
                      <a href="{{route('academias.edit',$academia)}}" class="btn btn-sm btn-primary"><i class="fa-solid fa-pencil"></i>&nbsp;Editar </a>
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
              <!--PANEL ASIGNATURAS-->
              <div class="tab-pane fade  @if($tab==3) active show @endif " id="academias-tab-3-pane" role="tabpanel" aria-labelledby="academias-tab-3" tabindex="3">
                <div class="card mt-2">                  
                  @include('asignaturas.index')
                </div>
              </div>
              <!--FIN PANEL ASIGNATURAS-->
              <!--PANEL AULAS-->
              <div class="tab-pane fade  @if($tab==4) active show @endif " id="academias-tab-4-pane" role="tabpanel" aria-labelledby="academias-tab-4" tabindex="4">
                <div class="card mt-2">                  
                  @include('aulas.index')
                </div>
              </div>
              <!--FIN PANEL AULAS-->

              <!--PANEL CLIENTES-->
              <div class="tab-pane fade  @if($tab==5) active show @endif " id="academias-tab-5-pane" role="tabpanel" aria-labelledby="academias-tab-5" tabindex="5">
                <div class="card mt-2">                  
                  @include('clientes.index')
                </div>
              </div>
              <!--FIN PANEL CLIENTES-->

              <!--PANEL CLIENTES-->
              <div class="tab-pane fade  @if($tab==6) active show @endif " id="academias-tab-6-pane" role="tabpanel" aria-labelledby="academias-tab-6" tabindex="6">
                <div class="card mt-2">                  
                  @include('grupos.index')
                </div>
              </div>
              <!--FIN PANEL CLIENTES-->

        </div>
      </div>
    </div>
  </div>
</x-app-layout>