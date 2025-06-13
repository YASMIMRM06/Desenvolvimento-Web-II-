<div class="modal fade" id="roleModal-{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.update-roles', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">Edit Roles for {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    @foreach($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                            name="roles[]" value="{{ $role->id }}"
                            id="role-{{ $user->id }}-{{ $role->id }}"
                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role-{{ $user->id }}-{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>