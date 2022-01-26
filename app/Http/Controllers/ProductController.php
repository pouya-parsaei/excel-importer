<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Jobs\ProductsDownloadImagesProcess;
use App\Models\JobBatch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
class ProductController extends Controller
{
    public function importForm()
    {
        return view('import-form');
    }

    public function import(Request $request)
    {
        Excel::import(new ProductImport, $request->file);

        $products = Product::select('id', 'image_url')->orderBy('id','desc')->get();

        $batch = Bus::batch([])->dispatch();
        foreach ($products as $product) {
            $batch->add(new ProductsDownloadImagesProcess($product));
        }

        // update session id when process new batch.
        session()->put('latBatchId',$batch->id);
        return redirect('/progress?id='. $batch->id);
    }

    //function gets the progress while obs execute.
    public function imageDownloadingProgress(Request $request)
    {
        try{
            $batchId = $request->id ?? session()->get('lastBatchId');
            if(JobBatch::where('id',$batchId)->count()){
                $response = JobBatch::where('id',$batchId)->first();
                return response()->json($response);
            }
        }
        catch(\Exception $e){
            Log::error($e);
            dd($e);
        }
    }

    public function progress()
    {
        return view('progress');
    }

    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    public function downloadFromUrl($products)
    {

    }

    public function test()
    {
    }

}
