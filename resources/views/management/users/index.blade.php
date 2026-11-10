
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen User - Logbook Studio</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f6fa; color: #252b36;
        }
        .container { max-width: 1100px; margin: auto; }
        .heading {
            display: flex; justify-content: space-between;
            align-items: center; gap: 16px; flex-wrap: wrap;
            margin-bottom: 24px;
        }
        h1 { margin: 0 0 8px; font-size: 28px; }
        .muted { color: #697386; }
        .card {
            background: white; padding: 22px;
            border-radius: 12px; overflow-x: auto;
            box-shadow: 0 2px 10px #1522380d;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            padding: 14px 12px; text-align: left;
            border-bottom: 1px solid #e8ebf0;
        }
        th { background: #f8f9fc; font-size: 13px; }
        .btn {
            display: inline-block; padding: 10px 14px;
            border: 0; border-radius: 7px; cursor: pointer;
            text-decoration: none; font-size: 13px;
        }
        .primary { background: #263b70; color: white; }
        .edit { background: #e8efff; color: #24428b; }
        .delete { background: #feecec; color: #b42318; }
        .actions { display: flex; gap: 7px; align-items: center; }
        .badge {
            display: inline-block; background: #edf1f7;
            padding: 5px 9px; border-radius: 20px; font-size: 12px;
        }
        .alert {
            padding: 12px 15px; margin-bottom: 15px;
            border-radius: 8px; background: #e8f7ed; color: #176534;
        }
        .error { background: #feecec; color: #b42318; }
        .back { color: #263b70; text-decoration: none; }
        @media (max-width: 600px) {
            body { padding: 16px; }
            .card { padding: 12px; }
        }
    </style>
</head>
<body>
<div class="container">
    <p><a class="back" href="{{ url('/logbooks') }}">← Kembali ke Logbook</a></p>

    <div class="heading">
        <div>
            <h1>Manajemen User</h1>
            <div class="muted">Kelola akun pengguna Logbook Studio.</div>
        </div>
        <a class="btn primary" href="{{ route('management.users.create') }}">
            + Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Studio</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $user->name }}
                            @if($user->email === 'admin@logbook.test')
                                <div class="muted" style="font-size:12px">Admin utama</div>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge">
                                @switch($user->role)
                                    @case('admin') Admin @break
                                    @case('kepala_studio') Kepala Studio @break
                                    @default Petugas
                                @endswitch
                            </span>
                        </td>
                        <td>{{ $user->studio ?: '-' }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn edit"
                                   href="{{ route('management.users.edit', $user) }}">
                                    Edit
                                </a>

                                @if($user->email !== 'admin@logbook.test' && $user->id !== auth()->id())
                                    <form method="POST"
                                          action="{{ route('management.users.destroy', $user) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn delete" type="submit">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
