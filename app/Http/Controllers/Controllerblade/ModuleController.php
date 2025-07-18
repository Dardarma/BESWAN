<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeModul;
use App\Models\E_book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('table_search');
        $paginate = $request->input('paginate', 10);

        $modul = E_book::select('id', 'judul', 'deskripsi', 'url_file', 'author', 'tumbnail','terbitan')
            ->orderBy('created_at', 'desc')
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })
            ->paginate($paginate);

        return view('admin_page.module.module_list', compact('modul'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */


    public function store(storeModul $request)
    {
        try {
            // Validasi file exists
            if (!$request->hasFile('url_file') || !$request->hasFile('tumbnail')) {
                return redirect()->back()->withErrors(['error' => 'File dan thumbnail harus diupload']);
            }

            // Validasi file upload sukses
            if (!$request->file('url_file')->isValid() || !$request->file('tumbnail')->isValid()) {
                return redirect()->back()->withErrors(['error' => 'File upload gagal, silakan coba lagi']);
            }

            // Simpan file ke storage
            $path_file = $request->file('url_file')->store('public/module');
            $path_tumbnail = $request->file('tumbnail')->store('public/tumbnail_module');

            // Validasi file tersimpan
            if (!$path_file || !$path_tumbnail) {
                return redirect()->back()->withErrors(['error' => 'Gagal menyimpan file ke storage']);
            }

            // Simpan data ke database
            E_book::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'url_file' => $path_file,
                'author' => $request->author,
                'tumbnail' => $path_tumbnail,
                'terbitan' => $request->terbitan,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
        try {
            $modul = E_book::findOrFail($id);

            $modul->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'author' => $request->author,
                'terbitan' => $request->terbitan,
            ]);

            if ($request->hasFile('url_file')) {
                Storage::delete($modul->url_file);

                $path_file = $request->file('url_file')->store('public/module');
                $modul->url_file = $path_file;
            }

            if ($request->hasFile('tumbnail')) {
                Storage::delete($modul->tumbnail);

                $path_tumbnail = $request->file('tumbnail')->store('public/tumbnail_module');
                $modul->tumbnail = $path_tumbnail;
            }

            $modul->save();

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        try {
            $modul = E_book::findOrFail($id);

            // Hapus file dari storage
            if ($modul->url_file) {
                Storage::delete($modul->url_file);
            }
            if ($modul->tumbnail) {
                Storage::delete($modul->tumbnail);
            }

            // Hapus data dari database
            $modul->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function ModuleUser(Request $request)
    {
        try {
            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);

            $ebook = E_book::select('id', 'judul', 'deskripsi', 'url_file', 'author', 'tumbnail', 'terbitan')
                ->when($search, function ($query) use ($search) {
                    $query->where('judul', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                })
                ->paginate($paginate);

            return view('user_page.e-book.e_book_list', compact('ebook'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
