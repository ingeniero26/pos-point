// Función mejorada para imprimir el ticket de venta
function printSalesTicket(sale) {
    console.log("Sale data for ticket:", sale);

    // Obtener datos de la empresa
    const companyData = {
        name: '{{ Auth::user()->company->name ?? "Empresa" }}',
        address: '{{ Auth::user()->company->address ?? "Dirección" }}',
        phone: '{{ Auth::user()->company->phone ?? "Teléfono" }}',
        nit: '{{ Auth::user()->company->identification_number ?? "NIT" }}',
        email: '{{ Auth::user()->company->email ?? "" }}',
    };

    // Obtener datos del cliente
    const customerName =
        $("#customer_id option:selected").text() || "Cliente General";
    const customerDocument = $("#customer_document").val() || "N/A";
    const customerAddress = $("#customer_address").val() || "";
    const customerPhone = $("#customer_phone").val() || "";

    // Obtener datos de la factura
    const invoiceNo =
        sale?.invoice_no || $("#series").val() + "-" + $("#number").val();
    const invoiceDate = sale?.date_of_issue || $("#date_of_issue").val();
    const currentTime = new Date().toLocaleTimeString("es-CO", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    // Obtener datos de pago
    const paymentForm =
        $("#payment_form_id option:selected").text() || "Contado";
    const paymentMethod =
        $("#payment_method_id option:selected").text() || "Efectivo";

    // Crear ventana de impresión
    const printWindow = window.open("", "_blank", "width=300,height=600");

    // Construir el contenido del ticket mejorado
    let ticketContent = `
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Factura ${invoiceNo}</title>
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                    font-family: 'Courier New', monospace;
                    font-size: 11px;
                    line-height: 1.2;
                    color: #000;
                    width: 80mm;
                    margin: 0 auto;
                    padding: 5mm;
                }
                
                .ticket {
                    width: 100%;
                }
                
                .header {
                    text-align: center;
                    margin-bottom: 8px;
                    border-bottom: 1px dashed #000;
                    padding-bottom: 8px;
                }
                
                .company-name {
                    font-size: 14px;
                    font-weight: bold;
                    margin-bottom: 2px;
                    text-transform: uppercase;
                }
                
                .company-info {
                    font-size: 10px;
                    margin-bottom: 1px;
                }
                
                .invoice-info {
                    text-align: center;
                    margin: 8px 0;
                    font-weight: bold;
                    font-size: 12px;
                }
                
                .customer-info {
                    margin: 8px 0;
                    border-bottom: 1px dashed #000;
                    padding-bottom: 8px;
                }
                
                .info-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 2px;
                    font-size: 10px;
                }
                
                .info-label {
                    font-weight: bold;
                    min-width: 60px;
                }
                
                .items-header {
                    font-weight: bold;
                    text-align: center;
                    margin: 8px 0 5px 0;
                    font-size: 11px;
                }
                
                .items {
                    margin-bottom: 8px;
                }
                
                .item {
                    margin-bottom: 4px;
                    font-size: 10px;
                }
                
                .item-line1 {
                    display: flex;
                    justify-content: space-between;
                    font-weight: bold;
                }
                
                .item-line2 {
                    display: flex;
                    justify-content: space-between;
                    font-size: 9px;
                    color: #666;
                    margin-left: 10px;
                }
                
                .totals {
                    border-top: 1px dashed #000;
                    padding-top: 8px;
                    margin-bottom: 8px;
                }
                
                .total-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 2px;
                    font-size: 10px;
                }
                
                .total-final {
                    font-weight: bold;
                    font-size: 12px;
                    border-top: 1px solid #000;
                    padding-top: 3px;
                    margin-top: 3px;
                }
                
                .payment-info {
                    border-top: 1px dashed #000;
                    padding-top: 8px;
                    margin-bottom: 8px;
                    text-align: center;
                }
                
                .footer {
                    text-align: center;
                    font-size: 9px;
                    border-top: 1px dashed #000;
                    padding-top: 8px;
                }
                
                .footer-message {
                    margin: 3px 0;
                }
                
                @media print {
                    body {
                        width: 80mm;
                        margin: 0;
                        padding: 2mm;
                    }
                }
            </style>
        </head>
        <body>
            <div class="ticket">
                <!-- Header con información de la empresa -->
                <div class="header">
                    <div class="company-name">${companyData.name}</div>
                    <div class="company-info">${companyData.address}</div>
                    <div class="company-info">Tel: ${companyData.phone}</div>
                    ${
                        companyData.email
                            ? `<div class="company-info">Email: ${companyData.email}</div>`
                            : ""
                    }
                    <div class="company-info">NIT: ${companyData.nit}</div>
                </div>
                
                <!-- Información de la factura -->
                <div class="invoice-info">
                    FACTURA DE VENTA<br>
                    No. ${invoiceNo}
                </div>
                
                <!-- Información del cliente -->
                <div class="customer-info">
                    <div class="info-row">
                        <span class="info-label">Cliente:</span>
                        <span>${customerName}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Documento:</span>
                        <span>${customerDocument}</span>
                    </div>
                    ${
                        customerAddress
                            ? `<div class="info-row"><span class="info-label">Dirección:</span><span>${customerAddress}</span></div>`
                            : ""
                    }
                    ${
                        customerPhone
                            ? `<div class="info-row"><span class="info-label">Teléfono:</span><span>${customerPhone}</span></div>`
                            : ""
                    }
                    <div class="info-row">
                        <span class="info-label">Fecha:</span>
                        <span>${new Date(invoiceDate).toLocaleDateString(
                            "es-CO"
                        )}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Hora:</span>
                        <span>${currentTime}</span>
                    </div>
                </div>
                
                <!-- Productos -->
                <div class="items-header">DETALLE DE PRODUCTOS</div>
                <div class="items">
    `;

    // Agregar productos con mejor formato
    let itemCount = 0;
    $(".product-row").each(function () {
        const quantity = parseFloat($(this).find(".quantity").val()) || 0;
        const productName =
            $(this).find(".product-name").text().trim() || "Producto";
        const price = parseFloat($(this).find(".price").val()) || 0;
        const subtotal = parseFloat($(this).find(".subtotal").val()) || 0;

        if (quantity > 0) {
            itemCount++;
            ticketContent += `
                <div class="item">
                    <div class="item-line1">
                        <span>${quantity} x ${productName}</span>
                        <span>$${subtotal.toLocaleString("es-CO", {
                            minimumFractionDigits: 0,
                        })}</span>
                    </div>
                    <div class="item-line2">
                        <span>Precio unitario: $${price.toLocaleString(
                            "es-CO",
                            { minimumFractionDigits: 0 }
                        )}</span>
                    </div>
                </div>
            `;
        }
    });

    // Si no hay productos, mostrar mensaje
    if (itemCount === 0) {
        ticketContent += `
            <div class="item">
                <div class="item-line1">
                    <span>No hay productos registrados</span>
                </div>
            </div>
        `;
    }

    // Obtener totales
    const subtotal = parseFloat($("#total_subtotal").val()) || 0;
    const discount = parseFloat($("#total_discount").val()) || 0;
    const tax = parseFloat($("#total_tax").val()) || 0;
    const total = parseFloat($("#total_sale").val()) || 0;

    // Agregar totales
    ticketContent += `
                </div>
                
                <!-- Totales -->
                <div class="totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span>$${subtotal.toLocaleString("es-CO", {
                            minimumFractionDigits: 0,
                        })}</span>
                    </div>
    `;

    if (discount > 0) {
        ticketContent += `
            <div class="total-row">
                <span>Descuento:</span>
                <span>-$${discount.toLocaleString("es-CO", {
                    minimumFractionDigits: 0,
                })}</span>
            </div>
        `;
    }

    if (tax > 0) {
        ticketContent += `
            <div class="total-row">
                <span>Impuestos:</span>
                <span>$${tax.toLocaleString("es-CO", {
                    minimumFractionDigits: 0,
                })}</span>
            </div>
        `;
    }

    ticketContent += `
                    <div class="total-row total-final">
                        <span>TOTAL A PAGAR:</span>
                        <span>$${total.toLocaleString("es-CO", {
                            minimumFractionDigits: 0,
                        })}</span>
                    </div>
                </div>
                
                <!-- Información de pago -->
                <div class="payment-info">
                    <div><strong>Forma de Pago:</strong> ${paymentForm}</div>
                    <div><strong>Método de Pago:</strong> ${paymentMethod}</div>
                </div>
                
                <!-- Footer -->
                <div class="footer">
                    <div class="footer-message">¡Gracias por su compra!</div>
                    <div class="footer-message">Conserve este comprobante</div>
                    <div class="footer-message">Software: Sistema de Ventas</div>
                    <div class="footer-message">Impreso: ${new Date().toLocaleString(
                        "es-CO"
                    )}</div>
                </div>
            </div>
        </body>
        </html>
    `;

    // Escribir contenido y configurar impresión
    printWindow.document.write(ticketContent);
    printWindow.document.close();

    // Configurar la impresión
    printWindow.onload = function () {
        setTimeout(function () {
            printWindow.focus();
            printWindow.print();

            // Opcional: cerrar ventana después de imprimir
            setTimeout(function () {
                printWindow.close();
            }, 1000);
        }, 500);
    };

    // Fallback si onload no funciona
    setTimeout(function () {
        if (printWindow && !printWindow.closed) {
            printWindow.print();
        }
    }, 1500);
}
