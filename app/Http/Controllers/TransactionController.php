<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Product;
use App\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function read(Request $request){
        $start = $request->start;
        $length = $request->length;
        $search = strtoupper($request->search['value']);
        $sort = $request->columns[$request->order[0]['column']]['data'];
        $dir = $request->order[0]['dir'];

        $query = Transaction::select('transactions.*','products.name');
        if($search != ""){
            $query->whereRaw("upper(transaction_no) like '%$search%'");
        }
        $query->leftJoin('products', 'products.id', '=', 'transactions.product_id');
        $recordsTotal = $query->count();
        $query->offset($start);
        $query->limit($length);
        $query->orderBy($sort, $dir);
        
        $productDetails = $query->get();

        $data = [];
        foreach($productDetails as $row){           
            $row->no = ++$start;
            $row->date = date('d-m-Y',strtotime($row->date));
            $row->type_name = ($row->type == 1) ? "Penambahan" : "Pengurangan";
            $row->price = number_format($row->price, 2, ',', '.');
			$data[] = $row;
		}
        return response()->json([
            'draw'=>$request->draw,
			'recordsTotal'=>$recordsTotal,
			'recordsFiltered'=>$recordsTotal,
			'data'=>$data
        ], 200);
    }

    public function index()
    {
        $transactions = Transaction::all();
        return view('admin.transaction.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.transaction.create')->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'       => 'required',
            'product_id' => 'required',
            'price'      => 'required',
            'amount'     => 'required',
        ]);       
        $getProductStock = Product::where('id', $request->product_id)->first();
        if($request->type == 1){
            $totalStock = $getProductStock->stock + $request->amount;
        }else{
            $totalStock = $getProductStock->stock - $request->amount;
        }
        $transaction = Transaction::create([
            'date'        => $request->date,
            'product_id'  => $request->product_id,
            'type'        => $request->type,
            'price'       => $request->price,
            'amount'      => $request->amount,
            'total_stock'  => $totalStock,
        ]);
        if($transaction){
            $product = Product::find($transaction->product_id);
            $product->stock = $totalStock;
            $product->save();
        }
        Session::flash('success', 'Data Berhasil di tambahkan');
        return redirect()->route('transaction.index');
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
        $products = Product::all();
        $data = Transaction::find($id);
        return view('admin.transaction.edit', compact('data','products'));
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
        $this->validate($request, [
            'date'       => 'required',
            'product_id' => 'required',
            'price'      => 'required',
            'amount'     => 'required',
        ]); 
        $getProductStock = Product::where('id', $request->product_id)->first();
        if($request->type == 1){
            $totalStock = $getProductStock->stock + $request->amount;
        }else{
            $totalStock = $getProductStock->stock - $request->amount;
        }
        $transaction = Transaction::find($id);
        $transaction->date       = $request->date;
        $transaction->product_id = $request->product_id;
        $transaction->price      = $request->price;
        $transaction->amount     = $request->amount;
        $transaction->save();
        if($transaction){
            $product = Product::find($transaction->product_id);
            $product->stock = $totalStock;
            $product->save();
        }
        Session::flash('success', 'Data Berhasil di update');
        return redirect()->route('transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        Session::flash('success', 'Data Berhasil di hapus');
        return redirect()->back();
    }
}
