<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Imagick;
//use ImagickPixel;
use thiagoalessio\TesseractOCR\TesseractOCR;
//use Spatie\PdfToImage\Pdf;

class FileController extends Controller
{
    public function upload(Request $request)
    {
//        return response($request,200);

        try{
            $file = $request->file('file');

            $name = date('Y-m-d').'-'.time().'-'.$file->getClientOriginalName();
            $file->move( 'translate/',$name);

            $file = '/translate/' . $name;
            return response($file,200);
        }catch (\Exception $exception){
            return response($exception);
        }

    }

    public function tst2(){
        $image = new Imagick('translate/2022-09-24-1664044177-resume.io_r_08tTDpInc.pdf[0]');
        $image->newImage(1, 1, new ImagickPixel('#ffffff'));
        $image->setImageFormat('png');
        $pngData = $image->getImagesBlob();
        echo str_starts_with($pngData, "\x89PNG\r\n\x1a\n") ? 'Ok' : 'Failed';
    }
    public function tst()
    {
//        $im = new Imagick('translate/2022-09-24-1664044177-resume.io_r_08tTDpInc.pdf[0]');
//        $im->setImageFormat('jpg');
//        header('Content-Type: image/jpeg');
//        echo $im;

//        $image = new Imagick();
//        $image->newImage(1, 1, new ImagickPixel('#ffffff'));
//        $image->setImageFormat('png');
//        $pngData = $image->getImagesBlob();
//        echo str_starts_with($pngData, "\x89PNG\r\n\x1a\n") ? 'Ok' : 'Failed';

//        $pdf = new \Spatie\PdfToImage\Pdf('translate/2022-09-24-1664044177-resume.io_r_08tTDpInc.pdf');
//        $pdf->saveImage('translate/');
//        return response('ok',200);

        $txt = (new TesseractOCR('text.png'))
            ->executable('C:\Program Files\Tesseract-OCR\tesseract.exe')
            ->run();
        $txt = str_replace("\n", ' ', $txt);
        $count = explode(' ', $txt);
        return count($count);
    }
}
