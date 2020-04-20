<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggotamodel;
use App\Petugasmodel;
use App\Mobilmodel;
use App\Penyewaanmodel;
use App\Detailmodel;
use JWTAuth;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;


class Penyewaancontroller extends Controller
{
  public function report($tgl_awal, $tgl_akhir){
    if(Auth::user()->level=='petugas'){
      $penyewaan=DB::table('table_penyewaan')
      ->join('table_anggota','table_anggota.id','=','table_penyewaan.id_anggota')
      ->join('table_petugas','table_petugas.id','=','table_penyewaan.id_petugas')
      ->where('table_penyewaan.tgl', '>=', $tgl_awal)
      ->where('table_penyewaan.tgl', '<=', $tgl_akhir)
      ->select('table_penyewaan.id', 'tgl', 'nama_anggota', 'alamat', 'table_anggota.telp', 'tgl_kembali')
      ->get();

      $data=array(); $no=0;
      foreach ($penyewaan as $pw){
        $data[$no]['tgl'] = $pw->tgl;
        $data[$no]['nama_anggota'] = $pw->nama_anggota;
        $data[$no]['alamat'] = $pw->alamat;
        $data[$no]['telp'] = $pw->telp;
        $data[$no]['tgl_kembali'] = $pw->tgl_kembali; 

        $grand=DB::table('table_detail')->where('id_sewa', $pw->id)->groupBy('id_sewa')
        ->select(DB::raw('sum(subtotal) as grand_total'))->first();

        $data[$no]['grand'] = $grand->grand_total;
        $detail=DB::table('table_detail')->join('mobil', 'mobil.id', '=', 'table_detail.id_mobil')
        ->where('id_sewa', $pw->id)->select('mobil.nama_mobil', 'mobil.biaya', 'table_detail.qty', 'table_detail.subtotal')->get();

        $data[$no]['detail'] = $detail;
      }///
      return response()->json(compact("data"));
    }else{
      return Response()->json($message='Anda bukan Petugas');
    }
       
  }
      
    

    public function store(Request $request){
      if(Auth::user()->level=='petugas'){
      $validator=Validator::make($request->all(),
        [
          'tgl'=>'required',
          'id_anggota'=>'required',
          'id_petugas'=>'required',
          'tgl_kembali'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Penyewaanmodel::create([
        'tgl'=>$request->tgl,
        'id_anggota'=>$request->id_anggota,
        'id_petugas'=>$request->id_petugas,
        'tgl_kembali'=>$request->tgl_kembali
      ]);
      $status=1;
      $message="Penyewaan Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else{
        return Response()->json($message='Anda bukan Petugas');
      }
    
  }
    }
    public function update($id,Request $request){
      if(Auth::user()->level=='petugas'){
      $validator=Validator::make($request->all(),
        [
            'tgl'=>'required',
            'id_anggota'=>'required',
            'id_petugas'=>'required',
            'tgl_kembali'=>'required' 
        ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }

    $ubah=Penyewaanmodel::where('id',$id)->update([
        'tgl'=>$request->tgl,
        'id_anggota'=>$request->id_anggota,
        'id_petugas'=>$request->id_petugas,
        'tgl_kembali'=>$request->tgl_kembali
    ]);
    $status=1;
    $message="Penyewaan Berhasil Diubah";
    if($ubah){
      return Response()->json(compact('status','message'));
    }else{
      return Response()->json($message='Anda bukan Petugas');
    }
      }
    }
  public function destroy($id){
    if(Auth::user()->level=='petugas'){
    $hapus=Penyewaanmodel::where('id',$id)->delete();
    $status=1;
    $message="Penyewaan Berhasil Dihapus";
    if($hapus){
      return Response()->json(compact('status','message'));
    }else{
      return Response()->json($message='Anda bukan Petugas');
    }
  
}


  }



  //detail_pinjam

  public function simpan(Request $request){
    if(Auth::user()->level=='petugas'){
    $validator=Validator::make($request->all(),
      [
        'id_sewa'=>'required',
        'id_mobil'=>'required',
        'qty'=>'required'
      ]
    );

    if($validator->fails()){
      return Response()->json($validator->errors());
    }

    $harga = Mobilmodel::where('id', $request->id_mobil)->first();
    $subtotal = $harga->biaya * $request->qty;

    $simpan=Detailmodel::create([
      'id_sewa'=>$request->id_sewa,
      'id_mobil'=>$request->id_mobil,
      'subtotal'=>$subtotal,
      'qty' =>$request->qty
    ]);
    $status=1;
    $message="Detail Penyewaan Berhasil Ditambahkan";
    if($simpan){
      return Response()->json(compact('status','message'));
  }else{
    return Response()->json($message='Anda bukan Petugas');
  }
  }
  }
  public function ubah($id,Request $request){
    if(Auth::user()->level=='petugas'){
    $validator=Validator::make($request->all(),
      [
        'id_sewa'=>'required',
        'id_mobil'=>'required',
        'subtotal'=>'required'
      ]
  );

  if($validator->fails()){
    return Response()->json($validator->errors());
  }

  $ubah=Detailmodel::where('id',$id)->update([
      'id_sewa'=>$request->id_sewa,
      'id_mobil'=>$request->id_mobil,
      'subtotal'=>$request->subtotal
  ]);
  $status=1;
  $message="Detail Penyewaan Berhasil Diubah";
  if($ubah){
    return Response()->json(compact('status','message'));
  }else{
    return Response()->json($message='Anda bukan Petugas');
  }
    }
  }

public function hapus($id){
  if(Auth::user()->level=='petugas'){
  $hapus=Detailmodel::where('id',$id)->delete();
  $status=1;
  $message="Detail Penyewaan Berhasil Dihapus";
  if($hapus){
    return Response()->json(compact('status','message'));
  }else{
    return Response()->json($message='Anda bukan Petugas');
  }
  }
}
public function tampil_detail(){
  if(Auth::user()->level=='petugas'){
  $detail=DB::table(table_detail)
  ->join('table_penyewaan','table_penyewaan.id', '=', 'table_detail.id_sewa')
  ->join('table_mobil', 'table_mobil.id', '=', 'table_detail.id_mobil')
  ->select('table_mobil.nama_mobil', 'table_mobil.biaya', 'table_detail.qty', 'table_ detail.subtotal')
  ->get();
  $count_detail->count();
  return response()->json(compact('detail', 'count'));


  
  }else{
    return Response()->json($message='Anda bukan Petugas');
}
}
}