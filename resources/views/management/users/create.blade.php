
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah User - Logbook Studio</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 30px; font-family: Arial, sans-serif; background: #f5f6fa; color: #252b36; }
        .card { max-width: 650px; margin: auto; background: white; padding: 28px; border-radius: 12px; }
        h1 { margin-top: 0; }
        label { display: block; margin: 16px 0 7px; font-weight: 600; }
        input, select { width: 100%; padding: 11px; border: 1px solid #d5d9e2; border-radius: 7px; font-size: 15px; }
        button, .back { display: inline-block; padding: 11px 16px; border: 0; border-radius: 7px; text-decoration: none; cursor: pointer; }
        button { background: #263b70; color: white; margin-top: 20px; }
        .back { background: #e8ebf2; color: #252b36; }
        .error { color: #b42318; font-size: 13px; margin-top: 5px; }
        .hint { color: #697386; font-size: 13px; }
    </style>
</head>
<body>
<div class="card">
    <h1>Tambah User</h1>
    <p>Isi informasi akun pengguna baru.</p>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('management.users.store') }}">
        @csrf

        <label for="name">Nama lengkap</label>
        <input id="name" name="name" value="{{ old('name') }}" required maxlength="255">
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label for="password">Password</label>
        <input id="password" type="password" name="password" required minlength="8">
        <div class="hint">Minimal 8 karakter.</div>
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label for="role">Role pengguna</label>
        <select id="role" name="role" required>
            <option value="petugas" @selected(old('role', 'petugas') === 'petugas')>Petugas</option>
            <option value="kepala_studio" @selected(old('role') === 'kepala_studio')>Kepala Studio</option>
            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
        </select>
        @error('role') <div class="error">{{ $message }}</div> @enderror

        <label for="studio">Studio</label>
        <input id="studio" name="studio" value="{{ old('studio') }}" maxlength="255">
        @error('studio') <div class="error">{{ $message }}</div> @enderror

        <button type="submit">Simpan User</button>
        <a class="back" href="{{ route('management.users.index') }}">Batal</a>
    </form>
</div>
</body>
</html>
