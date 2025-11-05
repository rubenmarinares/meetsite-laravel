@php    
    $imenu1 = 20;
    $imenu2 = 0;
@endphp
<x-app-layout>
        <x-slot name="sidemenu">@include('partials.sidemenu')</x-slot>
        <x-slot name="menu">@include('partials.menu')</x-slot>


        <style>
            

        </style>
        <div class="row g-3">
            <div class="col-12 col-lg-3 sticky-sidebar">
                @if( $sections->isNotEmpty() )
                <div class="card">
                    <div class="card-header border-bottom-0 pb-0">
                        <ul class="nav nav-tabs card-header-tabs" id="tabFilas" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="filas-tab-0" data-bs-toggle="tab" data-bs-target="#filas-tab-0-pane" type="button" role="tab" aria-controls="analytics-tab-0-pane" aria-selected="true">Tipos Filas</a>
                            </li>                       
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane fade active show" id="filas-tab-0-pane" role="tabpanel" aria-labelledby="filas-tab-0" tabindex="0">                    
                            <div id="divTypeSections" class="clearfix d-block">
                            @forelse ($sections as $section)      
                                <div class="element handle d-flex align-items-center justify-content-start gap-2 px-2 py-1 border rounded bg-light mb-1"
                                    data-idsection="{{ $section->id }}"
                                    data-typesection="{{ $section->type }}"
                                    style="font-size: 0.9rem;">
                                    <span class="move text-muted"><i class="fas fa-arrows"></i></span>
                                    <span class="move-caption">{{ $section->section }}</span>
                                    <span class="badge bg-secondary ms-auto">{{ $section->type }}</span>
                                </div>
                                
                            @empty
                                <tr><td colspan="5" class="">No hay filas</td></tr>
                            @endforelse
                            </div>
                        </div>                       
                    </div>
                </div>                
                @endif
                
                
                @if( $sections->isNotEmpty() )                

                <div class="card">
                    <div class="card-header border-bottom-0 pb-0">
                        <ul class="nav nav-tabs card-header-tabs" id="tabBloques" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="bloques-tab-0" data-bs-toggle="tab" data-bs-target="#bloques-tab-0-pane" type="button" role="tab" aria-controls="analytics-tab-0-pane" aria-selected="true">
                                Tipos Bloques
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bloques-tab-0-pane" role="tabpanel" aria-labelledby="bloques-tab-0" tabindex="0">
                                <div id="divTypeBlocks" class="clearfix d-block">
                                    @forelse ($blocks as $block)                                              
                                            <div class="element handle d-flex align-items-center justify-content-start gap-2 px-2 py-1 border rounded bg-light mb-1"
                                                data-idblock="{{ $block->id }}"
                                                data-typeblock="{{ $block->type }}"
                                                style="font-size: 0.9rem;">
                                                <span class="move text-muted"><i class="fas fa-arrows"></i></span>
                                                <span class="move-caption">{{ $block->block }}</span>
                                                <span class="badge bg-secondary ms-auto">{{ $block->block }}</span>
                                            </div>
                                    @empty
                                        <tr><td colspan="5" class="">No hay filas</td></tr>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
            </div>        
            <div class="col-12 col-lg-9">
                <div class="scrollable-content">
                    <ul class="nav nav-tabs border-bottom mb-3" id="tabEditor" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="editor-tab-0" data-bs-toggle="tab" data-bs-target="#editor-tab-0-pane" type="button" role="tab" aria-controls="analytics-tab-0-pane" aria-selected="true">
                                Editor
                            </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="editor-tab-1" data-bs-toggle="tab" data-bs-target="#editor-tab-1-pane" type="button" role="tab" aria-controls="analytics-tab-0-pane" aria-selected="true">
                                Acciones
                            </button>
                        </li>
                    
                    <!--
                        <a 
                        class="nav-link "
                        id="editor-tab-1"
                        target="_blank"
                        href="{{ $previewUrl }}"
                        aria-controls="editor-tab-1-pane"
                        aria-selected="true"
                        >
                            Previsualización
                            </a>-->
                    </ul>
                    <div class="tab-content">
                        <!--PANEL Filas-->
                        <div class="tab-pane fade active show" id="editor-tab-0-pane" role="tabpanel" aria-labelledby="editor-tab-0" tabindex="0">
                                    <div id="divTargetSections" class="collapse show pb-5"  style="padding:1rem"></div>
                        </div>
                        <div class="tab-pane fade" id="editor-tab-1-pane" role="tabpanel" aria-labelledby="editor-tab-1" tabindex="0">
                            <div class="p-4">
                                <div id="emailActionFeedback" class="mt-3"></div>
                                <div class="row g-4">
                                    <!-- Enviar test -->
                                    <div class="col-md-6 col-lg-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                        <h5 class="card-title mb-3"><i class="fas fa-paper-plane me-2 text-primary"></i>Enviar Email test</h5>
                                        <div class="mb-3">
                                            <label for="testEmail" class="form-label">Destinatario Email</label>
                                            <input type="email" class="form-control" id="testEmail" placeholder="you@example.com">
                                        </div>
                                        <button id="btnSendTest" class="btn btn-primary w-100">
                                            <i class="fas fa-envelope me-2"></i>Enviar Test
                                        </button>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- Vista previa -->
                                    <div class="col-md-6 col-lg-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body d-flex flex-column">
                                        <h5 class="card-title mb-3"><i class="fas fa-eye me-2 text-success"></i>Vista previa de email</h5>
                                        <p class="text-muted small flex-grow-1">Abrir vista previa de la template en nueva pestaña.</p>
                                            <a id="btnPreviewEmail" href="{{ $previewUrl }}" target="_blank" class="btn btn-success w-100 mt-auto">
                                                <i class="fas fa-external-link-alt me-2"></i>Abrir Vista Previa
                                            </a>
                                        </div>
                                    </div>
                                    </div>

                                    <!-- Convertir plantilla -->
                                    <div class="col-md-6 col-lg-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body d-flex flex-column">
                                        <h5 class="card-title mb-3"><i class="fas fa-clone me-2 text-warning"></i>Convertir a Email</h5>
                                        <p class="text-muted small flex-grow-1">
                                            Clonaremos esta plantilla y la convertimos en email.                                            
                                        </p>
                                        <button id="btnConvertToEmail" class="btn btn-warning w-100 mt-auto">
                                            <i class="fas fa-sync-alt me-2"></i>Convertir Plantilla
                                        </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                            const feedback = document.getElementById('emailActionFeedback');

                            const showMessage = (type, message, icon = '') => {
                                feedback.innerHTML = `
                                <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                                    ${icon ? `<i class="fas ${icon} me-2"></i>` : ''}
                                    ${message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                `;
                            };

                            const showLoading = (message) => {
                                feedback.innerHTML = `
                                <div class="d-flex align-items-center text-muted small py-2">
                                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                    ${message}
                                </div>
                                `;
                            };

                            // --- SEND TEST EMAIL ---
                            document.getElementById('btnSendTest').addEventListener('click', function() {
                                const email = document.getElementById('testEmail').value.trim();
                                const emailId = {{ $idemail ?? 'null' }}; // 👈 pasas el ID de Laravel al JS

                                console.log("email",email);
                                console.log("template",emailId);

                                if (!email || !emailId) {
                                    showMessage('warning', 'Introduce una dirección Email válida.', 'fa-exclamation-circle');
                                    return;
                                }

                                showLoading('Enviando test email...');

                                
                                fetch('/email/send-test', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                    body: JSON.stringify({ email: email, id:emailId })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                    showMessage('success', data.message || 'Test email sent successfully!', 'fa-paper-plane');
                                    })
                                    .catch(() => {
                                    showMessage('danger', 'Error sending test email. Please try again.', 'fa-times-circle');
                                });
                                
                                
                            });
                            

                            // --- CONVERT TEMPLATE ---
                            document.getElementById('btnConvertToEmail').addEventListener('click', function() {
                                if (!confirm('This will clone the template and convert it into an email. Continue?')) return;
                                    showLoading('Converting template...');
                                    /*fetch('/emails/convert-template/{{ $plantilla->id ?? 0 }}', {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                        showMessage('success', data.message || '✅ Template converted successfully!', 'fa-check-circle');
                                        })
                                        .catch(() => {
                                        showMessage('danger', '❌ Error converting template.', 'fa-times-circle');
                                    });
                                    */
                                });
                            });
                            </script>
                        </div>
                    </div>
                </div>


            </div>  

        </div>          
            


    </x-app-layout>
    
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.querySelector(".pc-sidebar");
    if (sidebar) {
      sidebar.classList.add("pc-sidebar-hide");
    }
  });


  
  

