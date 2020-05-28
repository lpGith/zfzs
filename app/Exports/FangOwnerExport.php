<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/27
 * Time: 15:24
 */

namespace App\Exports;


use App\Model\FangOwner;
use Maatwebsite\Excel\Concerns\FromCollection;

class FangOwnerExport implements FromCollection
{

    public function collection()
    {
        return FangOwner::all();
    }
}
