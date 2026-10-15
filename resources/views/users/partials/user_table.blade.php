<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th class="text-center">ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th class="text-center">Role</th>
                <th class="text-center">Dibuat Pada</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($userList as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td class="d-flex align-items-center gap-3">
                        <img 
                            src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('img/default-user.png') }}" 
                            alt="Foto" 
                            class="rounded-circle shadow-sm" 
                            style="width: 40px; height: 40px; object-fit: cover;">
                        <span>{{ $user->name }}</span>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        @if($user->role == 1)
                            <span class="badge bg-primary">Admin</span>
                        @else
                            <span class="badge bg-info">Visitor</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : 'N/A' }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data user</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
