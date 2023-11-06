<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceCreateRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use SimpleXMLElement;
use ZipArchive;


use App\Models\SplendorTablaClientes;
use App\Models\SplendorTablaDocumentos;
use App\Models\SplendorTablaMovimientos;
use App\Models\SplendorTablaProductos;
use App\Models\SplendorTablaAlmacenes;

use App\Models\SysSplendorUserRfcs;
use App\Models\SplendorUser;
use App\Models\RazonesSocialesByUser;
use App\Models\Prestamo;
use App\Models\Invoice;
use App\Models\Fruta;
use App\Models\Planta;
use App\Models\Regalia;
use App\Models\Deuda;
use App\Models\Financiamiento;
use App\Models\Material;
use App\Models\User;
use App\Models\Estatus;


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
                ->paginate(20);
        }else{
            $invoices = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->select('invoices.*', 'users.razonsocial', 'estatus.nombre as status')
                ->orderBy('invoices.fecha', 'desc')
                ->paginate(20);
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
        /*Obtener los RFC's de los Productores de la taba de usuarios MySQL*/
        $main_rfc_by_user = User::whereNotNull('razonsocial')
                    ->where('razonsocial', '<>', '')
                    ->get();
        /*Obtener los otros RFC's relacionados al RFC principal de SQL*/
        foreach($main_rfc_by_user as $main_rfc){
            $user_id = $main_rfc->id;
            $other_rfcs = SplendorUser::where('CRFC', '=', $main_rfc->rfc)->get();
            foreach($other_rfcs as $other_rfc){
                $cidclienteproveedor = $other_rfc->CIDCLIENTEPROVEEDOR;
                //reviso que el $cidclienteproveedor no exista en la tabla user_rfcs
                $cidclienteproveedor_exist = SysSplendorUserRfcs::where('cidclienteproveedor', '=', $cidclienteproveedor)->first();
                if( !$cidclienteproveedor_exist ){
                    $razon_social = new RazonesSocialesByUser();
                    $razon_social->user_id = $user_id;
                    $razon_social->cidclienteproveedor = $other_rfc->CIDCLIENTEPROVEEDOR;
                    $razon_social->ccodigocliente = $other_rfc->CCODIGOCLIENTE;
                    $razon_social->crazonsocial = $other_rfc->CRAZONSOCIAL;
                    $razon_social->save(); 
                }
            }
        }
        /****************************/
        /******* FACTURAS ********* */
        /****************************/
        $userRfcs = SysSplendorUserRfcs::get();
        foreach($userRfcs as $user_rfc){
            $user_id = $user_rfc->user_id;
            $id_cliente_proveedor = $user_rfc->cidclienteproveedor;
            //SE OBTINE EL ROL QUE TIENE DOCUMENTOS RELACIONADOS CON EL ID 19 (Facturas)
            $docs = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CIDCONCEPTODOCUMENTO', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTALUNIDADES', 'CUNIDADESPENDIENTES', 'CCANCELADO')
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
                        'user_id' => $user_id,
                        'rfc' => $doc_invoice->CRFC,
                        'description' => $doc_invoice->CREFERENCIA,
                        'financiamiento' => $doc_invoice->CIMPORTEEXTRA1,
                        'regalias' => $doc_invoice->CIMPORTEEXTRA2,
                        'plantas' => $doc_invoice->CIMPORTEEXTRA3,
                        'materiales' => $doc_invoice->CIMPORTEEXTRA4,
                        'monto' => $doc_invoice->CTOTAL,
                        'moneda' => $doc_invoice->CIDMONEDA,
                        'tipocambio' => round($doc_invoice->CTIPOCAMBIO, 2),
                        'fecha' => $doc_invoice->CFECHA,
                        'semana' => getWeekNumber($doc_invoice->CFECHA),
                        'cancelado' => $doc_invoice->CCANCELADO,
                        'id_status' => 1,
                    ];
                    Invoice::insert($invoicesToInsert);    
                }
            }
        }
        /*************************/
        /*******FRUTAS **********/
        /*************************/
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        foreach($userRfcs as $user_rfc){
            $user_id = $user_rfc->user_id;
            $id_cliente_proveedor = $user_rfc->cidclienteproveedor;
            //SE OBTINE EL ROL QUE TIENE DOCUMENTOS RELACIONADOS CON EL ID 18 (FRUTAS)
            $documentos = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CIDCONCEPTODOCUMENTO', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTALUNIDADES', 'CUNIDADESPENDIENTES')
            ->where('CIDDOCUMENTODE', '=' , 18)
            ->where('CIDCLIENTEPROVEEDOR', '=' , $id_cliente_proveedor)
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
                                'user_id' => $user_id,
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
        /*************************/
        /******* PLANTAS *********/
        /*************************/
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        foreach($userRfcs as $user_rfc){
            $user_id = $user_rfc->user_id;
            $id_cliente_proveedor = $user_rfc->cidclienteproveedor;
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
                        'user_id' => $user_id,
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
        /*************************/
        /******* PRESTAMOS *******/
        /*************************/
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        foreach($userRfcs as $user_rfc){
            $user_id = $user_rfc->user_id;
            $id_cliente_proveedor = $user_rfc->cidclienteproveedor;
            //SE OBTINE EL ROL QUE TIENE DOCUMENTOS RELACIONADOS CON EL ID 15 y 14 (PRESTAMOS Y DESCUENTOS)
            $docs_prestamos = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTAL', 'CNATURALEZA', 'CPENDIENTE', 'CIDMONEDA', 'CTIPOCAMBIO')
            ->where('CIDDOCUMENTODE', '=' , 15)
            ->where('CIDCLIENTEPROVEEDOR', '=' , $id_cliente_proveedor)
            ->get();
            if( count($docs_prestamos) > 0){
                $cids_docs = [];
                foreach($docs_prestamos as $doc_prestamo){
                    $cids_docs[] = $doc_prestamo->CIDDOCUMENTO;
                }
                //Obtengo los id de los prestamos que ya existen en la base de datos
                $existingIds = Prestamo::pluck('cididdocumento')->toArray();
                // Compara el array $cids_docs con $existingIds y devuelve los que no existen en la base de datos
                $new_cids_docs = array_filter($cids_docs, function ($item) use ($existingIds) {
                    return !in_array($item, $existingIds);
                });
                $docs_prestamos = SplendorTablaDocumentos::whereIn('CIDDOCUMENTO', $new_cids_docs)->get();
                foreach($docs_prestamos as $doc_prestamo){
                    $prestamosToInsert = [
                        'cididdocumento' => $doc_prestamo->CIDDOCUMENTO,
                        'user_id' => $user_id,
                        'fecha' => $doc_prestamo->CFECHA,
                        'serie' => $doc_prestamo->CSERIEDOCUMENTO,
                        'folio' => $doc_prestamo->CFOLIO,
                        'moneda' => $doc_prestamo->CIDMONEDA,
                        'tipodecambio' => $doc_prestamo->CTIPOCAMBIO,
                        'total' => $doc_prestamo->CTOTAL,
                        'naturaleza' => $doc_prestamo->CNATURALEZA,
                        'pendiente' => $doc_prestamo->CPENDIENTE,
                    ];
                    Prestamo::insert($prestamosToInsert);    
                }
                
            }
            $docs_descuentos = SplendorTablaDocumentos::select('CIDDOCUMENTO',  'CIDDOCUMENTODE', 'CSERIEDOCUMENTO', 'CFOLIO', 'CFECHA', 'CTOTAL', 'CNATURALEZA', 'CPENDIENTE', 'CIDMONEDA', 'CTIPOCAMBIO')
            ->where('CIDDOCUMENTODE', '=' , 14)
            ->where('CIDCLIENTEPROVEEDOR', '=' , $id_cliente_proveedor)
            ->get();
            if( count($docs_descuentos) > 0){
                $cids_docs = [];
                foreach($docs_descuentos as $doc_descuento){
                    $cids_docs[] = $doc_descuento->CIDDOCUMENTO;
                }
                //Obtengo los id de las plantas que ya existen en la base de datos
                $existingIds = Prestamo::pluck('cididdocumento')->toArray();
                // Compara el array $cids_docs con $existingIds y devuelve los que no existen en la base de datos
                $new_cids_docs = array_filter($cids_docs, function ($item) use ($existingIds) {
                    return !in_array($item, $existingIds);
                });
                $docs_descuentos = SplendorTablaDocumentos::whereIn('CIDDOCUMENTO', $new_cids_docs)->get();
                foreach($docs_descuentos as $doc_descuento){
                    $prestamosToInsert = [
                        'cididdocumento' => $doc_descuento->CIDDOCUMENTO,
                        'user_id' => $user_id,
                        'fecha' => $doc_descuento->CFECHA,
                        'serie' => $doc_descuento->CSERIEDOCUMENTO,
                        'folio' => $doc_descuento->CFOLIO,
                        'moneda' => $doc_prestamo->CIDMONEDA,
                        'tipodecambio' => $doc_prestamo->CTIPOCAMBIO,
                        'total' => $doc_descuento->CTOTAL,
                        'naturaleza' => $doc_descuento->CNATURALEZA,
                        'pendiente' => $doc_descuento->CPENDIENTE,
                    ];
                    Prestamo::insert($prestamosToInsert);    
                }
            }
        }
        /*************************/
        /******* REGALIAS ********/
        /*************************/
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        foreach($userRfcs as $user_rfc){
            $user_id = $user_rfc->user_id;
            $id_cliente_proveedor = $user_rfc->cidclienteproveedor;
            //SE OBTINE CLIENTES CON REGALIAS
            $regalias_clientes = SplendorTablaClientes::select('CIDCLIENTEPROVEEDOR')
                                 ->where('CIDCLIENTEPROVEEDOR', '=', $id_cliente_proveedor)
                                 ->where('CIDVALORCLASIFCLIENTE1', '=', 30)
                                 ->get();
            if( count($regalias_clientes) > 0){
                
                foreach($regalias_clientes as $regalias_cliente){
                    $regalias_documents = SplendorTablaDocumentos::select('admDocumentos.CIDDOCUMENTO',  'admDocumentos.CIDDOCUMENTODE', 'admDocumentos.CSERIEDOCUMENTO', 'admDocumentos.CSERIEDOCUMENTO', 'admDocumentos.CFECHA', 'admDocumentos.CSERIEDOCUMENTO', 'admDocumentos.CFOLIO', 'admDocumentos.CIMPUESTO1', 'admDocumentos.CTOTAL', 'admDocumentos.CPENDIENTE', 'CNOMBREPRODUCTO')
                                           ->leftJoin('admMovimientos', 'admMovimientos.CIDDOCUMENTO', '=', 'admDocumentos.CIDDOCUMENTO')
                                           ->leftJoin('admProductos', 'admProductos.CIDPRODUCTO', '=', 'admMovimientos.CIDPRODUCTO')
                                           ->where('CIDCLIENTEPROVEEDOR', '=', $regalias_cliente->CIDCLIENTEPROVEEDOR)
                                           ->where('admDocumentos.CIDDOCUMENTODE', '=', 4)
                                           ->get();
                    if( count($regalias_documents) > 0){
                        $cids_docs = [];
                        foreach($regalias_documents as $regalias_document){
                            $cids_docs[] = $regalias_document->CIDDOCUMENTO;
                        }
                        //Obtengo los id de las regalias que ya existen en la base de datos
                        $existingIds = Regalia::pluck('cididdocumento')->toArray();
                        // Compara el array $cids_docs con $existingIds y devuelve los que no existen en la base de datos
                        $new_cids_docs = array_filter($cids_docs, function ($item) use ($existingIds) {
                            return !in_array($item, $existingIds);
                        });
                        $regalias_documents = SplendorTablaDocumentos::select('admDocumentos.CIDDOCUMENTO',  'admDocumentos.CIDDOCUMENTODE', 'admDocumentos.CSERIEDOCUMENTO', 'admDocumentos.CSERIEDOCUMENTO', 'admDocumentos.CFECHA', 'admDocumentos.CSERIEDOCUMENTO', 'admDocumentos.CFOLIO', 'admDocumentos.CIMPUESTO1', 'admDocumentos.CTOTAL', 'admDocumentos.CPENDIENTE', 'CNOMBREPRODUCTO')
                                            ->leftJoin('admMovimientos', 'admMovimientos.CIDDOCUMENTO', '=', 'admDocumentos.CIDDOCUMENTO')
                                            ->leftJoin('admProductos', 'admProductos.CIDPRODUCTO', '=', 'admMovimientos.CIDPRODUCTO')
                                            ->whereIn('admDocumentos.CIDDOCUMENTO', $new_cids_docs)
                                            ->get();
                        foreach($regalias_documents as $regalias_document){
                            $regaliasToInsert = [
                                'cididdocumento' => $regalias_document->CIDDOCUMENTO,
                                'user_id' => $user_id,
                                'fecha' => $regalias_document->CFECHA,
                                'semana' => getWeekNumber($regalias_document->CFECHA),
                                'serie' => $regalias_document->CSERIEDOCUMENTO,
                                'folio' => $regalias_document->CFOLIO,
                                'concepto' => $regalias_document->CNOMBREPRODUCTO,
                                'importe' => $regalias_document->CTOTAL,
                                'iva' => $regalias_document->CIMPUESTO1,
                                'total' => $regalias_document->CTOTAL,
                                'pendiente' => $regalias_document->CPENDIENTE,
                            ];
                            Regalia::insert($regaliasToInsert);    
                        }
                    }
                }
            }
        }
        /*************************/
        /******* MATERIALES ********/
        /*************************/
        //SE ONTIENEN TODOS LOS ROLES DE CADA PRODUCTOR
        foreach($userRfcs as $user_rfc){
            $user_id = $user_rfc->user_id;
            $ccodigocliente = $user_rfc->ccodigocliente;
            $crazonsocial = $user_rfc->crazonsocial;
            //SE OBTIENEN LOS ALMANCES
            $almacenes = SplendorTablaAlmacenes::select('CIDALMACEN', 'CCODIGOALMACEN' )
                         ->where('CCODIGOALMACEN', '=', $ccodigocliente)
                         ->where('CIDVALORCLASIFICACION1', '=', 91)
                         ->get();
            if( count($almacenes) > 0){                    
                foreach($almacenes as $almacen){
                    $movimiento_almacen = SplendorTablaMovimientos::select('admMovimientos.CIDPRODUCTO', 'CNOMBREPRODUCTO')
                        ->join('admProductos', 'admProductos.CIDPRODUCTO', '=', 'admMovimientos.CIDPRODUCTO')
                        ->selectRaw('SUM(CASE WHEN CIDDOCUMENTO > 0 THEN CUNIDADES ELSE 0 END) AS unidades_agregadas')
                        ->selectRaw('SUM(CASE WHEN CIDDOCUMENTO = 0 THEN CUNIDADES ELSE 0 END) AS unidades_restadas')
                        ->where('CIDALMACEN', '=', $almacen->CIDALMACEN)
                        ->groupBy('admMovimientos.CIDPRODUCTO', 'CNOMBREPRODUCTO' )
                        ->get();
                    if( count($movimiento_almacen) > 0){
                        foreach($movimiento_almacen as $movimiento){
                            $materialesToInsert = [
                                'cidproducto' => $movimiento->CIDPRODUCTO,
                                'user_id' => $user_id,
                                'nombre' => $movimiento->CNOMBREPRODUCTO,
                                'u_agregadas' => $movimiento->unidades_agregadas,
                                'u_restadas' => $movimiento->unidades_restadas,
                            ];
                            $cidproducto_exist = Material::where('cidproducto', '=', $movimiento->CIDPRODUCTO)->first();
                            if( !$cidproducto_exist ){
                                Material::insert($materialesToInsert);    
                            }else{
                                $cidproducto_exist->update($materialesToInsert);
                            }
                        }
                    }

                }
            }
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
        $filtros = [$productor,$estatus,$week];
        $estatus = Estatus::all();
        return view('invoices.filters', compact('invoices', 'estatus', 'filtros' ));
    }
}
