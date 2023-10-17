<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceCreateRequest;
use App\Models\Invoice;
use App\Models\Fruta;
use App\Models\Planta;
use App\Models\Regalia;
use App\Models\Deuda;
use App\Models\Financiamiento;
use App\Models\User;
use App\Models\Estatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SimpleXMLElement;
use ZipArchive;

use App\Models\SysSplendorUserRfcs;
use App\Models\SplendorTablaDocumentos;
use App\Models\SplendorTablaMovimientos;
use App\Models\SplendorTablaProductos;


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
                ->orderBy('invoices.fecha', 'desc')
                ->paginate(10);
        }else{
            $invoices = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->select('invoices.*', 'users.razonsocial', 'estatus.nombre as status')
                ->orderBy('invoices.fecha', 'desc')
                ->paginate(10);
        }
        $estatus = Estatus::all();
        return view('invoices.index', compact('invoices', 'estatus'));
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
        /******* FACTURAS ********* */
        $ids_cliente_proveedor = SysSplendorUserRfcs::pluck('cidclienteproveedor')->toArray();
        foreach($ids_cliente_proveedor as $id_cliente_proveedor){
            //SE OBTINE EL ROL QUE TIENE DOCUMENTOS RELACIONADOS CON EL ID 19 (Facturas)
            $docs = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CIDCONCEPTODOCUMENTO', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTALUNIDADES', 'CUNIDADESPENDIENTES')
            ->where('CIDDOCUMENTODE', '=' , 19)
            ->where('CIDCLIENTEPROVEEDOR', '=' , $id_cliente_proveedor)
            ->get();
            if(  count($docs) > 0 ){
                $cids_docs = [];
                foreach($docs as $doc){
                    $cids_docs[] = $doc->CIDDOCUMENTO;
                }
                //Obtengo los id de las facturas que ya existen en la base de datos
                $existingIds = Invoice::pluck('id_invoice')->toArray();        
                // Compara el array $cids_docs con $existingIds y devuelve los que no existen en la base de datos
                $new_cids_docs = array_filter($cids_docs, function ($item) use ($existingIds) {
                    return !in_array($item, $existingIds);
                });
                $docs_invoices = SplendorTablaDocumentos::whereIn('CIDDOCUMENTO', $new_cids_docs)->get();
                foreach($docs_invoices as $doc_invoice){
                    $invoicesToInsert = [
                        'id_invoice' => $doc_invoice->CIDDOCUMENTO,
                        'razonsocial' => $doc_invoice->CRAZONSOCIAL,
                        'rfc' => $doc_invoice->CRFC,
                        'description' => $doc_invoice->CREFERENCIA,
                        'financiamiento' => $doc_invoice->CIMPORTEEXTRA1,
                        'regalias' => $doc_invoice->CIMPORTEEXTRA2,
                        'plantas' => $doc_invoice->CIMPORTEEXTRA3,
                        'materiales' => $doc_invoice->CIMPORTEEXTRA4,
                        'monto' => $doc_invoice->CTOTAL,
                        'moneda' => $doc_invoice->CIDMONEDA,
                        'tipocambio' => $doc_invoice->CTIPOCAMBIO,
                        'fecha' => $doc_invoice->CFECHA,
                        'semana' => getWeekNumber($doc_invoice->CFECHA),
                        'cancelado' => $doc_invoice->CCANCELADO,
                        'id_status' => 1,
                    ];
                    Invoice::insert($invoicesToInsert);    
                }
            }
        }
        /*******FRUTAS ********* */
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        $users_rfcs = SysSplendorUserRfcs::pluck('cidclienteproveedor')->toArray();
        foreach($users_rfcs as $user_rfc){
            //SE OBTINE EL ROL QUE TIENE DOCUMENTOS RELACIONADOS CON EL ID 18 (FRUTAS)
            $documentos = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CIDCONCEPTODOCUMENTO', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTALUNIDADES', 'CUNIDADESPENDIENTES')
            ->where('CIDDOCUMENTODE', '=' , 18)
            ->where('CIDCLIENTEPROVEEDOR', '=' , $user_rfc)
            ->get();
            
            //SE VERIFICA QUE TENGA DOCUMENTOS DE FRUTAS
            if(  count($documentos) > 0 ){
                foreach($documentos as $key => $ticket_fruta){
                    //verificar que cididdocumento no exista en la tabla frutas
                    $cididdocumento = Fruta::where('cididdocumento', '=', $ticket_fruta->CIDDOCUMENTO)->first();
                    //si no existe se inserta
                    if( !$cididdocumento ){
                        $cidproducto = $ticket_fruta->CIDDOCUMENTO;
                        $detalle_frunta = SplendorTablaMovimientos::join('admProductos', 'admProductos.CIDPRODUCTO', '=', 'admMovimientos.CIDPRODUCTO')
                                        ->join('admClasificacionesValores', 'admClasificacionesValores.CIDVALORCLASIFICACION', '=', 'admProductos.CIDVALORCLASIFICACION3')
                                        ->where('admMovimientos.CIDDOCUMENTO', '=', $cidproducto)
                                        ->select('admProductos.CNOMBREPRODUCTO', 'admClasificacionesValores.CVALORCLASIFICACION AS talla')
                                        ->first();
                        $frutsToInsert = [
                                'cididdocumento' => $documentos[$key]['CIDDOCUMENTO'],
                                'fecha' => $documentos[$key]['CFECHA'],
                                'serie' => $documentos[$key]['CSERIEDOCUMENTO'],
                                'folio' => $documentos[$key]['CFOLIO'],                    
                                'semana' => getWeekNumber($documentos[$key]['CFECHA']),
                                'nombre' => $detalle_frunta['CNOMBREPRODUCTO'],
                                'talla' => $detalle_frunta['talla'],
                                'total' => $documentos[$key]['CTOTALUNIDADES'],
                                'pendientes' => $documentos[$key]['CUNIDADESPENDIENTES'],                            
                            ];
                        Fruta::insert($frutsToInsert);
                    }
                }
            }
        }
        /******* PLANTAS ********* */
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        $ids_cliente_proveedor = SysSplendorUserRfcs::pluck('cidclienteproveedor')->toArray();
        foreach($ids_cliente_proveedor as $id_cliente_proveedor){
            //SE OBTINE EL ROL QUE TIENE DOCUMENTOS RELACIONADOS CON EL ID 4 (PLANTAS)
            $docs = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CIDCONCEPTODOCUMENTO', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTALUNIDADES', 'CUNIDADESPENDIENTES')
            ->where('CIDDOCUMENTODE', '=' , 4)
            ->where('CIDCLIENTEPROVEEDOR', '=' , $id_cliente_proveedor)
            ->get();
            //SE VERIFICA QUE TENGA DOCUMENTOS DE PLANTAS
            if(  count($docs) > 0 ){
                $cids_docs = [];
                foreach($docs as $doc){
                    $cids_docs[] = $doc->CIDDOCUMENTO;
                }
                //Obtengo los id de las plantas que ya existen en la base de datos
                $existingIds = Planta::pluck('cididdocumento')->toArray();
                // Compara el array $cids_docs con $existingIds y devuelve los que no existen en la base de datos
                $new_cids_docs = array_filter($cids_docs, function ($item) use ($existingIds) {
                    return !in_array($item, $existingIds);
                });
                $docs_plantas = SplendorTablaDocumentos::whereIn('CIDDOCUMENTO', $new_cids_docs)->get();
                foreach($docs_plantas as $doc_planta){
                    $plantasToInsert = [
                        'cididdocumento' => $doc_planta->CIDDOCUMENTO,
                        'fecha' => $doc_planta->CFECHA,
                        'semana' => getWeekNumber($doc_planta->CFECHA),
                        'serie' => $doc_planta->CSERIEDOCUMENTO,
                        'folio' => $doc_planta->CFOLIO,
                        'concepto' => $doc_planta->CREFERENCIA,
                        'importe' => $doc_planta->CTOTAL,
                        'iva' => $doc_planta->CIMPUESTO1,
                        'total' => $doc_planta->CTOTAL,
                        'pendiente' => $doc_planta->CUNIDADESPENDIENTES,
                    ];
                    Planta::insert($plantasToInsert);    
                }
            }
        }



        /**BLOQUE TEMPORAL */
        //Obtengo todos los documentos de la API
        $jsonDocs = file_get_contents('https://splendorsys.com/api/getAllDocuments.php');
        $docs = json_decode($jsonDocs, true);
        $jsonUsers = User::whereNotNull('razonsocial')
                    ->where('razonsocial', '<>', '')
                    ->pluck('idclienteproveedor');
        $users = json_decode($jsonUsers, true);
        /**TERMINA BLOQUE TEMPORAL */
        //obtener los RFC de usando los id's de $users
        $rfcs = User::whereIn('idclienteproveedor', $users)->pluck('rfc')->toArray();
        foreach($rfcs as $rfc){
            //REGALIAS
            $jsonRegalias = file_get_contents('https://splendorsys.com/api/getRegaliasByRFC.php?rfc='.$rfc);
            $regalias = json_decode($jsonRegalias, true);
            //obtener los cididdocumento de la tabla regalias
            $existingRegalias = Regalia::pluck('cididdocumento')->toArray();
            //comparo $existingRegalias con $regalias->CIDDOCUMENTO
            $newRegalias = array_filter($regalias, function ($item) use ($existingRegalias) {
                return !in_array($item['CIDDOCUMENTO'], $existingRegalias);
            });
            $regaliasToInsert = array_map(function ($item) {
                return [
                    'cididdocumento' => $item['CIDDOCUMENTO'],
                    'fecha' => $item['fecha']['date'],
                    'semana' => getWeekNumber($item['fecha']['date']),
                    'serie' => $item['serie'],
                    'folio' => $item['folio'],
                    'concepto' => $item['concepto'],
                    'importe' => $item['importe'],
                    'iva' => $item['iva'],
                    'total' => $item['total'],
                ];
            }, $newRegalias);
            Regalia::insert($regaliasToInsert);
            //DEUDAS
            $jonDeudas  = file_get_contents('https://splendorsys.com/api/getDeudasByRFC.php?rfc='.$rfc);
            $deudas = json_decode($jonDeudas, true);
            //dd($deudas);
            //obtener los cididdocumento de la tabla deudas
            $existingDeudas = Deuda::pluck('cididdocumento')->toArray();
            //dd($existingDeudas);    
            //buscar el valor de CIDDOCUMENTO en la tabla deudas
            $newDeudas = array_filter($deudas, function ($item) use ($existingDeudas) {
                return !in_array($item['CIDDOCUMENTO'], $existingDeudas);
            });
            //dd($newDeudas); 
            $deudasToInsert = array_map(function ($item) {
                return [
                    'cididdocumento' => $item['CIDDOCUMENTO'],
                    'fecha' => $item['fecha']['date'],
                    'serie' => $item['serie'],
                    'folio' => $item['folio'],
                    'importe' => $item['importe'],
                    'total_unidades' => $item['totalUnidades'],
                    'moneda' => $item['moneda'],
                    'descuentos' => $item['descuentos'],
                    'saldo' => $item['saldo'],
                ];
            }, $newDeudas);   
            Deuda::insert($deudasToInsert);
            //FINANCIAMIENTOS
            $jsonFinanciamientos = file_get_contents('https://splendorsys.com/api/getFinanciamientoByRFC.php?rfc='.$rfc);
            $financiamientos = json_decode($jsonFinanciamientos, true);
            //dd($financiamientos);
            //obtener los cididdocumento de la tabla financiamientos
            $existingFinanciamientos = Financiamiento::pluck('cididdocumento')->toArray();
            //comparo $existingFinanciamientos con $financiamientos->CIDDOCUMENTO
            $newFinanciamientos = array_filter($financiamientos, function ($item) use ($existingFinanciamientos) {
                return !in_array($item['CIDDOCUMENTO'], $existingFinanciamientos);
            });
            $financiamientosToInsert = array_map(function ($item) {
                return [
                    'cididdocumento' => $item['CIDDOCUMENTO'],
                    'fecha' => $item['fecha']['date'],
                    'serie' => $item['serie'],
                    'folio' => $item['folio'],
                    'prestamos' => $item['prestamos'],
                    'descuentos' => $item['descuentos'],
                    'deuda_total' => $item['deudaTotal'],
                ];
            }, $newFinanciamientos);
            Financiamiento::insert($financiamientosToInsert);
        }
        return redirect()->route('invoices.index');
    }

    public function filters(Request $request)
    {
        $productor = $request->input('productor');
        $week = $request->input('week');
        $estatus = $request->input('estatus');
        
        if($productor != null && $week != null && $estatus != null){
            $invoices = Invoice::where('razonsocial', 'like', "%$productor%")
                ->where('semana', $week)
                ->where('id_status', $estatus)
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->get();
        }elseif($productor == null && $week != null && $estatus == null){
            $user = Auth::user();
            if( $user->razonsocial != null ){
                $invoices = Invoice::where('semana', $week)->where('razonsocial', 'like', "%$user->razonsocial%")
                    ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                    ->get();
            }else{
                $invoices = Invoice::where('semana', $week)
                    ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                    ->get();
            }
        }elseif($productor != null && $week == null && $estatus == null ){
            $invoices = Invoice::where('razonsocial', 'like', "%$productor%")
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->get();
        }elseif($productor == null && $week == null && $estatus != null ){
            $invoices = Invoice::where('id_status', $estatus)
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->get();
        }else{
            $invoices = Invoice::all();
        }
        
        $estatus = Estatus::all();

        return view('invoices.filters', compact('invoices', 'estatus'));
    }
}
