<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pegawai;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\JamKerja;

class PresensiController extends Controller
{
    use JamKerja;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function pegawai(Request $request)
    {
        $search = $request->search;
        $data = [];
        if ($search == '') {
            $datas = Pegawai::with(['unit_kerja', 'jabatan'])->limit(5)->get();
        } else {
            $datas = Pegawai::with(['unit_kerja', 'jabatan'])->where('nama_pegawai', 'like', "%$search%")->get();
        }

        if ($datas) {
            foreach ($datas as $value) {
                $data[] = [
                    'id' => $value->id,
                    'text' => $value->nama_pegawai,
                ];
            }
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'message' => 'Berhasil Melakukan Presensi',
            'status' => 'success'
        ];
        if ($this->presensi($request->pegawai_id)) {
            if ($this->presensi($request->pegawai_id)['keterangan'] == 'off') {
                $message = [
                    'message' => 'Anda Sedang Off',
                    'status' => 'error'
                ];
            } else if ($this->presensi($request->pegawai_id)['keterangan'] == 'libur') {
                $message = [
                    'message' => 'Sekarang Hari Libur',
                    'status' => 'error'
                ];
            } else {
                $img = $request->foto_presensi;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.png';
                $file = $folderPath . $fileName;
                $foto = Storage::disk('public')->put($file, $image_base64);

                $mytime = Carbon::now();

                $create = Presensi::create([
                    'pegawai_id'    => $request->pegawai_id,
                    'waktu'         => $mytime,
                    'foto_presensi' => $file,
                    'keterangan'    => $this->presensi($request->pegawai_id)['keterangan'],
                    'ip_address'    => $request->ip()
                ]);
            }
        } else {
            $message = [
                'message' => 'Sudah Melakukan Presensi',
                'status' => 'error'
            ];
        }
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
