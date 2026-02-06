<x-app-layout>
  @auth('employee')
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Top 5 Productos Más Vendidos</title>
    <style>
      nav { background-color: inherit !important; }
      .table { background-color: white !important; }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      <!-- Botones superiores -->
      <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-secondary btn-sm" href="{{ route('admin.dashboard') }}">Regresar</a>
      </div>

      <!-- Título -->
      <h2 class="mb-3" style="color:white; text-align: center;">Top 5 Productos Más Vendidos</h2>

      <!-- Mensaje de éxito -->
      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <!-- Tabla de productos más vendidos -->
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Producto</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($topProducts as $topProduct)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                <select name="product_id" class="form-control auto-submit" data-id="{{ $topProduct->id }}">
                  <option value="">Ninguno</option>
                  @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $topProduct->product_id == $product->id ? 'selected' : '' }}>
                      {{ $product->id }}
                    </option>
                  @endforeach
                </select>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.auto-submit').forEach(select => {
          select.addEventListener('change', function() {
            let productId = this.value;
            let topProductId = this.dataset.id;

            fetch(`/top-products/${topProductId}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({ product_id: productId })
            }).then(response => response.json())
              .then(data => {
                  console.log(data);
              }).catch(error => console.error(error));
          });
        });
      });
    </script>
  </body>
  </html>
  @endauth
  @if(session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</x-app-layout>
