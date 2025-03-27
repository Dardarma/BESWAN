<?php

namespace App\Http\Controllers\Controllerblade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Level;
use App\Models\Level_Murid;

class LevelUserController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('table_search'); 
        $paginate = $request->get('paginate', 10);
        
        $users = User::with(['levels:id,nama_level,warna'])
        ->select('id', 'name')
        ->where('role', 'user')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate($paginate);
    
        // dd($users);
   
    
        
        $levels = Level::select('id', 'nama_level','urutan_level')
            ->orderBy('urutan_level')
            ->get();
                
        return view('admin_page.level.levelUser', compact( 'search', 'users', 'levels', 'paginate'));
    }    

    public function updateLevels(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'levels' => 'array',
            'levels.*' => 'exists:level,id' // Ubah 'levels' ke 'level'
        ]);
        
    
        $user = User::findOrFail($request->user_id);
        $user->levels()->sync($request->levels);               
    
        return redirect()->back()->with('success', 'Level berhasil diubah');
    }
    
}