//FUNCIONALIDAD DRAG AN DROP

function cloneBlock(idblock){

    //console.log("Clonar bloque",idblock);

    fetch(`/plantillas/${idblock}/blockclone`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            idblock: idblock            
        }),
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.status === "success") {
            renderEmailEditor();
        } else {
            console.error("Error al clonar bloque:", data.message);
        }
    })
    .catch((error) => console.error("Error en la petición:", error));
}

//BLOQUES
var RowsCols={};
var sortableTypeBlocks = new Sortable(document.getElementById('divTypeBlocks'), {
    group: {
        put: false,           
        name: 'rowblocks',
        pull: 'clone',
        },
    handle: '.handle',
    sort: false,
    animation: 150,       
});
function sortableRowCol(idsection,col){    

    RowsCols['section'+idsection+'-col'+col]= new Sortable(document.getElementById('section'+idsection+'-col'+col), {
        group: {
                name: 'rowblocks',
                ghostClass: "sortable-ghost",  
                chosenClass: "sortable-chosen",  
                dragClass: "sortable-drag", 
                put: ['rowblocks']
            },
            handle: '.handle',
            swapThreshold: 0.90,
            animation: 150,
            direction: 'horizontal',
        onAdd: function (evt) {                                   
            addBlock(evt.item.dataset.idblock,col,idsection,evt.newIndex);
            return true;        
        },
        onSort: function (evt) {      
            
            var neworderTo=[];
            var neworderFrom=[];            

            evt.to.querySelectorAll('[data-idblock]').forEach(item => {
                neworderTo.push(item.dataset.idblock);
            });
            evt.from.querySelectorAll('[data-idblock]').forEach(item => {
                neworderFrom.push(item.dataset.idblock);
            });
            
             // Obtenemos secciones y columnas
            const sectionidFrom = evt.from.dataset.idsection;
            const sectionidTo = evt.to.dataset.idsection;
            const colFrom = evt.from.dataset.col;
            const colTo = evt.to.dataset.col;


            if (sectionidFrom === sectionidTo && colFrom === colTo) {
                // ✅ Mismo sitio: solo reordenar
                sortBlocks(neworderTo, sectionidFrom, sectionidTo, colTo);
            } else {
                // 🔄 Movimiento entre columnas o secciones
                sortBlocksMove(neworderTo, neworderFrom, sectionidFrom, sectionidTo, colTo);
            }
                        
        
        return true;        
        }  
    });
    
  }

  


  function sortBlocks(newOrder, idSectionFrom, idSectionTo, colTo) {
    //console.log("📤 Llamada sortBlocks (misma columna)");
    let emailId = getPlantillaIdFromUrl();

    fetch(`/plantillas/${emailId}/ordenar-bloques`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            neworder: newOrder,
            sectionidFrom: idSectionFrom,
            sectionidTo: idSectionTo,
            col: colTo,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                renderEmailEditor();
            } else {
                console.error("Error al actualizar orden:", data.message);
            }
        })
        .catch((error) => console.error("Error en la petición:", error));
}

