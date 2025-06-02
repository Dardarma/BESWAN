<?php

namespace App\Http\Controllers\controllerblade;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);

            $article = Materi::select('materi.id', 'materi.judul', 'materi.deskripsi', 'materi.id_level', 'level.urutan_level',)
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->when($search, function ($query, $search) {
                    $query->where('materi.judul', 'like', '%' . $search . '%')
                        ->orWhere('materi.deskripsi', 'like', '%' . $search . '%')
                        ->orWhere('level.urutan_level', 'like', '%' . $search . '%');
                })
                ->paginate($paginate);


            return view('admin_page.article.index', compact('article'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $level = Level::select('id', 'urutan_level', 'nama_level')->get();

        return view('admin_page.article.add', compact('level'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            request()->validate([
                'judul' => 'required|string',
                'deskripsi' => 'required|string',
                'id_level' => 'required|integer',
                'konten' => 'required'
            ]);


            Materi::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'id_level' => $request->id_level,
                'konten' => $request->konten,
                'created_by' => auth()->user()->name,
                'updated_by' => auth()->user()->name
            ]);

            return redirect()->route('article')->with(['success' => 'Data berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $article = Materi::findorfail($id);
            $level = Level::select('id', 'urutan_level', 'nama_level')->get();

            return view('admin_page.article.edit', compact('article', 'level'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            request()->validate([
                'judul' => 'required|string',
                'deskripsi' => 'required|string',
                'id_level' => 'required|integer',
                'konten' => 'required'
            ]);

            $article = Materi::findorfail($id);
            $article->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'id_level' => $request->id_level,
                'konten' => $request->konten,
                'updated_by' => auth()->user()->name
            ]);

            return redirect()->route('article')->with(['success' => 'Data berhasil diubah']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $article = Materi::findorfail($id);
            $article->delete();
            return redirect()->back()->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function materi(Request $request)
    {
        try {
            $role = Auth::user()->role;
            $paginate = $request->input('paginate', 10);
            $search = $request->input('table_search');
            $levelFilter = $request->input('level');

            // Query dasar
            $materiQuery = Materi::select(
                'materi.id',
                'materi.judul',
                'materi.deskripsi',
                'materi.id_level',
                'level.urutan_level',
                'level.warna'
            )
                ->join('level', 'materi.id_level', '=', 'level.id');

            // Ambil level yang dimiliki user
            $userLevelIds = [];
            if (!in_array($role, ['superadmin', 'teacher'])) {
                $userLevelIds = auth()->user()->levels->pluck('id')->toArray();
                $materiQuery->whereIn('materi.id_level', $userLevelIds);
            }

            // Filter berdasarkan level yang dipilih
            if ($levelFilter) {
                // Pastikan level yang dipilih adalah level yang dimiliki user (untuk role user)
                if ($role == 'user' && !in_array($levelFilter, $userLevelIds)) {
                    // Jika user mencoba mengakses level yang tidak dimiliki, abaikan filter
                } else {
                    $materiQuery->where('materi.id_level', $levelFilter);
                }
            }

            // Search
            if ($search) {
                $materiQuery->where(function ($query) use ($search) {
                    $query->where('materi.judul', 'like', "%{$search}%")
                        ->orWhere('materi.deskripsi', 'like', "%{$search}%")
                        ->orWhere('level.urutan_level', 'like', "%{$search}%");
                });
            }

            // Sorting dan Pagination
            $materi = $materiQuery
                ->orderBy('level.urutan_level', 'desc')
                ->orderBy('materi.created_at', 'desc')
                ->paginate($paginate);


            return view('user_page.materi.materi_list', compact('materi'), [
                'judul' => 'Data Materi'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function materiDetail($id)
    {
        try {

            $materi = Materi::select('materi.id', 'materi.judul', 'materi.deskripsi', 'materi.konten', 'materi.id_level', 'level.urutan_level', 'level.nama_level', 'media.id as id_media', 'media.url_video')
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->leftjoin('media', 'materi.id', '=', 'media.id_materi')
                ->where('materi.id', $id)
                ->firstOrFail();

            // dd($materi);
            return view('user_page.materi.materi_isi', compact('materi'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function materiDownload($id)
    {
        try {
            // Increase execution time for this request
            ini_set('max_execution_time', 120);
            
            $materi = Materi::findOrFail($id);
            
            // Get the content from materi.konten field
            $content = $materi->konten;
            
            // Remove all images from the content to avoid rendering issues and improve performance
            $content = preg_replace('/<img[^>]+>/i', '<p><i>[Gambar tersedia pada versi online]</i></p>', $content);
            
            // Create a simple HTML structure for the PDF
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>' . $materi->judul . '</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        margin: 2cm;
                    }
                    h1 {
                        text-align: center;
                        margin-bottom: 20px;
                        font-size: 18px;
                    }
                    .description {
                        font-style: italic;
                        margin-bottom: 20px;
                        border-bottom: 1px solid #ccc;
                        padding-bottom: 10px;
                    }
                    .content {
                        text-align: justify;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 12px;
                        color: #666;
                    }
                    .image-placeholder {
                        text-align: center;
                        color: #888;
                        font-style: italic;
                        padding: 10px;
                        border: 1px dashed #ccc;
                        margin: 10px 0;
                    }
                </style>
            </head>
            <body>
                <h1>' . $materi->judul . '</h1>
                <div class="description">' . $materi->deskripsi . '</div>
                <div class="content">' . $content . '</div>
                <div class="footer">
                    <p>Level: ' . $materi->level->nama_level . '</p>
                    <p>Downloaded on: ' . date('Y-m-d H:i:s') . '</p>
                    <p>Catatan: Untuk melihat gambar, silakan akses materi ini secara online.</p>
                </div>
            </body>
            </html>';
            
            // Generate the PDF with DomPDF
            $pdf = PDF::loadHTML($html);
            
            // Set paper size to A4
            $pdf->setPaper('a4');
            
            // Set basic options (since we're not loading images, we can keep this minimal)
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => false, // Disable remote content since we're not loading images
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => false,
                'dpi' => 96
            ]);
            
            // Generate a filename for the PDF
            $filename = str_replace(' ', '_', $materi->judul) . '.pdf';
            
            // Return the PDF as a download
            return $pdf->download($filename);

        } catch (\Exception $e) {
            // Log the error
            return redirect()->back()->with(['error' => 'Gagal membuat PDF: ' . $e->getMessage()]);
        }
    }
}
