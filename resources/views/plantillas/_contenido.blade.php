<div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title"><i class="{{$menuitems[$imenu1]['submenu'][$imenu2]['icon']}}"></i>&nbsp;{{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</h4>
                <div class="card-header-action">
                    <a href="{{route('plantillas.create')}}" title="Añadir plantilla" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa-solid fa-plus"></i>&nbsp;{{$menuitems[$imenu1]['submenu'][$imenu2]['label']}}</a>
                </div>
            </div>
            
            <div class="card-table table-responsive mt-2">            
            @if( $plantillas->isNotEmpty() )
            <table id="dataTableProfesores" class="table table-striped table-bordered dataTable">
                <thead>
                        <tr>
                            <th scope="col">Acciones</th>
                            <th scope="col">id</th>
                            <th scope="col" data-exportable="true">Nombre</th>                            
                            <th scope="col" data-exportable="true">Plantilla</th>                            
                            <th scope="col" data-exportable="true">Creada</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($plantillas as $plantilla)
                        <tr class="">                                
                            <td class="" >                            
                                <a href="{{route('plantillas.edit',['plantilla' => $plantilla->id, 'sidepanel' =>true]) }}" title="Editar" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa-solid fa-pencil"></i></a> 
                                <a href="{{route('plantillas.config',['plantilla' => $plantilla->id]) }}" title="Configurar" class="btn btn-sm btn-info"><i class="fa-solid fa-gears"></i></a> 
                                <button 
                                title="Eliminar registro"
                                type="button" 
                                class="btn btn-sm btn-danger"
                                onclick="openDeleteModalPlantilla({{ $plantilla }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>                                    
                            </td>
                            <td>{{$plantilla->id}}</td>
                            <td>{{$plantilla->nombre}}</td>
                            <td>{{$plantilla->plantilla}}</td>
                            <td>{{$plantilla->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                            <tr><td colspan="5" class="">{{ $emptyMessage }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Modal de confirmación -->
                <div class="modal fade" id="deleteModalPlantilla" tabindex="-1" aria-labelledby="deleteModalPlantillaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalPlantillaLabel">Eliminar Plantilla</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <h2 class="text-xl font-semibold text-red-600 mb-4">¿Estás seguro?</h2>
                            <p class="text-gray-700 mb-6">Esta acción no se puede deshacer.</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('plantillas.destroy',$plantilla)}}" method="POST" class="inline" id="deleteFormPlantilla">
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
                    function openDeleteModalPlantilla(plantilla) {   
                        
                        //console.log("plantilla",plantilla);
                        //console.log(plantilla.id)

                        /*
                        */
                        const modal = new bootstrap.Modal(document.getElementById('deleteModalPlantilla'));
                        const form = document.getElementById('deleteFormPlantilla');                                                
                        modal.show();
                        
                        form.action = `/plantillas/${plantilla.id}`; // Asegurate de que la ruta coincida con la definida en web.php                            
                    }
                </script>
                @else
                    <p class="mb-3 text-gray-500 dark:text-gray-400">
                        {{$emptyMessage}}
                    </p>
                @endif
            </div>
    </div>