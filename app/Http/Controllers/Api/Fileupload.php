<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fileupload as filemodel;
class Fileupload extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
          $fields=$request->validate([
            'hoa_id'=>'required|string|exists:users,id',
            'pdf'=>'required|mimes:pdf|max:10000'
        ]);


        $filepdf = $request->file('pdf');  
        $destinationPath = 'media/pdf/';
        $archivepdf = date('YmdHis') . "." . $filepdf->getClientOriginalExtension();

        $filepdf->move($destinationPath, $archivepdf);

            

        $file=filemodel::create([
        'hoa_id'=>$request->hoa_id,
        'path'=>$destinationPath.''.$archivepdf ,
        ]);

        




         return response()->json([
                'status' => true,
                'message' => 'PDF Added Successfully',
                'questions' =>[
                        json_decode(
                            json_encode(
                            array('hoa_id' => $request->hoa_id, 'path' => $destinationPath.''.$archivepdf)
                        ), true, JSON_UNESCAPED_SLASHES),
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }



    }


}
