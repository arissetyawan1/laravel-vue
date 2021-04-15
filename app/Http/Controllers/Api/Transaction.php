<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransactionResource;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Transaction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTransaction = ModelsTransaction::orderBy('time', 'DESC')->get();
        return response()->json([
            'message' => "Data berhasil dipanggil",
            "data" => TransactionResource::collection($dataTransaction),
            "kode" => Response::HTTP_OK
        ]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation rules
        $request->validate([
            "judul" => "required|min:2",
            "biaya" => "required|integer",
            "jenis" => "required|in:pengeluaran,pemasukan"
        ], [
            "required" => "Harus Diisi",
            "min" => "Ini dengan minimal 2 karakter",
            "integer" => "Harus diisi dengan angka",
            "in" => "Pilih antara pengeluaran atau pemasukan"
        ]);

        $tambahData = ModelsTransaction::create([
            "judul" => $request->judul,
            "biaya" => $request->biaya,
            "jenis" => $request->jenis
        ]);

        if ($tambahData) {
            return response()->json([
                'message' => "data berhasil disimpan",
                "judul" => $tambahData['judul'],
                "jenis" => $tambahData['jenis'],
                "kode" => Response::HTTP_CREATED
            ]);
        } else {
            return response()->json([
                'message' => "data gagal ditambahkan",
                "kode" => Response::HTTP_NOT_ACCEPTABLE
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getById =  ModelsTransaction::find($id);
        if ($getById) {
            return response()->json([
                'message' => "Data ditemukan",
                "data" => new TransactionResource($getById),
                "kode" => Response::HTTP_OK,
            ]);
        } else {
            return response()->json([
                'message'  => 'Data tidak ditemukan',
                'kode' => Response::HTTP_NOT_FOUND
            ]);
        }
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
        $request->validate([
            "judul" => "required|min:2",
            "biaya" => "required|integer",
            "jenis" => "required|in:pengeluaran,pemasukan"
        ], [
            "required" => "Harus Diisi",
            "min" => "Ini dengan minimal 2 karakter",
            "integer" => "Harus diisi dengan angka",
            "in" => "Pilih antara pengeluaran atau pemasukan"
        ]);

        $updateData = ModelsTransaction::find($id)->update([
            "judul" => $request->judul,
            "biaya" => $request->biaya,
            "jenis" => $request->jenis
        ]);
        $pembaruanData = ModelsTransaction::find($id);
        // return update
        return response()->json([
            "Message" => "data berhasil disimpan",
            "Pembaharuan Data Transaksi" => new TransactionResource($pembaruanData),
            "Kode Response" => Response::HTTP_OK
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete by it's primary key using destroy method
        $getById = ModelsTransaction::destroy($id);
        if ($getById) {
            return response()->json([
                "Message" => "Berhasil Dihapus",
                "Kode Respon" => Response::HTTP_OK
            ]);
        } else {
            return response()->json([
                "Message" => "data tidak ditemukan",
                "Kode Respon" => Response::HTTP_NOT_FOUND
            ]);
        }
    }
}
