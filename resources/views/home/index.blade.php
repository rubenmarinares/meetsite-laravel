<x-app-layout>
    
    @php
        $imenu1 = 'home';
    @endphp

    <x-slot name="sidemenu">
        @include('partials.sidemenu')             
    </x-slot>

    <x-slot name="menu">
        @include('partials.menu')             
    </x-slot>
                           

    @php
    //$academias = session('user_academias');
    @endphp



@if($academias)
    
    <div class="row">
        @foreach($academias as $academia)
            <div class="col-sm-6 col-lg-4 col-xxl-4">
                <div class="card border">
                    <div class="card-body p-2">
                        <!--<div class="position-relative">
                        <img src="../assets/images/admin/img-course-1.png" alt="img" class="img-fluid w-100">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge text-bg-light text-uppercase">Free</span>
                        </div>
                        </div>-->
                        <ul class="list-group list-group-flush my-2">
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <h6 class="mb-1">{{$academia->academia}}</h6>
                                <!--<p class="mb-0 f-w-600"><i class="fas fa-star text-warning"></i> 4.8</p>-->
                            </div>
                            <div class="flex-shrink-0">
                                @if (session('academia_set')->id==$academia->id) 
                                <a href="#" class="btn btn-xs btn-link-secondary" title="Seleccionada"><i class="fas fa-check f-20 text-success"></i></a>
                                @else
                                <a href="#" class="btn btn-xs btn-link-secondary">No seleccionado</a>
                                @endif
                                <!--<a href="#" class="btn btn-xs btn-link-secondary">No seleccionado</a>-->                                
                            </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0">Estado</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0"> {{ (int)$academia->status==1?'Activa':'Inactiva' }}</p>
                            </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0">Administrador{{$academia->users->count()>0?'es':''}}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@foreach ($academia->users as $user)<button class="btn btn-sm btn-outline-secondary">{{ $user->name }}</button> @endforeach</p>
                            </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0">Profesores</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">{{$academia->academia_profesores}}</p>
                            </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0">Alumnos</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">{{$academia->academia_alumnos}}</p>
                            </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-2">
                                <p class="mb-0">Aulas</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">{{$academia->academia_aulas}}</p>
                            </div>
                            </div>
                        </li>
                        </ul>
                            <!--
                                <a class="btn btn-sm btn-outline-primary mb-2" href="{{route('academias.view',$academia)}}">Ver academia</a>
                            -->
                            <form action="{{ route('academia.set', $academia) }}" method="POST"> 
                            @csrf               
                            <button type="submit" class="btn btn-sm btn-outline-primary mb-2" ><span>Ver Academia</span></button>
                            </form>

                    </div>
                </div>
            </div> 
            
        @endforeach
        </div>
@endif
    


</x-app-layout>