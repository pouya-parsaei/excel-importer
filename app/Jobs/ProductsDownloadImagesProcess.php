<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ProductsDownloadImagesProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            // checks if product doesn't have image_url
            if (is_null($this->product->image_url)){
                return;
            }

            $file = public_path('images/' . $this->product->id);

            // checks if file is not uploaded before
            if (!file_exists($file)) {

                // Initialize a file URL to the variable
                $url = $this->product->image_url;

                $file_directory = public_path() . '/images/' . $this->product->id . '/';
                if (!File::exists($file_directory)) {
                    File::makeDirectory($file_directory, $mode = 0777, true, true);
                }

                // Use basename() function to return the base name of file
                $file_name = $file_directory . basename($url) . '.jpg';

                // Use file_get_contents() function to get the file
                // from url and use file_put_contents() function to
                // save the file by using base name
                try{
                file_put_contents($file_name, file_get_contents($url));
                }catch(\Exception $e){
//                    continue;
                }

            }


        }


    public
    function failed(Throwable $exception)
    {
        //
    }

}
