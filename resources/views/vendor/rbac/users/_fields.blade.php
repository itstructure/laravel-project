<div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
    <div class="container">
        <div class="row">
            <label class="col-md-4 control-label">Roles</label>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach($allRoles as $role)
                    <p>
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                               @cannot(Itstructure\LaRbac\Models\Permission::ASSIGN_ROLE_FLAG, Itstructure\LaRbac\Classes\MemberToRole::make($user, $role)) disabled @endcannot
                               @if(isset($currentRoles) && in_array($role->id, $currentRoles)) checked @endif > {{ $role->name }}


                        @if(isset($currentRoles) && in_array($role->id, $currentRoles))
                            @cannot(Itstructure\LaRbac\Models\Permission::ASSIGN_ROLE_FLAG, Itstructure\LaRbac\Classes\MemberToRole::make($user, $role))
                                <input type="hidden" name="roles[]" value="{{ $role->id }}">
                            @endcannot
                        @endif
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    @if ($errors->has('roles'))
        <span class="help-block">
            <strong>{{ $errors->first('roles') }}</strong>
        </span>
    @endif
</div>
