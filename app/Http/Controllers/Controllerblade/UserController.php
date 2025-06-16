<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Http\Requests\editUser;
use App\Http\Requests\storeUser;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('table_search');
        $paginate = $request->input('paginate', 10);

        $user = User::select('id', 'name', 'email', 'role', 'no_hp', 'tanggal_lahir', 'alamat', 'tanggal_masuk', 'foto_profil')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_lahir', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_masuk', 'like', '%' . $search . '%');
            })
            ->paginate(10);


        return view('admin_page.user.User_list', compact('user'), ['judul' => 'User Controller']);
    }


    public function create() {}


    public function store(storeUser $request)
    {
        try {
            $path_file = null;
            
            if($request->hasFile('foto_profil')){
                $path_file = $request->file('foto_profil')->store('public/user');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'no_hp' => $request->no_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'tanggal_masuk' => Carbon::now(),
                'foto_profil' => $path_file,
            ]);


            return redirect()->route('user')->with('success', 'Berhasil menambahkan user');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
    }




    public function edit(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::id());

            $request->validate([
                'name' => 'required|string|max:255',
                'no_hp' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $updateData = [
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'tanggal_masuk' => Carbon::now()
            ];

            // Hanya update password jika ada input password
            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);

            return redirect()->view('user_page.user_profile.user_profile', compact('user'))->with('success', 'Berhasil edit user');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal edit user: ' . $e->getMessage()]);
        }
    }



    public function update(editUser $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'no_hp' => $request->no_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'tanggal_masuk' => Carbon::now()
            ];

            // Hanya update password jika ada input password
            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $user->update($updateData);

            if ($request->hasFile('foto_profil')) {
                if ($user->foto_profil && Storage::exists($user->foto_profil)) {
                    Storage::delete($user->foto_profil);
                }

                $path_file = $request->file('foto_profil')->store('public/user');
                $user->update([
                    'foto_profil' => $path_file
                ]);
            }


            $user->save();

            return redirect()->route('user')->with('success', 'Berhasil edit user');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal edit user: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            DB::table('monthly_activity')->where('id_user', $id)->delete();
            DB::table('user_activity')->where('id_user', $id)->delete();
            DB::table('level_murid')->where('id_siswa', $id)->delete();

            $user->delete();

            return redirect()->route('user')->with('success', 'berhasil delete user');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal delete user: ' . $e->getMessage()]);
        }
    }
}
