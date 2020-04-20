<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mobilmodel;
use Illuminate\Support\Facades\Validator;
use Auth;

class Mobilcontroller extends Controller
{
    public function store(Request $req)
    {
        if(Auth::user()->level=='admin'){

        $validator=Validator::make($req->all(),
            [
                'nama_mobil'=>'required',
                'biaya'=>'required',
                'stok'=>'required',
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Mobilmodel::create([
            'nama_mobil'=>$req->nama_mobil,
            'biaya'=>$req->biaya,
            'stok'=>$req->stok,
        ]);
        if($simpan){
            $status='sukses';
            $message='Data Mobil Berhasil Ditambahkan';
        } else {
            $status='gagal';
            $message="Data Mobil Gagal Ditambahkan";
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
                'nama_mobil'=>'required',
                'biaya'=>'required',
                'stok'=>'required', 
            ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah=Mobilmodel::where('id',$id)->update([
            'nama_mobil'=>$req->nama_mobil,
            'biaya'=>$req->biaya,
            'stok'=>$req->stok,
        ]);
        if($ubah){
            $status='sukses';
            $message='Data Mobil Berhasil Diubah';
        } else {
            $status='gagal';
            $message="Data Mobil Gagal Diubah";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
    }
    public function destroy($id)
    {
        if(Auth::user()->level=='admin'){
        $hapus=Mobilmodel::where('id',$id)->delete();
        if($hapus){
            $status='sukses';
            $message='Data Mobil Berhasil Dihapus';
        } else {
            $status='gagal';
            $message="Data Mobil Gagal Dihapus";
        }
        return Response()->json(compact('status','message'));
    }else{
        return Response()->json($message='Anda bukan Admin');
    }
}
    public function tampil()
    {
        if(Auth::user()->level=='admin'){
       $data_mobil=Mobilmodel::get();
       $count=$data_mobil->count();
       $arr_data=array();
       foreach($data_mobil as $dt_mb){
           $arr_data[]=array(
               'id'=>$dt_mb->id,
               'nama_mobil'=>$dt_mb->nama_mobil,
               'alamat'=>$dt_mb->biaya,
               'telp'=>$dt_mb->stok
           );
       }
       $status=1;
       return Response()->json(compact('status','count','arr_data'));
    }else{
        return Response()->json($message='Anda bukan Admin');
}
}
}