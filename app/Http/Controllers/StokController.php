<?php
namespace App\Http\Controllers;
use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory; // import excel

class StokController extends Controller
{
    public function index()
    {
        return view('stok.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar Stok',
                'list' => ['Home', 'Stok']
            ],
            'page' => (object) [
                'title' => 'Daftar stok yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'stok',
            'stok' => StokModel::all(),
            'supplier' => SupplierModel::all(), // Tambahkan ini untuk mengirim data supplier
        ]);
    }

    public function list(Request $request)
    {
        // Ambil query stok dan tambahkan relasi yang dibutuhkan
        $query = StokModel::with(['barang', 'user', 'supplier']);
        
        // Jika terdapat filter supplier_id dari request, tambahkan filter ke query
        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $query->where('supplier_id', $request->supplier_id);
        }

        $stoks = $query->get();
        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                return '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ' .
                    '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ' .
                    '<button onclick="modalAction(\'' . url('/stok/' . $stok->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function create()
    {
        return view('stok.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Stok',
                'list' => ['Home', 'Stok', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah stok baru'
            ],
            'activeMenu' => 'stok',
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);
        StokModel::create($request->all());
        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }
    public function show(string $id)
    {
        $stok = StokModel::with(['supplier', 'barang', 'user'])->findOrFail($id);
        return view('stok.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Stok',
                'list' => ['Home', 'Stok', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail stok'
            ],
            'activeMenu' => 'stok',
            'stok' => $stok,
        ]);
    }
    public function edit(string $id)
    {
        $stok = StokModel::findOrFail($id);
        return view('stok.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit Stok',
                'list' => ['Home', 'Stok', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit stok'
            ],
            'activeMenu' => 'stok',
            'stok' => $stok,
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer',
        ]);
        StokModel::findOrFail($id)->update($request->all());
        return redirect('/stok')->with('success', "Data stok berhasil diubah");
    }
    public function destroy(string $id)
    {
        $stok = StokModel::find($id);
        if (!$stok) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }
        try {
            $stok->delete();
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // AJAX Methods
    public function create_ajax()
    {
        return view('stok.create_ajax', [
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }
    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            StokModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }
        return redirect('/');
    }
    public function edit_ajax(string $id)
    {
        $stok = StokModel::findOrFail($id);
        return view('stok.edit_ajax', [
            'stok' => $stok,
            'supplier' => SupplierModel::all(),
            'barang' => BarangModel::all(),
            'user' => UserModel::all(),
        ]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'supplier_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'user_id' => 'required|integer',
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function show_ajax(string $id)
    {
        $stok = StokModel::find($id);
        if ($stok) {
            return view('stok.show_ajax', ['stok' => $stok]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('stok.import');
    }
    
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi file harus berformat .xlsx dan ukuran maksimal 1MB
            $rules = [
                'file_stok' => ['required', 'mimes:xlsx', 'max:1024']
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            // Jika validasi gagal, kirimkan response error
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
    
            // Ambil file dari request
            $file = $request->file('file_stok');
    
            // Load reader untuk file Excel
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true); // Hanya membaca data
    
            // Load file Excel
            $spreadsheet = $reader->load($file->getRealPath());
    
            // Ambil sheet yang aktif
            $sheet = $spreadsheet->getActiveSheet();
    
            // Ambil data dari Excel dalam bentuk array
            $data = $sheet->toArray(null, false, true, true);
    
            // Variabel untuk menampung data yang akan diinsert
            $insert = [];
    
            // Jika data lebih dari 1 baris
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    // Baris pertama adalah header, jadi dilewati
                    if ($baris > 1) {
                        $insert[] = [
                            'supplier_id' => $value['A'],
                            'barang_id' => $value['B'],
                            'user_id' => $value['C'],
                            'stok_tanggal' => $value['D'],
                            'stok_jumlah' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }
    
                // Jika ada data yang valid, lakukan insert
                if (count($insert) > 0) {
                    // Insert data ke database, jika data sudah ada, maka diabaikan
                    StokModel::insertOrIgnore($insert);
                }
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
    
        return redirect('/');
    }
    
    public function export_excel()
    {
        $stok = StokModel::select('supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->orderBy('stok_tanggal')
            ->with(['supplier', 'barang', 'user'])
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'ID Supplier');
        $sheet->setCellValue('C1', 'ID Barang');
        $sheet->setCellValue('D1', 'ID User');
        $sheet->setCellValue('E1', 'Tanggal Stok');
        $sheet->setCellValue('F1', 'Jumlah Stok');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;

        foreach ($stok as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->supplier->supplier_nama);
            $sheet->setCellValue('C'.$baris, $value->barang->barang_nama);
            $sheet->setCellValue('D'.$baris, $value->user->nama);
            $sheet->setCellValue('E'.$baris, $value->stok_tanggal);
            $sheet->setCellValue('F'.$baris, $value->stok_jumlah);
            $baris++;
            $no++;
        }

        foreach(range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Stok');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        // Ambil data stok
        $stok = StokModel::with(['supplier', 'barang', 'user'])
            ->get();

        // Load view untuk PDF, gunakan Barryvdh\DomPDF\Facade\Pdf
        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);

        // Set ukuran kertas dan orientasi (A4, portrait)
        $pdf->setPaper('a4', 'portrait');

        // Jika ada gambar dari URL, set isRemoteEnabled ke true
        $pdf->setOption("isRemoteEnabled", true);

        // Render dan stream PDF
        return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
    }

}