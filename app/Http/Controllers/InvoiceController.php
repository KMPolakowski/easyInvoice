<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service\Invoice\PrintInvoiceService;

use App\Invoice;
use App\Bank_detail;
use App\User;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->PrintInvoiceService = new PrintInvoiceService();
    }

    private $userId = 11;
    
    /**
     * Returns a pdf invoice based on fields in the request body
     */
    public function printNew(Request $request, PrintInvoiceService $printInvoiceService)
    {
        $this->validate($request, [
            "invoice.receiver.name" => "required|string|max:255",
            "invoice.receiver.address" => "required|string|max:128",
            "invoice.receiver.zip_code" => "required|string|max:64",
            "invoice.receiver.vat_num" => "string|max:14",

            "invoice.details.date" => "required|date_format:d-m-Y",
            "invoice.details.number" => "required|numeric",
            "invoice.details.topic" => "required|string|max:64",
            "invoice.details.address" => "required|string|max:64",
            "invoice.details.zip_code" => "required|string|max:64",
            "invoice.details.netto_sum" => "required|numeric",
            "invoice.details.vat_percentage" => "required|integer",
            "invoice.details.vat_sum" => "required|numeric",
            "invoice.details.end_sum" => "required|numeric",

            "invoice.items.*.pos" => "required|integer",
            "invoice.items.*.descr" => "required|string",
            "invoice.items.*.number" => "required|numeric",
            "invoice.items.*.me" => "required|string|max:3",
            "invoice.items.*.price" => "required|numeric",
            "invoice.items.*.amount" => "required|numeric",
            "invoice.items.*.pos" => "required|integer",
            "invoice.items.*.descr" => "required|string",
            "invoice.items.*.number" => "required|numeric",
            "invoice.items.*.me" => "required|string|max:3",
            "invoice.items.*.price" => "required|numeric",
            "invoice.items.*.amount" => "required|numeric",

            "invoice.info" => "string",

            "invoice.payment" => "required|string|max:128",

            "invoice.bank.bank" => "required|string|max:64",
            "invoice.bank.bic" => "required|string|max:12",
            "invoice.bank.iban" => "required|string|max:14",

            "invoice.contact.tel" => "required|string|max:32",
            "invoice.contact.email" => "required|email",
            "invoice.contact.web" => "string|max:64"
        ]);

        return $printInvoiceService->printInvoice($request->all());
    }

    /**
     * Returns a pdf invoice from db
     */

    public function printExisting(Request $request, $number, PrintInvoiceService $printInvoiceService)
    {
        $request["number"] = $number;

        $this->validate($request, [
            "number" => "required|integer"
        ]);
        
        $user = User::find($this->userId);
        

        $invoice = $user->Invoice()->where("number", $number)->firstOrFail();
        
        $invoiceData["invoice"]["receiver"] = $invoice->Receiver;
        $invoiceData["invoice"]["details"] = $invoice;
        $invoiceData["invoice"]["items"] = $invoice->Item;
        $invoiceData["invoice"]["info"] = $invoice->info;
        $invoiceData["invoice"]["payment_condition"] = $invoice->Payment_condition;
        $invoiceData["invoice"]["bank_detail"] = $invoice->Bank_detail;
        $invoiceData["invoice"]["contact_info"] = $invoice->Contact_info;

        return $printInvoiceService->printInvoice($invoiceData);
    }

    /**
     * Sets certain Invoice as a draft.
     */
    public function makeDraft(Request $request)
    {
    }

    /**
     * Sets certain Invoice as final verison
     */
    public function makeInvoice(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Lists old versions of an Invoice
     */
    public function showOldVersions()
    {
    }

    /**
     * Restores an old version as the latest invoice
    */
    public function restoreOldVersion(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