function sortBlocksMove(newOrderTo, newOrderFrom, idSectionFrom, idSectionTo, colTo) {
    console.log("📤 Llamada sortBlocksMove (entre columnas/secciones)");
    let emailId = getPlantillaIdFromUrl();

    fetch(`/plantillas/${emailId}/mover-bloques`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            neworder: newOrderTo,
            neworderFrom: newOrderFrom,
            sectionidFrom: idSectionFrom,
            sectionidTo: idSectionTo,
            col: colTo,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "success") {
                renderEmailEditor();
            } else {
                console.error("Error al mover bloques:", data.message);
            }
        })
        .catch((error) => console.error("Error en la petición:", error));
}

//GESTIÓN DE BLOQUES
function addBlock(idblock,col,idSection,position){
    //console.log("ADD BLOCK ("+idblock+","+col+","+idSection+","+position+")")

    const idplantilla = getPlantillaIdFromUrl();        
    fetch(`/plantillas/${idplantilla}/addblock`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
        },
        body: JSON.stringify({
        blockid: parseInt(idblock),
        sectionid: idSection,
        col: col,
        order: position
        })
    })
    .then(res => res.json())
    .then(response => {
        //console.log('✅', response.data);
        renderEmailEditor();
    })
    .catch(err => console.error('❌', err));

}

//SECTIONS
var sortableTypeSections = new Sortable(document.getElementById('divTypeSections'), {
group: {
        put: false,           
        name: 'rowsections',
        pull: 'clone',
        /*ghostClass: "sortable-ghost",  
        chosenClass: "sortable-chosen",  
        dragClass: "sortable-drag", */
    },
    handle: '.handle',
    sort: false,
    animation: 150,       
    ghostClass: "sortable-ghost",  
    chosenClass: "sortable-chosen",  
    dragClass: "sortable-drag",
});

var sortableTarget = new Sortable(document.getElementById('divTargetSections'), {
    group: {
        name: 'rowsections', // mismo grupo
        pull: false,       // no arrastra elementos de aquí hacia otro
        put: ['rowsections'],
        
    },
    handle: '.handle',
    animation: 150,
    ghostClass: "sortable-ghost",  
    chosenClass: "sortable-chosen",  
    dragClass: "sortable-drag", 
    onAdd: function (evt) {                        
        addSection(evt.item.dataset.idsection,evt.newIndex)
    },
    onUpdate: function (evt) {                      
        var neworder=[];            
        const container = document.getElementById('divTargetSections');
        const divs = Array.from(container.children); // Convierte HTMLCollection en array
        divs.forEach(item => {            
            neworder.push(item.dataset.idsection)
        });
        reOrderSection(getPlantillaIdFromUrl(),neworder);
    }
});


