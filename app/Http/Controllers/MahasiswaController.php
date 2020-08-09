<?php
namespace App\Http\Controllers;
use App\Mahasiswa;
use App\Prodi;
use DataTables;
use Illuminate\Http\Request;
class MahasiswaController extends Controller
{

    public function index()
   {
        return view('mahasiswa.index');
   }
    public function mhs_list()
   {
        $mhs = Mahasiswa::with('mprodi')->get();
        return Datatables::of($mhs)
                ->addIndexColumn()
                ->addColumn('action', function ($mhs) {
                    $action = '<a class="text-primary" href="/mhs/edit/'.$mhs->nim.'">Edit</a>';
                    $action .= ' | <a class="text-danger" href="/mhs/delete/'.$mhs->nim.'">Hapus</a>';
                    return $action;
               })->make();
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
   {
        $prodi = Prodi::all();
        return view('mahasiswa.create', compact('prodi'));
   }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
   {
        $request->validate([
            'nim' => 'required|digits:10',
            'nama_lengkap' => 'required',
       ]);
       Mahasiswa::create($request->all());
       return redirect()->route('mhs.index')->with('success','Data berhasil ditambahkan');
  }
   
   public function show(Mahasiswa $mahasiswa)
  {
       
  }
   
   public function edit(Mahasiswa $mahasiswa, $id)
  {
       $prodi = Prodi::all();
       $mhs = Mahasiswa::find($id);
       return view('mahasiswa.edit', compact('prodi', 'mhs'));
  }
  
   public function update(Request $request, Mahasiswa $mahasiswa)
  {
       $request->validate([
           'nama_lengkap' => 'required',
      ]);
       $mahasiswa->update($request->all());
       return redirect()->route('mhs.index')->with('success','Data berhasil diupdate');
  }
  
   public function destroy(Mahasiswa $mahasiswa)
  {
       $mahasiswa->delete();
 
       return redirect()->route('mhs.index') ->with
       ('success','Data Berhasil Dihapus');
          }
        }