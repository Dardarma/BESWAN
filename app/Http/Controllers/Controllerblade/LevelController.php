<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Http\Requests\LevelStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('table_search');
        $paginate = $request->input('paginate', 10);

        $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level', 'warna')
            ->when($search, function ($query, $search) {
                $query->where('nama_level', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi_level', 'like', '%' . $search . '%');
            })
            ->orderBy('urutan_level', 'asc')
            ->paginate($paginate);

        $meta = Level::select('id', 'nama_level', 'urutan_level', 'warna')
            ->orderBy('urutan_level', 'asc')
            ->get();

        return view('admin_page.level.levelList', compact('level', 'search', 'paginate', 'meta'), ['judul' => 'Data Level']);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_level' => 'required|string|max:255|unique:level,nama_level',
            'deskripsi_level' => 'required|string',
            'warna' => 'required|string'
        ]);

        // Ambil urutan terbesar, lalu tambah 1
        $urutan_level = Level::max('urutan_level') + 1;

        Level::create([
            'nama_level' => $request->nama_level,
            'deskripsi_level' => $request->deskripsi_level,
            'urutan_level' => $urutan_level,
            'warna' => $request->warna
        ]);

        return redirect()->route('level')->with('success', 'Berhasil menambahkan level');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_level' => [
                'required',
                'string',
                'max:255',
                Rule::unique('level', 'nama_level')->ignore($id),
            ],
            'deskripsi_level' => 'required|string',
            'warna' => 'required|string'
        ]);

        try {
            $level = Level::findOrFail($id);
            $level->update([
                'nama_level' => $request->nama_level,
                'deskripsi_level' => $request->deskripsi_level,
                'warna' => $request->warna
                // Tidak update urutan_level disini
            ]);

            return redirect()->route('level')->with('success', 'Data level berhasil diupdate');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $level = Level::find($id);

            DB::table('level_murid')->where('id_level', $id)->delete();

            $level->delete();

            return redirect()->route('level')->with('success', 'Berhasil menghapus level');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus level: ' . $e->getMessage()]);
        }
    }

    public function updateUrutan(Request $request)
    {
        try {
            $order = $request->input('order');

            foreach ($order as $item) {
                Level::where('id', $item['id'])
                    ->update(['urutan_level' => $item['position']]);
            }

            return response()->json(['success' => 'Urutan level berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui urutan level: ' . $e->getMessage()], 500);
        }
    }
}
