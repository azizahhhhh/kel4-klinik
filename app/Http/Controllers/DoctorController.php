<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index() {
        //$jadwal_doctor = DB::select('select * from doctors');
        // $price_list = $list_price[0];
        // return $price_list->service;

        //Membaca semua baris dari table doctors menggunakan query builders
        // $jadwal_doctor = DB::table('doctors')
        //     ->orderBy('name')
        //     ->get();
        $doctors = Doctor::orderBy('name')->get();

        return view('page.doctor.index', [
            'doctors' => $doctors
        ]);
    }

    public function create(Request $req){
        return view('page.doctor.create',[
            'title' => 'Create Doctor'
        ]);
    }

    public function edit($id){
        // $item = DB::table('doctors')->where('id', $id)->first();
        $item = Doctor::find($id);
        if (!$item) {
            return "data tidak ditemukan";
        }

        return view('page.doctor.edit', [
            'doctor' => $item,
            'form_action' => 'update',
        ]);
    }


    public function simpan( Request $req){
        $name = $req->input('name');
        $time = $req->input('time');
        // $sql = "insert into doctors (name, time) value (?, ?)";
        // DB::insert($sql, [$name, $time]);
        //melakukan insert ke table doctors menggunakan query builders
        // $result = DB::table('doctors')->insert([
        //     'name'=> $name,
        //     'time'=> $time,
        // ]);

        $doctor = new Doctor();
        $doctor->name = $name;
        $doctor->time = $time;
        $doctor->save();

        // if($result ==true){
        //     //lakukan sesuatu jika gagal insert
        // }
        // echo 'berhasil disimpan';
        return redirect('/doctor')->with('success', 'Berhasil menambahkan dokter');
    }

    public function update( Request $req){
        $name = $req->input('name');
        $time = $req->input('time');
        $id = intval($req->input('id'));

        // $sql = "update doctors set name=?, time=? where id=?";
        // DB::update($sql, [$name, $time, $id]);

        //mengupdate data doctors berdasarkan id tertentu menggunakan query builders
        // DB::table('doctors')
        //     ->where([
        //         'id' => $id
        //     ])
        //     ->update([
        //         'name' => $name,
        //         'time' => $time,
        //     ]);

        //ORM
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return "data tidak ditemukan";
        }
    
        $doctor->name = $name;
        $doctor->time = $time;
        $doctor->save();

        //echo 'berhasil disimpan' ;
        return redirect('/doctor');
    }

    public function hapus( $id)
    {
        // DB::delete('delete from doctors where id='.$id);

        //menghapus data doctor menggunakan query builders
        // DB::table('doctors')
        // ->where([
        //     'id' => $id,
        // ])
        // ->delete();

        //ORM
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return "data tidak ditemukan";
        }
    
        $doctor->delete();
        return redirect('/doctor')->with('success', 'Berhasil menghapus dokter!');
    }

}
