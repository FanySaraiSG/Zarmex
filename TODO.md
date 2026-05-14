# TODO - Barra de búsqueda con base de datos

- [x] Editar `resources/views/header.blade.php`:
  - [x] Cambiar el `<form>` para que apunte a la ruta `buscar.resultados`.
  - [x] Actualizar el JS del buscador para llamar `GET /buscar-sugerencias?q=...`.
  - [x] Renderizar el dropdown `#zxResultsList` con resultados del autocomplete.
  - [x] Hacer que al enviar el formulario navegue a la página completa `/buscar`.

- [ ] Verificar manualmente:
  - [ ] Ingresar texto en la barra y confirmar que aparecen sugerencias.
  - [ ] Confirmar que el click en una sugerencia abre el producto.
  - [ ] Confirmar que el submit del formulario abre la página `/buscar` con resultados paginados.

