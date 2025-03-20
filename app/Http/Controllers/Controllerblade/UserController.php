<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Http\Requests\editUser;
use App\Http\Requests\storeUser;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('table_search');
        $paginate = $request->input('paginate', 10);

        $user = User::select('id','name','email','role','no_hp','tanggal_lahir','alamat','tanggal_masuk')
            ->when($search, function($query,$search){
                $query->where('name','like','%'.$search.'%')
                    ->orWhere('email','like','%'.$search.'%')
                    ->orWhere('role','like','%'.$search.'%')
                    ->orWhere('no_hp','like','%'.$search.'%')
                    ->orWhere('tanggal_lahir','like','%'.$search.'%')
                    ->orWhere('alamat','like','%'.$search.'%')
                    ->orWhere('tanggal_masuk','like','%'.$search.'%');
            })
            ->paginate(10);


        return view('admin_page.user.user_list',compact('user'), ['judul'=> 'User Controller']);
    }

    
    public function create()
    {
        
    }

   
    public function store(storeUser $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'no_hp' => $request->no_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'tanggal_masuk' => Carbon::now(),
            ]);


            return redirect()->route('user')->with('success', 'Berhasil menambahkan user');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
    }

    


    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin_page.user.editUser', compact('user'));
    }


  
public function update(editUser $request, string $id)
{
    try{
        $user = User::findOrFail($id);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'tanggal_masuk' => Carbon::now()
        ]);

        return redirect()->route('user')->with('success', 'Berhasil edit user');

    }catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Gagal edit user: ' . $e->getMessage()]);
    }


    return redirect(url('/user'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $user = User::findOrFail($id);
            
            DB::table('monthly_activity')->where('id_user', $id)->delete();
            DB::table('user_activity')->where('id_user', $id)->delete();
            DB::table('level_murid')->where('id_siswa', $id)->delete();
      
            $user->delete();
      
            return redirect()->route('user')->with('success','berhasil delete user');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal delete user: ' . $e->getMessage()]);
        }
    }
}
