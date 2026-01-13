<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NeedUpdateTransferExport implements FromView
{
    protected $cases;

    public function __construct($cases)
    {
        $this->cases = $cases;
    }

    public function view(): View
    {
        return view('backendPage.exports.need_update_transfer_excel', [
            'cases' => $this->cases
        ]);
    }
}
