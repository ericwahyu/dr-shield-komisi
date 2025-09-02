<?php

namespace App\Livewire\User;

use Exception;
use Throwable;
use Livewire\Component;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $id_data, $name, $email, $username, $password;

    public function render()
    {
        $users =  User::search($this->search)->whereNot('name', 'EWA');

        return view('livewire.user.user-index', [
            'user' => $users->role('admin')->paginate($this->perPage)
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {

    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('id_data', 'name', 'email', 'username', 'password');
        $this->dispatch('closeModal');
    }

    public function saveData()
    {
        $this->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'username' => 'required|lowercase',
            'password' => $this->id_data ? 'nullable' : 'required',
        ]);

        $unique_user = User::where('email', Str::lower($this->email))->orWhere('username', Str::lower($this->username))->first();
        if ($unique_user && $this->id_data == null) {
            return $this->alert('warning', 'Pemberitahuan', [
                'text' => 'Email atau Username sudah terpakai'
            ]);
        }

        try {
            DB::transaction(function () {
                $get_user = User::updateOrCreate(
                    [
                        'id' => $this->id_data
                    ],
                    [
                        'name'     => $this->name,
                        'email'    => Str::lower($this->email),
                        'username' => Str::lower($this->username),
                    ]
                );

                if ($this->password) {
                    $get_user->update([
                        'password' => Hash::make($this->password)
                    ]);
                }

                $get_user->assignRole('admin');
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            $errors = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Terjadi Kesalahan Saat Menyimpan Data !", $errors);

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Berhasil Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $get_data       = User::find($id);
        $this->id_data  = $get_data?->id;
        $this->name     = $get_data?->name;
        $this->email    = $get_data?->email;
        $this->username = $get_data?->username;

        $this->dispatch('openModal');
    }

    public function deleteConfirm($id)
    {
        $this->confirm('Konfirmasi', [
            'inputAttributes'    => ['id' => $id],
            'onConfirmed'        => 'delete',
            'text'               => 'Apakah Anda yakin akan menghapus data ini',
            'reverseButtons'     => 'true',
            'confirmButtonColor' => '#24B464',
        ]);
    }

    public function getListeners()
    {
        return ['delete'];
    }

    public function delete($data)
    {
        try {
            DB::transaction(function () use ($data) {
                $result = User::find($data['inputAttributes']['id']);
                $result->delete();
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Berhasil Dihapus !'
        ]);
    }
}
