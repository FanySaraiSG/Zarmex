<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
    <title>Pago</title>
</head>
<body>
<div class="container">
            <h2 class="text-center mb-4">Métodos de Pago</h2>
    
            <div class="card2-container">
                <div class="card2">
                    <img src="images/visa.png" alt="Visa">
                    <div class="card-content">
                        <h3>Visa</h3>
                        <p>Terminación: **** 1234</p>
                        <p>Vence: 12/26</p>
                        <div class="add-to-cart">
                            <button class="add-to-cart-btn">
                                <i class="fas fa-check-circle"></i> Seleccionar
                            </button>
                            <button class="add-to-cart-btn">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="add-to-cart-btn">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
    
                <div class="card2">
                    <img src="images/mastercard.png" alt="MasterCard">
                    <div class="card-content">
                        <h3>MasterCard</h3>
                        <p>Terminación: **** 5678</p>
                        <p>Vence: 08/25</p>
                        <div class="add-to-cart">
                            <button class="add-to-cart-btn">
                                <i class="fas fa-check-circle"></i> Seleccionar
                            </button>
                            <button class="add-to-cart-btn">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="add-to-cart-btn">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="text-center mt-4">
                <button class="buy-btn">
                    <i class="fas fa-plus-circle"></i> Agregar Método de Pago
                </button>
            </div>
        </div>

</body>
</html>
</x-app-layout>