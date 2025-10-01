<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h4 class="card-title"><i class="{{$menuitems[$imenu1]['icon']}}"></i>&nbsp;{{$menuitems[$imenu1]['label']}}</h4>    
    </div>
    
    <div class="card-table table-responsive mt-2">             
        
        <div class="row">
            <div class="col-md-3">         
                <label class="form-label" for="fechadesde">Fecha Desde</label>
                <input type="text" name="fechadesde" id="fechadesde" 
                    class="form-control  pc-datepicker "
                    value="{{ now()->startOfMonth()->format('d/m/Y') }}"
                    >
            </div>
            @php
            $fechaHasta = now()->addMonth()->format('d/m/Y');
            @endphp

            <div class="col-md-3">         
                <label class="form-label" for="fechahasta">Fecha Hasta</label>
                <input type="text" name="fechahasta" id="fechahasta" 
                value="{{ now()->endOfMonth()->format('d/m/Y') }}"
                class="form-control  pc-datepicker ">
            </div>
        
            <div class="col-md-3">
                <label for="grupos" class="form-label">Selecciona Grupo</label>
                <select name="grupo" id="grupo" class="form-control" >
                    <option></option>
                    @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}" {{ $grupo->id==$selectedGrupo ? 'selected' : '' }}>
                        {{ $grupo->grupo }}
                    </option>
                    @endforeach
                </select>               
            </div>
            <div class="col-md-3">
                <label for="alumnos" class="form-label">Selecciona Alumno</label>
                <select name="idalumno" id="idalumno" class="form-control">
                    <option></option>
                    @foreach ($alumnos as $alumno)
                    <option value="{{ $alumno->id }}" {{ $alumno->id==$selectedAlumno ? 'selected' : '' }}>
                        {{ $alumno->nombre }} {{ $alumno->apellidos }}
                    </option>
                    @endforeach
                </select>               
            </div>



        </div>
       <div class="row mt-3">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-primary" id="btnBuscar">
                    Buscar
                </button>
            </div>
        </div>


       <div class="row" id="divAttendance"></div>

       <div id="loading" class="text-center my-3" style="display:none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando datos, por favor espera...</p>
        </div>
    </div>
</div>

<script>
    
document.getElementById("btnBuscar").addEventListener("click", function() {
    launchAsistencia();
    
});



function launchAsistencia(){
    let fechadesde = document.getElementById("fechadesde").value;
    let [dia, mes, anio] = fechadesde.split("/"); // ["25","09","2025"]
    let fechaFormatoDesde = anio + mes + dia; // "20250925"
    let fechahasta = document.getElementById("fechahasta").value;
    let [dia2, mes2, anio2] = fechahasta.split("/"); // ["25","09","2025"]
    let fechaFormatoHasta = anio2 + mes2 + dia2; // "20250925"    
    
    const data = {        
        fechadesde:fechaFormatoDesde,
        fechahasta:fechaFormatoHasta,
        idalumno: document.getElementById("idalumno").value,
        grupo: document.getElementById("grupo").value,
        _token: '{{ csrf_token() }}'
    };
    //console.log("data",data)
    document.getElementById('divAttendance').innerHTML='';
    document.getElementById('loading').style.display = 'block';
    fetch("{{ route('asistencia.search') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": data._token
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        let data;
        //console.log(result)
        renderAttendance(result);
    })
    .catch(error => {
        console.error("Error en la petición:", error);
    })
    .finally(() => {
    // Ocultar loader
    document.getElementById('loading').style.display = 'none';
    });

}


function renderAttendance(data) {
    let html = '';    
    data.forEach(grupo => {
        // Cabecera de panel (tarjeta Bootstrap)
        html += `
        <div class=" mb-4 mt-2">
          <div class="card-header bg-primary ">
            <h5 class="mb-0 text-white">Grupo: ${grupo.grupo}</h5>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-sm ">
              <thead class="table-light">
                <tr>
                  <th>Alumno</th>
        `;

        // Cabeceras de fechas
        grupo.fechas.forEach(f => {
            const fecha = new Date(f.fecha).toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: '2-digit',
                weekday: 'long'
            });

            html += `<th class="text-center">${fecha} </th>`;
        });

        html += `
                </tr>
              </thead>
              <tbody>
        `;

        // Filas de alumnos
        if (grupo.alumnos.length > 0) {
            grupo.alumnos.forEach(alumno => {
                html += `<tr><td>${alumno.nombre} ${alumno.apellidos}</td>`;
                grupo.fechas.forEach(f => {    
                    let key = `${grupo.idgrupo}_${alumno.idalumno}_${f.dia_entero}`;
                    
                    let asistencia = grupo.asistencias[key] ?? null;

                    let estado = asistencia ? asistencia.estado : 0; 
                    let title = 'Sin definir';

                    let icon = "fa-regular fa-square";
                    if (estado === 1) {
                        icon = "fa-solid fa-check text-success";
                        title="Asistió";

                    }
                    if (estado === 2) {
                        icon = "fa-solid fa-xmark text-danger";
                        title="No asistió";
                    }
                    html += `
                        <td class="text-center">                          
                            <div class="btn-group btn-group-sm btn-inline-primary" role="group">
                                <button type="button" 
                                    class="attendance-btn btn btn-sm" 
                                    data-grupo="${grupo.idgrupo}"
                                    data-alumno="${alumno.idalumno}"
                                    data-fecha="${f.dia_entero}" 
                                    data-estado="${estado}"
                                    title="${title}">
                                    <i class="${icon}"></i>
                                </button>                             
                                <button type="button" 
                                    class="btn btn-sm"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#comentarioModal"
                                    data-grupo="${grupo.idgrupo}"
                                    data-alumno="${alumno.idalumno}"
                                    data-fecha="${f.dia_entero}"
                                    title="Añadir comentario">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </td>`;
                });
                html += `</tr>`;
            });
        } else {
            html += `
              <tr>
                <td colspan="${grupo.fechas.length + 1}" class="text-center text-muted">
                  No hay alumnos en este grupo
                </td>
              </tr>
            `;
        }
        html += `
              </tbody>
            </table>
          </div>
        </div>`;
    });
    document.getElementById('divAttendance').innerHTML = html;


    document.querySelectorAll('.attendance-btn').forEach(btn => {
        btn.addEventListener('click', () => {            
            let estado = parseInt(btn.dataset.estado);            
            estado = (estado + 1) % 3;
            btn.dataset.estado = estado;

            let icon = btn.querySelector('i');            

            if (estado === 0) {
            icon.className = "fa-regular fa-square";
            btn.title='Sin definir';
            }
            if (estado === 1) {
                icon.className = "fa-solid fa-check text-success";
                btn.title='Asistió';
            }
            if (estado === 2) {
                icon.className = "fa-solid fa-xmark text-danger";
                btn.title='No asistió';
            }

            guardarAsistencia(btn.dataset.grupo, btn.dataset.alumno, btn.dataset.fecha, estado);
            
        });
    });    
}


async function guardarAsistencia(grupo, alumno, fecha, estado) {
    
  try {    
    let response = await fetch("/asistencia/update", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
      },
      body: JSON.stringify({
        grupo: grupo,
        alumno: alumno,
        fecha: fecha,
        estado: estado
      })
    });

    let data = await response.json();
    if (data.success) {
      console.log("Asistencia guardada correctamente");
    } else {
      console.error("Error al guardar asistencia");
    }
  } catch (err) {
    console.error("Error en la petición:", err);
  }
}

launchAsistencia();

</script>