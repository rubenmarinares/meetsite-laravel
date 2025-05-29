<form class="space-y-6 p-6 rounded-lg shadow-md" action={{$actionUrl}} method="POST">
    @csrf
    @method($method)


    <div class="row mb-3 mt-3">
        <div class="col-md-4">
            <label for="name" class="form-label">Rol *</label>
            <input type="text" value="{{ old('name', $role->name) }}" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="guard_name" class="form-label">guard_name *</label>
            <select name="guard_name" id="guard_name" class="form-control">
              <option value=""></option>
              @foreach($guardNames as $guardName)
                <option value="{{$guardName}}" @if($guardName==old('guard_name', $role->guard_name)) selected @endif>{{$guardName}}</option>
              @endforeach
          </select>
            @error('guard_name')
              <p class="invalid-feedback d-block">{{ $message }}</p>
              @enderror
        </div>

        <div class="col-md-4">
            <label for="permissions" class="form-label">Permisos</label>
            <select name="permissions[]" id="permissions" multiple class="form-control select2">
                  @foreach ($permisos as $permiso)
                    <option value="{{ $permiso->id }}"
                      {{ in_array($permiso->id, $permisosSeleccionados) ? 'selected' : '' }}
                      >
                      {{ $permiso->name }}
                    </option>
                  @endforeach
              </select>            
        </div>


        <div class="row mt-3">

          

          <div class="col-md-6">
           @if(count($permisosSeleccionados))
            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Permisos asignados:</h2>
            <ul class="">
              @foreach($permisos as $permiso)
                @if(in_array($permiso->id, $permisosSeleccionados))              
                <li>                
                  <a href="{{ route('permissions.edit',$permiso->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $permiso->name }}</a>
                </li>
                @endif
              @endforeach
            </ul>
            @endif

          </div>
        </div>


    </div>


    
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  