function reOrderSection(emailId, newOrder) {
    fetch(`/plantillas/${emailId}/ordenar-secciones`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            neworder: newOrder
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            renderEmailEditor();
            console.log('Orden actualizado correctamente');
        } else {
            console.error('Error al actualizar orden:', data.message);
        }
    })
    .catch(error => {
        console.error('Error en la petición:', error);
    });
}

//GESTIÓN DE SECCIONES


function confirmDeleteSection(idsection) {  
  const $container = $("#deletesection-" + idsection);
  
  $container.html(`
    <div class="d-inline-flex gap-1">
      <button type="button" 
              id="confirmSection-${idsection}" 
              class="btn btn-outline-danger btn-sm" 
              title="Confirmar borrado">
        <i class="fas fa-trash"></i>
      </button>

      <button type="button" 
              id="cancelSection-${idsection}" 
              class="btn btn-outline-secondary btn-sm" 
              title="Cancelar borrado">
        <i class="fas fa-times"></i>
      </button>
    </div>
  `);

  // Eventos
  $("#confirmSection-" + idsection).on("click", function (e) {
    e.preventDefault();
    deleteSection(idsection);
  });

  $("#cancelSection-" + idsection).on("click", function (e) {
    e.preventDefault();    
    $container.html(`
      <a href="#" onclick="confirmDeleteSection(${idsection}); return false;" 
         class="btn btn-sm btn-light"
         title="Eliminar sección">
         <i class="fas fa-trash"></i>
      </a>
    `);
  });
}


  function deleteSection(id) {
        const plantillaId = getPlantillaIdFromUrl();
        fetch(`/plantillas/${plantillaId}/sections/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log(data.message);                
                const div = document.getElementById(`contenedorSeccion-${id}`)                                
                if (div) div.remove();
            } else {
                console.error(data.message || 'Error al eliminar la sección');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
}

function getPlantillaIdFromUrl() {
    const pathParts = window.location.pathname.split('/');        
    const id = pathParts[2];
    return id;
}




function addSection(idsection, position) {
    const idplantilla = getPlantillaIdFromUrl();        
    fetch(`/plantillas/${idplantilla}/addsection`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
        },
        body: JSON.stringify({
        sectionid: idsection,
        order: position
        })
    })
    .then(res => res.json())
    .then(response => {
        //console.log('✅', response.data);
        renderEmailEditor();
    })
    .catch(err => console.error('❌', err));
}

function renderEmailEditor(){
    const plantillaId = getPlantillaIdFromUrl();
    fetch(`/plantillas/${plantillaId}/sections`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {                                
            const sections=data.data;
            const container = document.getElementById('divTargetSections');
            container.innerHTML = data.html; 
            $("#divTargetSections .RowBlocks").each(function() {                
                const col = $(this).data('col');
                const idsection = $(this).data('idsection');                
                sortableRowCol(idsection,col); // tu función definida en la vista principal
            });               
        } else {
            console.error('Error al obtener secciones');
        }
    })
    .catch(error => {
        console.error('Error en la petición:', error);
    });

}    


function confirmDeleteBlock(idblock) {  
  const $container = $("#deleteblock-" + idblock);
  
  $container.html(`
    <div class="d-inline-flex gap-1">
      <button type="button" 
              id="confirmBlock-${idblock}" 
              class="btn btn-outline-danger btn-sm" 
              title="Confirmar borrado">
        <i class="fas fa-trash"></i>
      </button>

      <button type="button" 
              id="cancelBlock-${idblock}" 
              class="btn btn-outline-secondary btn-sm" 
              title="Cancelar borrado">
        <i class="fas fa-times"></i>
      </button>
    </div>
  `);

  // Eventos
  $("#confirmBlock-" + idblock).on("click", function (e) {
    e.preventDefault();
    deleteBlock(idblock);
  });

  $("#cancelBlock-" + idblock).on("click", function (e) {
    e.preventDefault();    
    $container.html(`
      <a href="#" onclick="confirmDeleteBlock(${idblock}); return false;" 
         class="btn btn-sm btn-light"
         title="Eliminar bloque">
         <i class="fas fa-trash"></i>
      </a>
    `);
  });
}



function deleteBlock(id) {
        const plantillaId = getPlantillaIdFromUrl();
        fetch(`/plantillas/${plantillaId}/blocks/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {                
                const div = document.getElementById(`block-${id}`)                                
                if (div) div.remove();
            } else {
                console.error(data.message || 'Error al eliminar la sección');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
}

renderEmailEditor();

    
</script>

 