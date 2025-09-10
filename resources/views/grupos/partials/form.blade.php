@php    
$status=[
    0 => "Inactivo",
    1 => "Activo",    
];

$abreviaturas = ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"];
$dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
$horarios = [];
foreach ($dias as $index => $dia) {
    $horarios[] = [
        "abreviatura" => $abreviaturas[$index],
        "dia" => $dia
    ];
}
@endphp

<form class="needs-validation" action="{{ $actionUrl }}" method="POST" novalidate autocomplete="off">
    @csrf
    @method($method)


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <label for="grupo" class="form-label">Grupo *</label>
            <input type="text" value="{{ old('grupo',$data["grupo"] ?? $grupo->grupo) }}" name="grupo" id="grupo" class="form-control @error('grupo') is-invalid @enderror" autocomplete="off" placeholder="Nombre del Grupo">            
            @error('nombre')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-1">
            <label for="color" class="form-label">Fondo *</label><br>
            <input type="color"  name="color" value="{{ old('grupo',$data["color"] ?? $grupo->color) }}" class="@error('color') is-invalid @enderror" autocomplete="off" >
        </div>
        <div class="col-md-1">
            <label for="textcolor" class="form-label">Texto *</label><br>
            <input type="color"  name="textcolor" value="{{ old('grupo',$data["textcolor"] ?? $grupo->textcolor) }}" class="@error('textcolor') is-invalid @enderror" autocomplete="off" >
        </div>

        <div class="col-md-4">
            <label for="status" class="form-label">Estado </label>
            <select name="status" id="status" class="form-control  @error('status') is-invalid @enderror" style="height:47px !important;">
                <option value=""></option>
                @foreach ($status as $key => $estado)
                    <option value="{{ $key }}" 
                        {{old('grupo',$data["status"] ?? $grupo->status) == $key ? 'selected' : '' }}>
                        {{ $estado }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror            
        </div>
        
        
    </div>
    
    <div class="row mb-3 mt-3">   
        <div class="col-md-6">         
            <label class="form-label" for="fechainicio">Fecha Inicio</label>
            <input type="text" name="fechainicio" id="fechainicio" value="{{ old('grupo',$data["fechainicio"] ?? $grupo->fechainicio) }}" class="form-control form-control-sm pc-datepicker required @error('fechainicio') is-invalid @enderror"  >
            @error('fechainicio')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">         
            <label class="form-label" for="fechafin">Fecha Fin</label>
            <input type="text" name="fechafin" id="fechafin" value="{{ old('grupo',$data["fechafin"] ?? $grupo->fechafin) }}" class="form-control form-control-sm pc-datepicker required @error('fechafin') is-invalid @enderror" >
            
            @error('fechafin')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        
       
    </div>

    <div class="row mb-3 mt-3">   
         <!--ACADEMIAS RELATED-->
        <div class="col-md-6">
            <label for="academias" class="form-label">Academias </label>
            <select name="academias[]" id="academias" multiple  class="form-control select2 @error('academias') is-invalid select2-invalid  @enderror" style="height:47px !important;">
                @foreach ($academias as $academia)
                <option value="{{ $academia->id }}" {{ in_array($academia->id, $academiasSeleccionadas) ? 'selected' : '' }}>
                    {{ $academia->academia }} 
                </option>
                @endforeach
            </select> 
            @error('academias')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror            
        </div>

        <div class="col-md-6">
            <label for="profesores" class="form-label">Profesor </label>
            <select name="properties[profesor]" class="form-control " >
                <option></option>
                @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}" 
                        {{ isset($properties["profesor"]) && $properties["profesor"]==intval($profesor->id) ? 'selected' : '' }}>
                        {{ $profesor->nombre }}  {{ $profesor->apellidos }} 
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <script>
document.addEventListener("change", function(e) {
    if (e.target.matches("input[type='checkbox'][id^='dia']")) {
        let row = e.target.closest("tr");
        let inputs = row.querySelectorAll("input[type='time'], select");

        if (!e.target.checked) {
            inputs.forEach(el => {
                el.value = '';
                el.setAttribute('disabled', 'disabled');
            });
        } else {
            inputs.forEach(el => el.removeAttribute('disabled'));
        }
    }
});
</script>
    
    <div class="row mb-3 mt-3">        
        <div class="col-md-12"><h5 class="mt-3">Horarios</h5>
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th scope="col">Día</th>
                  <th scope="col">Hora ini</th>
                  <th scope="col">Hora fin</th>                  
                  <th scope="col">Aula</th>
                </tr>
              </thead>
              <tbody>
                 @foreach ($horarios as $index => $horario)
                    <tr>
                        <td><input id="dia{{ $index }}" type="checkbox" name="properties[dias][{{$index}}]" value="1" 
                            {{ isset($properties["dias"][$index]) ? 'checked' : '' }}
                            
                            >                            
                            <label for="dia{{ $index }}"> {{$horario["dia"]}} </label></td>
                        <td>                            
                            <input type="time" class="form-control" 
                                    name="properties[hora_ini][{{ $index }}]" 
                                    value="{{ isset($properties['hora_ini'][$index])  ? $properties['hora_ini'][$index]: '' }}">
                        </td>
                        <td>
                            <input type="time" class="form-control" 
                                    name="properties[hora_fin][{{ $index }}]" 
                                    value="{{ isset($properties['hora_fin'][$index])  ? $properties['hora_fin'][$index]: '' }}">                            
                        </td>
                        <td>
                            <select name="properties[aula][{{ $index }}]" class="form-control" style="">
                                <option></option>
                                @foreach ($aulas as $aula)
                                    <option value="{{ $aula->id }}" 
                                        {{ isset($properties["aula"][$index]) && $properties["aula"][$index]==intval($aula->id) ? 'selected' : '' }}>
                                        {{ $aula->aula }} 
                                    </option>
                                @endforeach
                            </select>
                        </td>                        
                    </tr>  
                 @endforeach
              </tbody>
            </table>
        </div>          
    </div>
    
    
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  