<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\customers;
use App\Models\LogCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerResource::collection(customers::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {   
        if(customers::create([
            'dni' => $request->dni,
            'id_reg' => $request->id_reg,
            'id_com' => $request->id_com,
            'email' => $request->email,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'date_reg' => date('Y-m-d H:i:s'),
            'status' => 'A'
        ]))  {
            LogCustomers::create([
                'type' => 'Entrada',
                'description' => 'Se registro un nuevo customer con dni '.$request->dni,
                'ip' => request()->ip(),
            ]);
            return response()->json([
                'success' => 'true'
            ], 200);
        }
           

        return response()->json([
            'success' => 'false'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = customers::where('dni', $id)->orWhere('email', $id)
            ->join('regions', 'regions.id_reg', 'customers.id_reg')
            ->join('communes', 'communes.id_com', 'customers.id_com')
            ->select('customers.*', 'regions.description AS region', 'communes.description AS commune')
            ->first();

        if(is_null($customer)){
            return response()->json([
                'message' => 'Not found',
                'success' => 'false'
            ], 404);
        }

        if(config('app.env') != 'production'){
            LogCustomers::create([
                'type' => 'Salida',
                'description' => 'Se consulto la informacion del customer con el dni '.$customer->dni,
                'ip' => request()->ip(),
            ]);
        }

        if($customer->status == 'A')
            return response()->json([
                'data' => new CustomerResource($customer),
                'success' => 'true'
            ], 200);

        if($customer->status == 'I')
            return response()->json([
                'message' => 'Customer desactivo',
                'success' => 'true'
            ], 200);
        
        if($customer->status == 'trash')
            return response()->json([
                'message' => 'Customer eliminado',
                'success' => 'true'
            ], 200);

      
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customers $customers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = customers::where('dni', $id)->orWhere('email', $id)->first();
     
        if(!is_null($customer) && $customer->status != 'trash'){
            if(customers::where('dni', $customer->dni)->update(['status' => 'trash'])){
                LogCustomers::create([
                    'type' => 'Entrada',
                    'description' => 'Se elimino logicamente el customer con el dni '.$customer->dni,
                    'ip' => request()->ip(),
                ]);
                return response()->json([
                    'success' => 'true'
                ], 200);
            }
            return response()->json([
                'message' => 'Not found',
                'success' => 'false'
            ], 404);
        }
        
        return response()->json([
            'message' => 'Registro no existe',
            'success' => 'false'
        ], 404);
    }
}
