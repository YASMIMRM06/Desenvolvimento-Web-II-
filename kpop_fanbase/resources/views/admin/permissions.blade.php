@extends('layouts.app')

@section('title', 'Gerenciar Permissões')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Permissões</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
            <i class="fas fa-plus"></i> Nova Permissão
        </button>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Permissões do Sistema</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Atribuída a</th>
                            <th>Criada em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description }}</td>
                                <td>{{ $permission->roles_count }} perfis</td>
                                <td>{{ $permission->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editPermissionModal{{ $permission->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta permissão?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Edit Permission Modal -->
                            <div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1" aria-labelledby="editPermissionModalLabel{{ $permission->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPermissionModalLabel{{ $permission->id }}">Editar Permissão</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name{{ $permission->id }}" class="form-label">Nome</label>
                                                    <input type="text" class="form-control" id="name{{ $permission->id }}" name="name" value="{{ $permission->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $permission->id }}" class="form-label">Descrição</label>
                                                    <textarea class="form-control" id="description{{ $permission->id }}" name="description" rows="3">{{ $permission->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma permissão cadastrada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Perfis e Permissões</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Perfil</th>
                            <th>Permissões</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ ucfirst($role->name) }}</td>
                                <td>
                                    @if($role->permissions->isEmpty())
                                        <span class="text-muted">Nenhuma permissão</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($role->permissions as $permission)
                                                <span class="badge bg-primary">{{ $permission->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#manageRolePermissionsModal{{ $role->id }}">
                                        Gerenciar
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Manage Role Permissions Modal -->
                            <div class="modal fade" id="manageRolePermissionsModal{{ $role->id }}" tabindex="-1" aria-labelledby="manageRolePermissionsModalLabel{{ $role->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="manageRolePermissionsModalLabel{{ $role->id }}">Gerenciar Permissões para {{ ucfirst($role->name) }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.roles.permissions.update', $role->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                @foreach($permissions as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }}_{{ $role->id }}" 
                                                               name="permissions[]" value="{{ $permission->id }}"
                                                               {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission{{ $permission->id }}_{{ $role->id }}">
                                                            {{ $permission->name }} <small class="text-muted">({{ $permission->description }})</small>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPermissionModalLabel">Adicionar Nova Permissão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <small class="text-muted">Use formato: resource.action (ex: users.create)</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar Permissão</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection