<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UserService
{
    public function dataTable()
    {
        $data = UserProfile::whereHas('user.roles', function ($query) {
            $query->where('name', '!=', 'admin');
        })->with('user.roles')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('nama_user', fn($row) => $row->user->name)
            ->addColumn('role', function ($row) {
                $roles = $row->user->roles->pluck('name')->toArray();
                return implode(', ', $roles);
            })
            ->addColumn('action', function ($row) {
                $actionBtn  = '<a href="' . url("users", $row->user->id) . '/edit" ';
                $actionBtn .= 'class="editRole btn btn-warning btn-sm me-2"><i class="ti-pencil-alt"></i></a>';
                $actionBtn .= '<button type="button" data-id="' . $row->user->id . '" ';
                $actionBtn .= 'class="deleteUser btn btn-danger btn-sm"><i class="ti-trash"></i></button>';
                return '<div class="d-flex">' . $actionBtn . '</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getById($id)
    {
        return User::with('profile')->findOrFail($id);
    }

    public function create($data)
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser($data);
            $this->createUserProfile($data, $user);

            DB::commit();

            return ['success' => true, 'message' => 'Data berhasil disimpan.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()];
        }
    }

    private function createUser($data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $role = Role::find($data['role']);
        $user->assignRole($role);

        return $user;
    }

    private function createUserProfile($data, $user)
    {
        $userProfile = UserProfile::create([
            'user_id'       => $user->id,
            'perner'        => $data['perner'] ?? null,
            'site'          => $data['site'] ?? null,
            'layanan'       => $data['layanan'] ?? null,
            'login_id'      => $data['login_id'] ?? null,
            'no_hp'         => $data['no_hp'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
        ]);

        if (isset($data['image'])) {
            $image = $data['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/users'), $imageName);

            $userProfile->image = $imageName;
            $userProfile->save();
        }
    }

    public function update($data, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $this->updateUser($data, $user);
            $this->updateUserProfile($data, $user);

            DB::commit();

            return ['success' => true, 'message' => 'Data berhasil diubah.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Gagal merubah data: ' . $e->getMessage()];
        }
    }

    private function updateUser($data, $user)
    {
        $user->update([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => isset($data['password']) ? bcrypt($data['password']) : $user->password,
        ]);

        if (isset($data['role'])) {
            $role = Role::find($data['role']);
            $user->syncRoles([$role->id]);
        }

        return $user;
    }

    private function updateUserProfile($data, $user)
    {
        $userProfile = $user->profile;

        $userProfile->update([
            'perner'        => $data['perner'] ?? $userProfile->perner,
            'site'          => $data['site'] ?? $userProfile->site,
            'layanan'       => $data['layanan'] ?? $userProfile->layanan,
            'login_id'      => $data['login_id'] ?? $userProfile->login_id,
            'no_hp'         => $data['no_hp'] ?? $userProfile->no_hp,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? $userProfile->tanggal_lahir,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? $userProfile->jenis_kelamin,
            'alamat'        => $data['alamat'] ?? $userProfile->alamat,
        ]);

        if (isset($data['image'])) {
            if ($userProfile->image) {
                $oldImagePath = public_path('assets/images/users/' . $userProfile->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $data['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/users'), $imageName);

            $userProfile->image = $imageName;
            $userProfile->save();
        }

        return $userProfile;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($id);
            $userProfile = UserProfile::where('user_id', $id)->first();

            if ($user) {
                $this->deleteUser($user);
                if ($userProfile) {
                    $this->deleteUserProfile($userProfile);
                }
                $user->roles()->detach();

                DB::commit();
                return ['success' => true, 'message' => 'Data berhasil dihapus.'];
            }

            return ['success' => false, 'message' => 'Data tidak ditemukan.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()];
        }
    }

    private function deleteUser($user)
    {
        return $user->delete();
    }

    private function deleteUserProfile($userProfile)
    {
        if ($userProfile->image) {
            $imagePath = public_path('assets/images/users/' . $userProfile->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $userProfile->delete();
    }
}
