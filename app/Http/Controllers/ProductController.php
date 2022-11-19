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

class ProductController extends Controller
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

        $query = Product::select('products.*');
        if($search != ""){
            $query->whereRaw("upper(name) like '%$search%'");
        }
        $recordsTotal = $query->count();
        $query->offset($start);
        $query->limit($length);
        $query->orderBy($sort, $dir);
        
        $products = $query->get();

        $data = [];
        foreach($products as $row){
            $row->no = ++$start;
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

    public function read_detail(Request $request){
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
        $query->where('product_id', $request->product_id);
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
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
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
            'name'  => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);       
        
        $post = Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        Session::flash('success', 'Data Berhasil di tambahkan');
        return redirect()->route('product.index');
        
    }

    public function detail(Request $request){
        $product = Product::find($request->id);
        if($product){
            return view('admin.product.detail',compact('product'));
        }
        else{
            abort(404);
        }
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
        $product = Product::find($id);

        return view('admin.product.edit')->with('data', $product);
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
            'name'  => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);  
        $product = Product::find($id);
        $product->name  = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();

        Session::flash('success', 'Data Berhasil di update');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        Session::flash('success', 'Data Berhasil di hapus');
        return redirect()->back();
    }
}
