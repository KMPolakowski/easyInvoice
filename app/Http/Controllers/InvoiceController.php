<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Service\Invoice\PrintInvoiceService;

use App\Invoice;
use App\Bank_detail;
use App\User;
use App\Receiver;
use App\Item;
use App\Payment_condition;
use App\Contact_info;

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

    private $userId = 3;

    public function index()
    {
        $user = User::find($this->userId);

        $invoices = $user->Invoice()->get();
        return $invoices;
    }
 
    
    /**
     * Returns a pdf invoice based on fields in the request body
     */
    public function printNew(Request $request, PrintInvoiceService $printInvoiceService)
    {
        $this->validate($request, [
            "invoice.receiver.name" => "required|string|max:255",
            "invoice.receiver.street" => "required|string|max:128",
            "invoice.receiver.house_number" => "required|string|max:12",
            "invoice.receiver.zip_code" => "required|string|max:64",
            "invoice.receiver.vat_number" => "string|max:14",

            "invoice.details.date" => "required|date_format:d-m-Y",
            "invoice.details.number" => "required|numeric",
            "invoice.details.topic" => "required|string|max:64",
            "invoice.details.street" => "required|string|max:64",
            "invoice.details.house_number" => "required|numeric",
            "invoice.details.zip_code" => "required|string|max:64",
            "invoice.details.netto_sum" => "required|numeric",
            "invoice.details.vat_percentage" => "required|integer",
            "invoice.details.vat_sum" => "required|numeric",
            "invoice.details.brutto_sum" => "required|numeric",

            "invoice.items.*.pos_num" => "required|integer",
            "invoice.items.*.descr" => "required|string",
            "invoice.items.*.quantity" => "required|numeric",
            "invoice.items.*.me" => "required|string|max:3",
            "invoice.items.*.price" => "required|numeric",
            "invoice.items.*.amount" => "required|numeric",

            "invoice.info" => "string",

            "invoice.payment_condition.days" => "required|numeric",
            "invoice.payment_condition.has_skonto" => "required|boolean",

            "invoice.bank_detail.bank" => "required|string|max:64",
            "invoice.bank_detail.bic" => "required|string|max:12",
            "invoice.bank_detail.iban" => "required|string|max:14",

            "invoice.contact_info.tel" => "required|string|max:32",
            "invoice.contact_info.email" => "required|email",
            "invoice.contact_info.web" => "string|max:64"
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
    public function makeDraft(Request $request, $number)
    {
        $request["number"] = $number;

        $this->validate($request, [
            "number" => "required|integer"
        ]);
        
        $user = User::find($this->userId);
        

        $invoice = $user->Invoice()->where("number", $number)->firstOrFail();

        if ($invoice->draft == 0) {
            $invoice->draft = 1;
        
            if ($invoice->save()) {
                return $invoice;
            } else {
                return "no save";
            }
        } else {
            return "It's already so";
        }
    }

    /**
     * Sets certain Invoice as final verison
     */
    public function makeInvoice(Request $request, $number)
    {
        $request["number"] = $number;

        $this->validate($request, [
            "number" => "required|integer"
        ]);
        
        $user = User::find($this->userId);
        

        $invoice = $user->Invoice()->where("number", $number)->firstOrFail();

        if ($invoice->draft == 1) {
            $invoice->draft = 0;
        
            if ($invoice->save()) {
                return $invoice;
            } else {
                return "no save";
            }
        } else {
            return "It's already so";
        }
    }

    /**
     * Creates a draft of an Invoice
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice = new Invoice();
        $invoice->draft = 1;
        $user = User::find($this->userId);
        if ($user->Invoice()->save($invoice)) {
            return $invoice;
        }
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
    public function setReceiverById(Request $request)
    {
        $this->validate($request, [
            "receiver_id" => "required|integer",
            "invoice_id" => "required|integer"
        ]);

        $user = User::find($this->userId);

        $receiver = $user->Receiver()->where("external_id", $request->get("receiver_id"))->first();
        
        if ($receiver instanceof Receiver) {
            $invoice = $user->Invoice()->where("number", $request->get("invoice_id"))->first();
            if ($receiver->Invoice()->save($invoice)) {
                return $invoice;
            }
        } else {
            return "no found";
        }
    }

    public function setNewReceiver(Request $request)
    {
        $this->validate($request, [
            "receiver.name" => "required|string|max:255",
            "receiver.street" => "required|string|max:128",
            "receiver.house_number" => "required|string|max:12",
            "receiver.zip_code" => "required|string|max:64",
            "receiver.vat_number" => "string|max:14",
            "invoice_id" => "required|integer"
        ]);

        $user = User::find($this->userId);
        $invoice = $user->Invoice()->where("number", $request->get("invoice_id"))->first();
        
        //Check if invoice has a receiver
        if ($invoice->Receiver instanceof Receiver) {
            $receiver = Receiver::find($invoice->Receiver->id);

            //If the receiver has more invoices than this one, create a new receiver and attach him the invoice
            // return $receiver->Invoice()->count() . " " . $receiver;

            if ($receiver->Invoice()->count() > 1) {
                $receiver = new Receiver();
                $receiver->name = $request->input("receiver.name");
                $receiver->street = $request->input("receiver.street");
                $receiver->house_number = $request->input("receiver.house_number");
                $receiver->zip_code = $request->input("receiver.zip_code");
                $receiver->vat_number = $request->input("receiver.vat_number");
    
                if ($user->Receiver()->save($receiver) &&  $receiver->Invoice()->save($invoice)) {
                    return $receiver;
                }
            } else {
                $receiver->name = $request->input("receiver.name");
                $receiver->street = $request->input("receiver.street");
                $receiver->house_number = $request->input("receiver.house_number");
                $receiver->zip_code = $request->input("receiver.zip_code");
                $receiver->vat_number = $request->input("receiver.vat_number");
                if ($receiver->save()) {
                    return $receiver;
                }
            }

            //If it doesn't, create a new receiver and attach him to the invoice
        } else {
            $receiver = new Receiver();
            $receiver->name = $request->input("receiver.name");
            $receiver->street = $request->input("receiver.street");
            $receiver->house_number = $request->input("receiver.house_number");
            $receiver->zip_code = $request->input("receiver.zip_code");
            $receiver->vat_number = $request->input("receiver.vat_number");

            if ($user->Receiver->save($receiver) &&  $receiver->Invoice()->save($invoice)) {
                return $receiver;
            }
        }
    }


    public function editDetails(Request $request)
    {
        //
    }

    public function addItemById(Request $request)
    {
        $this->validate($request, [
            "item_id" => "required|integer",
            "invoice_id" => "required|integer"
        ]);

        $user = User::find($this->userId);
        
        $invoice = $user->Invoice()->where("number", $request->get("invoice_id"))->first();
        $item = $user->Item()->where("external_id", $request->get("item_id"))->first();
        
        if ($invoice instanceof Invoice) {
            if ($item instanceof Item) {
                $invoice = $user->Invoice()->where("number", $request->get("invoice_id"))->first();
                if ($invoice->Item()->save($item)) {
                    return $item;
                }
            } else {
                return "nix item";
            }
        } else {
            return "nix invoice found";
        }
    }

    public function addNewItem(Request $request)
    {
        $this->validate($request, [
            "item.descr" => "required|string",
            "item.quantity" => "required|numeric",
            "item.me" => "required|string|max:3",
            "item.price" => "required|numeric",
            "item.amount" => "required|numeric",
            "invoice_id" => "required|integer"
        ]);

        $user = User::find($this->userId);
        $invoice = $user->Invoice()->where("number", $request->input("invoice_id"))->first();
        
        if ($invoice instanceof Invoice) {
            $item = new Item();
            $highestPos = $invoice->Item()->max("pos_num") ?? 0;
            $item->pos_num = $highestPos+1;
            $item->descr = $request->input("item.descr");
            $item->quantity = $request->input("item.quantity");
            $item->me = $request->input("item.me");
            $item->price = $request->input("item.price");
            $item->amount = $request->input("item.amount");

            if ($user->Item()->save($item) && $invoice->Item()->save($item)) {
                return $item;
            } else {
                return "nix save";
            }
        } else {
            return "nix invoice";
        }
    }

    public function editItem(Request $request)
    {
        $this->validate($request, [
            "item.pos_num" => "required|integer",
            "item.descr" => "required|string",
            "item.quantity" => "required|numeric",
            "item.me" => "required|string|max:3",
            "item.price" => "required|numeric",
            "item.amount" => "required|numeric",
            "invoice_id" => "required|integer"
        ]);

        $user = User::find($this->userId);
        $invoice = $user->Invoice()->where("number", $request->input("invoice_id"))->first();
        
        if ($invoice instanceof Invoice) {
            $item = $invoice->Item()->where("pos_num", $request->input("item.pos_num"))->first();
            if ($item instanceof Item) {
                if ($item->Invoice()->count() > 1) {
                    $item = new Item();
                }
                $item->descr = $request->input("item.descr");
                $item->quantity = $request->input("item.quantity");
                $item->me = $request->input("item.me");
                $item->price = $request->input("item.price");
                $item->amount = $request->input("item.amount");
                if ($item->Invoice()->count() > 1) {
                    if ($user->save($item) && $invoice->save($item)) {
                        return $invoice;
                    } else {
                        return "nix save";
                    }
                } elseif ($item->save()) {
                    $invoice->load("item");
                    return $invoice;
                } else {
                    return "nix save";
                }
            } else {
                return "nix item";
            }
        } else {
            return "nix invoice";
        }
    }

    public function setPaymentConditionById(Request $request)
    {
        $this->validate($request, [
            "payment_id" => "required|integer",
            "invoice_id" => "required|integer"
        ]);

        $user = User::find($this->userId);

        $payment = $user->Payment_condition()->where("external_id", $request->get("payment_id"))->first();
        
        if ($payment instanceof Payment_condition) {
            $invoice = $user->Invoice()->where("number", $request->get("invoice_id"))->first();
            if ($payment->Invoice()->save($invoice)) {
                return $invoice;
            }
        } else {
            return "no found";
        }
    }

    // public function setBankDetailById(Request $request)
    // {
    //     $this->validate($request, [
    //         "bank_id" => "required|integer",
    //         "invoice_id" => "required|integer"
    //     ]);

    //     $user = User::find($this->userId);

    //     $bank = $user->Bank_detail()->where("external_id", $request->get("bank_id"))->first();
        
    //     if ($bank instanceof Bank_detail) {
    //         $invoice = $user->Invoice()->where("number", $request->get("invoice_id"))->first();
    //         if ($bank->Invoice()->save($invoice)) {
    //             return $invoice;
    //         }
    //     } else {
    //         return "no found";
    //     }
    // }

    public function setContactInfo(Request $request)
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
