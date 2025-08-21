<div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title"><i class="{{$menuitems[$imenu1]['submenu'][$imenu2]['icon']}}"></i>&nbsp;{{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</h4>
                <div class="card-header-action">
                    <a href="{{route('profesores.create')}}" title="Añadir profesor" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa-solid fa-plus"></i>&nbsp;{{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</a>
                </div>
            </div>
            
            <div class="card-table table-responsive mt-2">            
            @if( $profesores->isNotEmpty() )
            <table id="dataTableProfesores" class="table table-striped table-bordered dataTable">
                <thead>
                        <tr>
                            <th scope="col">Action</th>
                            <th scope="col">id</th>
                            <th scope="col" data-exportable="true">Apellidos</th>
                            <th scope="col" data-exportable="true">Nombre</th>
                            <th scope="col" data-exportable="true">email</th>
                            <th scope="col" data-exportable="true">Academias</th>
                            <th scope="col" data-exportable="true">Creado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($profesores as $profesor)
                        <tr class="">                                
                            <td class="" >                            
                                <a href="{{route('profesores.edit',['profesor' => $profesor->id, 'sidepanel' =>true]) }}" title="Editar" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa-solid fa-pencil"></i></a> 
                                <button 
                                title="Eliminar registro"
                                type="button" 
                                class="btn btn-sm btn-danger"
                                onclick="openDeleteModalProfesor({{$profesor}})">
                                <i class="fa-solid fa-trash"></i>
                            </button>                                    
                            </td>
                            <td>{{$profesor->id}}</td>
                            <td>{{$profesor->apellidos}}</td>
                            <td>{{$profesor->nombre}}</td>
                            <td>{{$profesor->email}}</td>                        
                            <td> @foreach ($profesor->academiasRelation as $academia)
                                    {{ $academia->academia }}
                                    @if (!$loop->last), @endif
                                    @endforeach
                            </td>                        
                            <td>{{$profesor->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                            <tr><td colspan="5" class="">{{ $emptyMessage }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Modal de confirmación -->
                <div class="modal fade" id="deleteModalProfesor" tabindex="-1" aria-labelledby="deleteModalProfesorLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalProfesorLabel">Eliminar Profesor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <h2 class="text-xl font-semibold text-red-600 mb-4">¿Estás seguro?</h2>
                            <p class="text-gray-700 mb-6">Esta acción no se puede deshacer.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('profesores.destroy',$profesor)}}" method="POST" class="inline" id="deleteFormProfesor">
                                @csrf
                                @method('DELETE')
                                <div class="flex justify-center gap-4">
                                <input type="text" name="redirect_to" value="{{ url()->current() }}">

                                <button type="submit" class="btn btn-danger">
                                    Sí, eliminar
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>                                                        
                            </div>
                        </div>
                    </div>
                </div>                    
                <!--FIN MODAL CONFIRMACIÓN-->            
                    <script>
                    function openDeleteModalProfesor(profesor) {   
                        //console.log("formaction")                                             
                        const modal = new bootstrap.Modal(document.getElementById('deleteModalProfesor'));
                        const form = document.getElementById('deleteFormProfesor');                                                
                        modal.show();
                        form.action = `/profesores/${profesor.id}`; // Asegurate de que la ruta coincida con la definida en web.php    
                        //modal.classList.remove('hidden');
                        //modal.classList.add('flex');
                    }
                </script>
                @else
                    <p class="mb-3 text-gray-500 dark:text-gray-400">
                        {{$emptyMessage}}
                    </p>
                @endif
            </div>
    </div>