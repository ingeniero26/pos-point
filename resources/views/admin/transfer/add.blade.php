@extends('layouts.app')
  
@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Traslado entre Bodegas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Traslado Productos
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>


<div class="app-content-body">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Traslado de Productos</h3>
                    </div>
                    <div class="card-body">
                        <!-- Your form here -->
                      
                    <form action="{{route('admin.transfer.store')}}" method="POST">
                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bodega_origen" class="form-label">Bodega Origen</label>
                                        <select id="from_warehouse_id" name="from_warehouse_id" class="form-select">
                                            @foreach($warehouses as $bodega)
                                            <option value="{{ $bodega->id }}">{{ $bodega->warehouse_name }}</option>
                                            @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione una Bodega de Origen.
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="to_warehouse_id" class="form-label">Bodega Destino</label>
                                        <select id="to_warehouse_id" name="to_warehouse_id" class="form-select">
                                            @foreach($warehouses as $bodega)
                                            <option value="{{ $bodega->id }}">{{ $bodega->warehouse_name }}</option>
                                            @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Seleccione una Bodega de Destino.
                                            </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <label for="">Motivo del traslado</label>
                                        
                                        <textarea id="description" name="description"
                                         class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fecha_traslado" class="form-label">Fecha del Traslado</label>
                                            <input type="date" id="transfer_date" name="transfer_date" class="form-control" required>
                                            <div class="invalid-feedback">
                                                Ingrese una Fecha de Traslado.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for=""><b>Estado Traslado</b></label>
                                        <select id="status_transfer_id" name="status_transfer_id" class="form-select">
                                            @foreach($status_transfer as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                            </select>
                                        </select>
                                    </div>
                                </div>
                               <div class="row">
                                <div class="col-md-9">
                                    <label for="">Buscar Productos</label>
                                    <select name="item_id" id="item_id" class="form-select selectpicker" data-live-search="true" title="Buscar Item">
                                        @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->barcode.' '. $item->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Cantidad a trasladar</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" >
                               </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2 mt-2 text-end">
                                    <button type="button" class="btn btn-primary mt-3" 
                                    id="add-item">Agregar Producto</button>
                                   </div>
                                  
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered" id="table_detail">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-success mt-3" id="transfer_form">Trasladar Productos</button>
                                    <button type="reset" class="btn btn-secondary mt-3">Limpiar</button>
                               </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>       
</main>             
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#add-item').click(function(){
            addItemProduct();
        });
    });
    let cont = 0;
    
    function addItemProduct(){
       let itemId = $('#item_id').val();
        let itemName = $('#item_id option:selected').text();
        let itemQuantity = $('#quantity').val();
       if(itemId == ''){
            alert('Debe seleccionar un producto');
            return false;
       }
       
       if(isNaN(itemQuantity)){
            alert('La cantidad a trasladar debe ser un número');
            return false;
       }
       
       if(itemQuantity < 0){
            alert('La cantidad a trasladar debe ser mayor o igual a cero');
            return false;
       }
       if(itemQuantity == 0){
            alert('La cantidad a trasladar debe ser mayor a cero');
            return false;
       }

       if(itemQuantity == ''){
            alert('Debe ingresar la cantidad a trasladar');
            return false;
       }

       let fila = '<tr id="fila'+cont+'">'+
                    '<td>'+ (cont+1)+'</td>'+
                    '<td> <input type="hidden" name="arrayitemId[]" value="'+itemId+'">'+ itemName +'</td>'+
                    '<td> <input type="hidden" class="itemQuantity" name="arrayitemQuantity[]" value="'+itemQuantity+'">'+ itemQuantity +'</td>'+
                    '<td><button class="btn  btn-danger" type="button" onClick="deleteItem('+cont+')"><i class="fa-solid fa-trash"></i></button></td>'+
                    '</tr>';
                    $('#table_detail tbody').append(fila);
                    
       cont++;
       clearItem();
    }

    function clearItem() {
        $('#item_id').val('');
        $('#quantity').val('');
        $('#item_id').selectpicker('refresh');

    }
    function deleteItem(indice){
        $('#fila'+indice).remove();
        cont--;
    }
    $('form').on('submit', function (e) {
    e.preventDefault();

    var items = [];
    $('#table_detail tbody tr').each(function () {
        var itemId = $(this).find('input[name="arrayitemId[]"]').val(); // Captura el itemId del input oculto
        var quantity = $(this).find('input[name="arrayitemQuantity[]"]').val(); // Captura el itemId del input oculto
        //var quantity = parseFloat($(this).find('itemQuantity').val());

        var item = {
            itemId: itemId,
            quantity: quantity
        };
        items.push(item);
    });

    var filteredItems = items.filter(function(item) {
    return item.itemId !== undefined && item.quantity !== undefined;
});

    var formData = {
        from_warehouse_id: $('#from_warehouse_id').val(),
        to_warehouse_id: $('#to_warehouse_id').val(),
        transfer_date: $('#transfer_date').val(),
        description: $('#description').val(),
        status_transfer_id: $('#status_transfer_id').val(),
        items: filteredItems 
    };
    console.log(formData);

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: JSON.stringify(formData),
       
        contentType: 'application/json',
        
        headers: {
        
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        
        success: function (response) {
            alert('Traslado guardado correctamente');
            window.location.reload();
        },
        error: function (response) {
            alert('Error al guardar el traslado');
        }
    });
});
</script>
@endsection
