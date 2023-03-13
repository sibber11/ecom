<?php

namespace App\Helper;

use Milon\Barcode\Facades\DNS2DFacade;

class QRCode
{
    public static function generate($text)
    {
        $png = "data:image/png;base64," . DNS2DFacade::getBarcodePNG("$text", 'QRCODE');
        return $png;
    }
}
