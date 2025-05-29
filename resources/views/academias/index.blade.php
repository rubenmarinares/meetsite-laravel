<x-app-layout>

    @php
        $imenu1 = 2;
        $imenu2 = 0;
    @endphp
    
    <x-slot name="sidemenu">
        @include('partials.sidemenu')             
    </x-slot>

    <x-slot name="menu">
        @include('partials.menu')             
    </x-slot>
    
    
         
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title"><i class="fas fa-school"></i>&nbsp;Academias</h4>
            <div class="card-header-action">
                <a href="{{route('academias.create')}}" class="btn btn-sm btn-primary ajax-sidepanel"><i class="fa-solid fa-plus"></i>&nbsp;Nueva</a>
            </div>
        </div>
        
        <div class="card-table table-responsive mt-2">            
        @if($academias)
        <table id="tablelist" class="table table-striped table-bordered dataTable">
            <thead>
                    <tr>
                        <th scope="col" class="" >Action</th>
                        <th scope="col" class="">Academia</th>
                        <th scope="col" class="">Dirección(Localidad)</th>                    
                        <th scope="col" class="">Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($academias as $academia)
                    <tr class="">                                
                        <td class="" >
                            <a href="{{route('academias.edit',$academia->id)}}" title="Editar" class="btn btn-sm btn-primary"><i class="fa-solid fa-pencil"></i></a> 
                            <button 
                                title="Eliminar registro"
                                type="button" 
                                class="btn btn-sm btn-danger"
                                onclick="openDeleteModal({{$academia}})">
                                <i class="fa-solid fa-trash"></i>
                            </button>                                    
                        </td>
                        <td>{{$academia->academia}}</td>
                        <td>{{$academia->direccion}} ({{$academia->localidad}})</td>
                        <td>{{$academia->created_at->format('d/m/Y') }}</td>
                        
                    </tr>
                    @empty
                        <tr><td colspan="5" class="">{{ $emptyMessage }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            <!--<div class="col-md-12">
                
            </div>  
        -->
            <!-- Modal de confirmación -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Eliminar Academia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-xl font-semibold text-red-600 mb-4">¿Estás seguro?</h2>
                        <p class="text-gray-700 mb-6">Esta acción no se puede deshacer.</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{route('academias.destroy',$academia)}}" method="POST" class="inline" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-center gap-4">
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
                function openDeleteModal(academia) {                                                
                    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    const form = document.getElementById('deleteForm');                                                
                    modal.show();
                    form.action = `/academias/${user.id}`; // Asegurate de que la ruta coincida con la definida en web.php    
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }                        
            </script>
            @else
            <p class="mb-3 text-gray-500 dark:text-gray-400">
                {{$emptyMessage}}
                </p>
            @endif
        </div>
    </div>    
</x-app-layout>