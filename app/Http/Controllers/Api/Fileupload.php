<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fileupload as filemodel;
use File;
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
            'hoa_id'=>'required',
            'pdf'=>'required|mimes:pdf|max:10000',
            'status'=>'required',
        ]);


        $filepdf = $request->file('pdf');  
        $destinationPath = 'media/pdf/';
        $archivepdf = date('YmdHis') . "." . $filepdf->getClientOriginalExtension();

        $filepdf->move($destinationPath, $archivepdf);

        
        $fLupload=filemodel::where('hoa_id', $request->hoa_id)->where('status', $request->status)->count();



        //check if exist path and delete

        if($fLupload>0){
             $fLupload=filemodel::where('hoa_id', $request->hoa_id)->where('status', $request->status)->first();

            if (File::exists(public_path($fLupload->path))) {
            File::delete($fLupload->path);
            }

        }
        

      
         //create or update file upload


           filemodel::UpdateOrCreate(
                ['hoa_id'=>$request->hoa_id,'status'=>$request->status ],
                [    
                 'hoa_id'=>$request->hoa_id,  
                 'path'=>$destinationPath.''.$archivepdf,
                 'status'=>$request->status   
               
                ]
            );
        




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

    public function get_fileupload(Request $request,$hoa_id,$status)
    {

        try {
     

        $fLupload=filemodel::where('hoa_id', $hoa_id)->where('status', $status)->count();


        if($fLupload>0){
              $fLupload=filemodel::where('hoa_id', $hoa_id)->where('status', $status)->first();

                return response()->json([
                'status' => true,
                'message' => 'File successfully fetch',
                'questions' =>[
                        json_decode(
                            json_encode(
                            array('id' => $fLupload->id,
                                'hoa_id' => $fLupload->hoa_id, 
                                'path' => $fLupload->path,
                                'status' => $fLupload->status,
                                'created_at' => $fLupload->created_at,
                                'updated_at' => $fLupload->updated_at)
                        ), true, JSON_UNESCAPED_SLASHES),
                ]
            ], 200);
        }else{
              return response()->json([
                'status' => true,
                'message' => 'no file found',
            ], 200);
        }


           } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }    


}
