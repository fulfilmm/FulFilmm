


        <form action="{{isset( $role) ? route('roles.update',$role->id): route('roles.store')}}" method="POST" >
            @csrf
            @if (isset($role))
            @method('put')
            @endif
            <x-forms.basic.input name="name" title="Name" value="{{$role->name ?? old('name')}}" required></x-forms.basic.input>
          <br>
            <button
            class="btn btn-primary "
            type="submit">
            submit
        </button>
        </form>
            {{-- {{dd($errors->all())}} --}}

