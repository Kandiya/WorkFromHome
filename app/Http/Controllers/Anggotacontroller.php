<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggotamodel;
use Illuminate\Support\Facades\Validator;
use Auth;

class Anggotacontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=='admin'){

        $validator=Validator::make($req->all(),
            [
                'nama_anggota'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Anggotamodel::create([
            'nama_anggota'=>$req->nama_anggota,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        if($simpan){
            $status='sukses';
            $message='Data Pelanggan Berhasil Ditambahkan';
        } else {
            $status='gagal';
            $message="Data Pelanggan Gagal Ditambahkan";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
    }

}
    public function update($id, Request $req)
    {
        if(Auth::user()->level=='admin'){
        $validator=Validator::make($req->all(),
            [
                'nama_anggota'=>'required',
                'alamat'=>'required',
                'telp'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah=Anggotamodel::where('id',$id)->update([
            'nama_anggota'=>$req->nama_anggota,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
        ]);
        if($ubah){
            $status='sukses';
            $message='Data Pelanggan Berhasil Diubah';
        } else {
            $status='gagal';
            $message="Data Pelanggan Gagal Diubah";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
    }
    public function destroy($id)
    {
        if(Auth::user()->level=='admin'){
        $hapus=Anggotamodel::where('id',$id)->delete();
        if($hapus){
            $status='sukses';
            $message='Data Pelanggan Berhasil Dihapus';
        } else {
            $status='gagal';
            $message="Data Pelanggan Gagal Dihapus";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
    }
}
    public function tampil()
    {
        if(Auth::user()->level=='admin'){
       $data_anggota=Anggotamodel::get();
       $count=$data_anggota->count();
       $arr_data=array();
       foreach($data_anggota as $dt_ag){
           $arr_data[]=array(
               'id'=>$dt_ag->id,
               'nama_anggota'=>$dt_ag->nama_anggota,
               'alamat'=>$dt_ag->alamat,
               'telp'=>$dt_ag->telp
           );
       }
       $status=1;
       return Response()->json(compact('status','count','arr_data'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
}
}