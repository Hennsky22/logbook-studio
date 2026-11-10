<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    private string $adminUtama = 'admin@logbook.test';

    private function pastikanAdmin(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'admin',
            403,
            'Halaman ini hanya dapat diakses oleh Admin.'
        );
    }

    public function index()
    {
        $this->pastikanAdmin();

        $users = User::orderBy('id')->get();

        return view('management.users.index', compact('users'));
    }

    public function create()
    {
        $this->pastikanAdmin();

        return view('management.users.create');
    }

    public function store(Request $request)
    {
        $this->pastikanAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in([
                'admin', 'petugas', 'kepala_studio',
            ])],
            'studio' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('management.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->pastikanAdmin();

        return view('management.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->pastikanAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in([
                'admin', 'petugas', 'kepala_studio',
            ])],
            'studio' => ['nullable', 'string', 'max:255'],
        ]);

        if ($user->email === $this->adminUtama) {
            $validated['role'] = 'admin';
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('management.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->pastikanAdmin();

        if (
            $user->email === $this->adminUtama ||
            $user->id === auth()->id()
        ) {
            return redirect()
                ->route('management.users.index')
                ->with('error', 'Akun Admin utama atau akun yang sedang digunakan tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('management.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
