<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceCreateRequest;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SimpleXMLElement;
use ZipArchive;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('invoice_index'), 403);   
        
        $user = Auth::user();
        if( $user->razonsocial != null ){
            $invoices = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->select('invoices.*', 'users.razonsocial', 'estatus.nombre as status')
                ->where('invoices.razonsocial', $user->razonsocial)
                ->orderBy('invoices.created_at', 'desc')
                ->paginate(10);
        }else{
            $invoices = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->select('invoices.*', 'users.razonsocial', 'estatus.nombre as status')
                ->orderBy('invoices.created_at', 'desc')
                ->paginate(10);
        }
        return view('invoices.index', compact('invoices'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('invoice_create'), 403);

        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceCreateRequest $request)
    {
        $user = User::where('razonsocial', $request->input('id_user'))->first();
        if (!$user) { 
            return redirect()->back()->withErrors(['id_user' => 'El Proveedor no existe']);
        }
        $date = $request->input('fecha');
        $weekNumber = getWeekNumber($date);
        $data = [
            'id_invoice' => $request->input('id_invoice'),
            'description' => $request->input('description'),
            'monto' => $request->input('monto'),
            'razonsocial' => $request->input('id_user'),
            'fecha' => $request->input('fecha'),
            'moneda' => $request->input('moneda'),
            'tipocambio' => $request->input('tipocambio'),
            'semana' => $weekNumber,
            'cancelado' => $request->input('cancelado'),
            'id_status' => 1,
        ];
        
        Invoice::create($data);
            
        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_show'), 403);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_edit'), 403);

        return view('invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        if($request->input('docs') ){
            $pdfFile = $request->file('pdf_file');
            $xmlFile = $request->file('xml_file');
            $xmlData = file_get_contents($xmlFile->path());
            $xml = new SimpleXMLElement($xmlData);
            $importe = $xml['Total'];
            $total = (string) $importe[0];
            if($total != $invoice->monto){
                return redirect()->back()->withErrors(['xml_file' => 'XML no valido']);
            }else{
                $storageFullPath = storage_path('app/public/facturas'); // Ruta de destino de la carpeta
                $destinationPath = $storageFullPath . '/' . $invoice->id_invoice; // Ruta de destino de la carpeta
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true); // Crea la carpeta si no existe
                }
                //XML
                $xmlName = $xmlFile->getClientOriginalName(); // Nombre original del archivo XML
                $xmlStoragePath = $destinationPath . '/' . $xmlName; // Ruta completa del archivo dentro de la carpeta con el ID de la factura
                $xmlFile->move($destinationPath, $xmlName); // Mueve el archivo a la carpeta con el ID de la factura dentro de "storage"
                //PDF
                $pdfName = $pdfFile->getClientOriginalName(); // Nombre original del archivo XML
                $pdfStoragePath = $destinationPath . '/' . $pdfName; // Ruta completa del archivo dentro de la carpeta con el ID de la factura
                $pdfFile->move($destinationPath, $pdfName); // Mueve el archivo a la carpeta con el ID de la factura dentro de "storage"
                //Actualizamos los datos de la factura
                $invoice->id_status = 2;
                $invoice->xml = $xmlStoragePath;
                $invoice->pdf = $pdfStoragePath;

                $invoice->save();
            }
        } else{
            $iduser = $request->input('id_user');
            $data = [
                'id_invoice' => $request->input('id_invoice'),
                'description' => $request->input('description'),
                'monto' => $request->input('monto'),
                'razonsocial' => $iduser,
                'id_status' => 1,
            ];
            $invoice->update($data);
        }
        

        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_destroy'), 403);

        $invoice->delete();

        return redirect()->route('invoices.index');
    }

    public function upDocs($id)
    {
        // Lógica para obtener el invoice correspondiente al ID proporcionado
        $invoice = Invoice::findOrFail($id);

        // Retornar la vista para el formulario de edición de invoices
        return view('invoices.up_docs', compact('invoice'));
    }

    public function download($id)
    {
        $invoice = Invoice::findOrFail($id);
        $storagePath = storage_path('app/public/facturas/' . $invoice->id_invoice);
        $zip = new ZipArchive;
        $zipFile = $storagePath . '/factura-' . $invoice->id_invoice . '.zip';
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $files = glob($storagePath . '/*');
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }
    public function approved($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->id_status = 3;
        $invoice->save();
    }

    public function refresh_invoices()
    {
        //Obtengo todos los documentos de la API
        $jsonDocs = file_get_contents('https://splendorsys.com/api/getAllDocuments.php');
        $docs = json_decode($jsonDocs, true);
        //Obtengo todos los ID's de los usuariarios de la base de datos con razon social
        $jsonUsers = User::whereNotNull('razonsocial')
                    ->where('razonsocial', '<>', '')
                    ->pluck('idclienteproveedor');
        $users = json_decode($jsonUsers, true);
        //Obtengo los id de las facturas que ya existen en la base de datos
        $existingIds = Invoice::pluck('id_invoice')->toArray();
        // Filtrar los documentos que no están registrados en la base de datos destino y que coinciden con los usuarios seleccionados
        $newData = array_filter($docs, function ($item) use ($existingIds, $users) {
            return !in_array($item['CIDDOCUMENTO'], $existingIds) && in_array($item['CIDCLIENTEPROVEEDOR'], $users);
        });
        $invoicesToInsert = array_map(function ($item) {
            return [
                'id_invoice' => $item['CIDDOCUMENTO'],
                'razonsocial' => $item['CRAZONSOCIAL'],
                'description' => $item['CREFERENCIA'],
                'monto' => $item['CTOTAL'],
                'moneda' => $item['CIDMONEDA'],
                'tipocambio' => $item['CTIPOCAMBIO'],
                'fecha' => $item['CFECHA']['date'],
                'semana' => getWeekNumber($item['CFECHA']['date']),
                'cancelado' => $item['CCANCELADO'],
                'id_status' => 1,
            ];
        }, $newData);
        Invoice::insert($invoicesToInsert);
        return redirect()->route('invoices.index');
    }

    public function filters(Request $request)
    {
        $productor = $request->input('productor');
        $week = $request->input('week');
        
        if($productor != null && $week != null){
            $invoices = Invoice::where('razonsocial', 'like', "%$productor%")
                ->where('semana', $week)
                ->get();
        }elseif($productor == null && $week != null){
            $user = Auth::user();
            if( $user->razonsocial != null ){
                $invoices = Invoice::where('semana', $week)->where('razonsocial', 'like', "%$user->razonsocial%")->get();
            }else{
                $invoices = Invoice::where('semana', $week)->get();
            }
        }elseif($productor != null && $week == null){
            $invoices = Invoice::where('razonsocial', 'like', "%$productor%")->get();
        }else{
            $invoices = Invoice::all();
        }
        
    return view('invoices.filters', compact('invoices'));
}
    


}
