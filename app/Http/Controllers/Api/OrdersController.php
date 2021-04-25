<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Order::awaiting()->eloquentQuery(
            $sortBy,
            $orderBy,
            $searchValue,
            [
                "client", "products"
            ]
        );

        $data = $query->paginate($length);


        return new DataTableCollectionResource($data);
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
    public function store(OrderRequest $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
        ]);

        foreach ($request->products as $key => $product) {
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'order_id' => $order->id,
            ]);
        }

        return response()->json($order, Response::HTTP_CREATED);
    }

    public function confirm(Order $order)
    {
        $order->delivered_at = now();
        $order->save();

        return response()->json($order, Response::HTTP_CREATED);
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

    
    public function delivered(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Order::delivered()->eloquentQuery(
            $sortBy,
            $orderBy,
            $searchValue,
            [
                "client", "products"
            ]
        );

        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }
}
