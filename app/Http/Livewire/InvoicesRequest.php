<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Workflow\Invoices;
use App\Models\Companies\Companies;
use App\Models\Workflow\OrderLines;
use App\Models\Workflow\InvoiceLines;
use App\Models\Workflow\DeliveryLines;

class InvoicesRequest extends Component
{
    public $companies_id = '';
    public $sortField = 'id'; // default sorting field
    public $sortAsc = true; // default sort direction
    
    public $LastDelivery = '1';

    public $DeliverysRequestsLineslist;
    public $CODE, $LABEL, $user_id; 
    public $updateLines = false;
    public $CompaniesSelect = [];
    public $data = [];
    public $qty = [];

    private $ORDRE = 10;

    // Validation Rules
    protected $rules = [
        'CODE' =>'required|unique:invoices',
        'LABEL' =>'required',
        'companies_id'=>'required',
        'user_id'=>'required',
    ];
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc; 
        } else {
            $this->sortAsc = true; 
        }
        $this->sortField = $field;
    }

    public function mount() 
    {
        $this->LastInvoice =  Invoices::latest()->first();
        if($this->LastInvoice == Null){
            $this->CODE = "IN-0";
            $this->LABEL = "IN-0";
        }
        else{
            $this->CODE = "IN-". $this->LastInvoice->id;
            $this->LABEL = "IN-". $this->LastInvoice->id;
        }

        $this->CompaniesSelect = Companies::select('id', 'LABEL', 'CODE')->orderBy('CODE')->get();
    }

    public function render()
    {
        $userSelect = User::select('id', 'name')->get();

        //Select delevery line where not Partly invoiced or Invoiced
        $InvoicesRequestsLineslist = $this->DeliverysRequestsLineslist = DeliveryLines::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                                                                        ->where(
                                                                            function($query) {
                                                                                return $query
                                                                                    ->where('invoice_status', '=', '1')
                                                                                    ->orWhere('invoice_status', '=', '2');
                                                                            })
                                                                        ->whereHas('delivery', function($q){
                                                                            $q->where('companies_id','like', '%'.$this->companies_id.'%');
                                                                        })
                                                                        ->with('delivery')
                                                                        ->with('orderLine.order')
                                                                        ->with('orderLine.Product')
                                                                        ->with('orderLine.Unit')
                                                                        ->with('orderLine.VAT')->get();

        return view('livewire.invoices-request', [
            'InvoicesRequestsLineslist' => $InvoicesRequestsLineslist,
            'userSelect' => $userSelect,
        ]);
    }

    public function storeInvoice(){
        //check rules
        $this->validate(); 
        
        //check if line exist
        $i = 0;
        foreach ($this->data as $key => $item) {
            if(array_key_exists("deliverys_id",$this->data[$key])){
                if($this->data[$key]['deliverys_id'] != false ){
                    $i++;
                }
            }
        }

        if($i>0){
            // Create invoice
            $InvoiceCreated = Invoices::create([
                                                'CODE'=>$this->CODE,  
                                                'LABEL'=>$this->LABEL, 
                                                'companies_id'=>$this->companies_id,   
                                                'user_id'=>$this->user_id, 
            ]);

            // Create invoice note lines
            foreach ($this->data as $key => $item) {
                //check if add line to new delivery note is aviable
                if(array_key_exists("deliverys_id",$this->data[$key])){
                    if($this->data[$key]['deliverys_id'] != false ){
                        //if not best to find request value, but we cant send hidden data with livewire
                        //How pass order_line_id & qty delivered ?
                        $DeliveryLine = DeliveryLines::find($this->data[$key]['deliverys_id']);
                        // Create delivery line
                        
                        $InvoiceLines = InvoiceLines::create([
                            'invoices_id' => $InvoiceCreated->id,
                            'order_line_id' => $DeliveryLine->order_line_id, 
                            'delivery_line_id' => $this->data[$key]['deliverys_id'], 
                            'ORDRE' => $this->ORDRE,
                            'qty' => $DeliveryLine->qty,
                            'statu' => 1
                        ]); 

                        // update order line info
                        $OrderLine = OrderLines::find($DeliveryLine->order_line_id);
                        $OrderLine->invoiced_qty =  $OrderLine->invoiced_qty + $DeliveryLine->qty;
                        $OrderLine->invoiced_remaining_qty = $OrderLine->invoiced_remaining_qty - $DeliveryLine->qty;
                        //if we are invoiced all part
                        if($OrderLine->invoiced_remaining_qty == 0){
                            $OrderLine->invoice_status = 3;
                            // update order statu info
                            // we must be check if all entry are invoiced
                            //Orders::where('id',$OrderLine->orders_id)->update(['statu'=>2]);
                        }
                        else{
                            $OrderLine->invoice_status = 2;
                            // update order statu info
                            //Orders::where('id',$OrderLine->orders_id)->update(['statu'=>3]);
                        }
                        $OrderLine->save();

                        $this->ORDRE= $this->ORDRE+10;
                    }
                }  
            }
                
            // return view on new document
            return redirect()->route('invoice.show', ['id' => $InvoiceCreated->id])->with('success', 'Successfully created new invoice');
        }
        else{
            return redirect()->route('invoices-request')->with('error', 'no lines selected');
        }
    }
}
