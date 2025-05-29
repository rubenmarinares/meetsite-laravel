<form class="space-y-6 p-6 rounded-lg shadow-md" action={{$actionUrl}} method="POST">
    @csrf
    @method($method)

    <div class="row mb-3 mt-3">
        <div class="col-md-4">
            <label for="name" class="form-label">Permiso *</label>
            <input type="text" value="{{ old('name', $permission->name) }}" name="name" id="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="guard_name" class="form-label">guard_name *</label>
            <select name="guard_name" id="guard_name" class="form-control">
              <option value=""></option>
              @foreach($guardNames as $guardName)
                <option value="{{$guardName}}" @if($guardName==old('guard_name', $permission->guard_name)) selected @endif>{{$guardName}}</option>
              @endforeach
          </select>
            @error('guard_name')
              <p class="invalid-feedback d-block">{{ $message }}</p>
              @enderror
        </div>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-span-2 mb-5 w-fit mx-auto">
            @if(count($rolesSeleccionados))
            <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Roles asignados:</h2>
            <ul class="">
              @foreach($roles as $role)
                @if(in_array($role->id, $rolesSeleccionados))              
                <li>
                  <a href="{{ route('roles.edit',$role->id) }}"  class="">{{ $role->name }}</a>
                </li>
                @endif
              @endforeach
            </ul>
            @endif
        </div>

    </div>


    
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            {{ $submitButtonText }}
        </button>
    </div>
  </form>
  