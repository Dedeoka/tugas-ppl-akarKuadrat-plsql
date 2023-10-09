<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\test;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function index()
    {
        try {
            $data = DB::table('tests')->select('id', 'bilangan', 'akar_kuadrat', 'waktu')->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data.'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bilangan' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validasi gagal.'], 422);
        }

        // Ambil nilai input
        $bilangan = $request->input('bilangan');

        // Panggil stored procedure untuk menyimpan data ke dalam tabel
        try {
            $result = DB::select('CALL unit_test(?)', [$bilangan]);

            // Mengirim hasil waktu dan hasil kuadrat sebagai respons JSON
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat memanggil stored procedure.'], 500);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
