<?php

namespace App\Http;

use App\Models\HariLibur;
use App\Models\Jadwal;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\Sesi;
use App\Models\WaktuPresensi;
use Carbon\Carbon;

trait JamKerja
{
    protected function jamTutupPagi()
    {
        return Carbon::createFromTimeString('11:00');
    }
    protected function jamBukaSiang()
    {
        return Carbon::createFromTimeString('13:00');
    }
    protected function jamTutupSiang()
    {
        return Carbon::createFromTimeString('14:00');
    }
    protected function jamTutupSore()
    {
        return Carbon::createFromTimeString('19:00');
    }

    protected function jamTutupMalam()
    {
        return Carbon::createFromTimeString('21:00');
    }

    protected function jamBukaTengahMalam()
    {
        return Carbon::createFromTimeString('01:00');
    }

    protected function jamTutupTengahMalam()
    {
        return Carbon::createFromTimeString('02:00');
    }
    protected function jamTutupSubuh()
    {
        return Carbon::createFromTimeString('07:00');
    }

    public function sekarang()
    {
        return now();
    }

    protected function dataPegawai($id_pegawai = null)
    {
        return Pegawai::with(['jabatan'])->where('id', $id_pegawai)->first();
    }

    public function jabatan($id_pegawai = null)
    {
        $data = $this->dataPegawai($id_pegawai);
        return $data->jabatan->nama_jabatan;
    }

    public function cekHariLiburToday()
    {
        $hariLibur = HariLibur::whereDate('tanggal', $this->sekarang())->first();
        return $hariLibur;
    }

    public function cekJadwal($id_pegawai)
    {
        $jadwal = Jadwal::with(['sesi'])->where('pegawai_id', $id_pegawai)->whereDate('tanggal', $this->sekarang())->first();
        return $jadwal;
    }

    public function cekWaktu($id_pegawai)
    {
        $waktuPresensi = [];
        $waktu   = now()->format('H:i:s');
        $hari    = now()->isoFormat('dddd');
        $sesi    = Sesi::where('nama', 'like', "%Sesi Normal%")->first();
        if ($this->jabatan($id_pegawai) == 'Satpam') {
        } else {
            $waktuPresensi = WaktuPresensi::where('hari', $hari)->where('sesi_id', $sesi->id)->first();
        }

        return $waktuPresensi;
    }

    public function rentangWaktu($id_pegawai)
    {
        $today = $this->sekarang();
        $data = [];
        if ($this->jabatan($id_pegawai) == 'Satpam') {
            if ($this->cekJadwal($id_pegawai)) {
                if ($this->cekJadwal($id_pegawai)->sesi->nama == 'off') {
                    $data = [
                        'keterangan' => 'off'
                    ];
                } else {
                    $hari = $today->isoFormat('dddd');
                    $waktuPresensi = WaktuPresensi::where('sesi_id', $this->cekJadwal($id_pegawai)->sesi_id)->where('hari', 'like', "%$hari%")->first();

                    if ($today->between($waktuPresensi->waktu_mulai, $this->jamTutupPagi())) {
                        $data = [
                            'jam' => 'pagi',
                            'mulai' => $waktuPresensi->waktu_mulai,
                            'selesai' => $this->jamTutupPagi(),
                            'keterangan' => 'Jam Pagi',
                        ];
                    } else if ($today->between($this->jamBukaSiang(), $this->jamTutupSiang())) {
                        $data = [
                            'jam' => 'siang',
                            'mulai' => $this->jamBukaSiang(),
                            'selesai' => $this->jamTutupSiang(),
                            'keterangan' => 'Jam Siang'
                        ];
                    } else if ($today->between($waktuPresensi->waktu_selesai, $this->jamTutupSore())) {
                        $data = [
                            'jam' => 'sore',
                            'mulai' => $waktuPresensi->waktu_selesai,
                            'selesai' => $this->jamTutupSore(),
                            'keterangan' => 'Jam Sore'
                        ];
                    } else if ($today->between($waktuPresensi->waktu_mulai, $this->jamTutupMalam())) {
                        $data = [
                            'jam' => 'malam',
                            'mulai' => $waktuPresensi->waktu_mulai,
                            'selesai' => $this->jamTutupMalam(),
                            'keterangan' => 'Jam Malam'
                        ];
                    } else if ($today->between($this->jamBukaTengahMalam(), $this->jamTutupTengahMalam())) {
                        $data = [
                            'jam' => 'tengah malam',
                            'mulai' => $this->jamBukaTengahMalam(),
                            'selesai' => $this->jamTutupTengahMalam(),
                            'keterangan' => 'Jam Tengah Malam'
                        ];
                    } else if ($today->between($waktuPresensi->waktu_selesai, $this->jamTutupSubuh())) {
                        $data = [
                            'jam' => 'subuh',
                            'mulai' => $waktuPresensi->waktu_selesai,
                            'selesai' => $this->jamTutupSubuh(),
                            'keterangan' => 'Jam Subuh'
                        ];
                    }
                }
            } else {
                $data = [
                    'keterangan' => 'off'
                ];
            }
        } else {
            $hari = $today->isoFormat('dddd');
            $sesi    = Sesi::where('nama', 'like', "%Sesi Normal%")->first();
            $waktuPresensi = WaktuPresensi::where('sesi_id', $sesi->id)->where('hari', 'like', "%$hari%")->first();

            if ($today->between($waktuPresensi->waktu_mulai, $this->jamTutupPagi())) {
                $data = [
                    'jam' => 'pagi',
                    'mulai' => $waktuPresensi->waktu_mulai,
                    'selesai' => $this->jamTutupPagi(),
                    'keterangan' => 'Jam Pagi',
                ];
            } else if ($today->between($this->jamBukaSiang(), $this->jamTutupSiang())) {
                $data = [
                    'jam' => 'siang',
                    'mulai' => $this->jamBukaSiang(),
                    'selesai' => $this->jamTutupSiang(),
                    'keterangan' => 'Jam Siang'
                ];
            } else if ($today->between($waktuPresensi->waktu_selesai, $this->jamTutupSore())) {
                $data = [
                    'jam' => 'sore',
                    'mulai' => $waktuPresensi->waktu_selesai,
                    'selesai' => $this->jamTutupSore(),
                    'keterangan' => 'Jam Sore'
                ];
            }
        }

        return $data;
    }

    public function cekKehadiran($id_pegawai)
    {
        $presensi = Presensi::where('pegawai_id', $id_pegawai)->whereDate('waktu', $this->sekarang())->latest()->first();
        if ($presensi) {
            $waktu = $this->cekWaktu($id_pegawai);
            $sekarang = $this->sekarang();
            $waktuKehadiran = Carbon::parse($presensi->waktu);

            $rentangWaktu = $this->rentangWaktu($id_pegawai);
            if ($rentangWaktu) {
                if ($waktuKehadiran->between($rentangWaktu['mulai'], $rentangWaktu['selesai'])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function presensi($id_pegawai)
    {
        $data = $this->rentangWaktu($id_pegawai);

        if ($this->cekKehadiran($id_pegawai)) {
            $data = [];
        } else {
            if ($this->jabatan($id_pegawai) != 'satpam') {
                if ($this->cekHariLiburToday()) {
                    $data = [
                        'keterangan' => 'libur'
                    ];
                }
            }
        }
        return $data;
    }
}
