# PHP CLI Expense Tracker

Solución para el desafío [Expense Tracker](https://roadmap.sh/projects/expense-tracker) de [roadmap.sh](https://roadmap.sh/).

Este es un rastreador de gastos simple basado en una interfaz de línea de comandos (CLI) construido en PHP. Te permite agregar, listar, actualizar, eliminar y resumir gastos. También puedes establecer y visualizar un presupuesto mensual.

## Características

- **Agregar Gastos**: Registra un nuevo gasto con una descripción, cantidad y categoría opcional.
- **Listar Gastos**: Muestra todos los gastos registrados, con la opción de filtrarlos por categoría.
- **Listar Categorías**: Lista todas las categorías de gastos junto con el número de artículos en cada categoría.
- **Actualizar Gastos**: Modifica un gasto existente.
- **Eliminar Gastos**: Elimina un gasto por su ID.
- **Resumen de Gastos**: Muestra un resumen del total de gastos, con la opción de filtrarlo por mes.
- **Establecer Presupuesto**: Permite establecer un presupuesto mensual y muestra una advertencia si se excede.

## Instalación

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/tu_usuario/expense-tracker.git
   ```

2. **Instala las dependencias usando Composer:**

   ```bash
   composer install
   ```

3. **Configura el autoload de Composer:**

   Asegúrate de que el autoload de Composer esté configurado correctamente para cargar las clases bajo el espacio de nombres `App`.

## Uso

### Agregar un gasto

```bash
php app.php add --description="Cena con amigos" --amount=50 --category="Entretenimiento"
```

### Listar gastos

```bash
php app.php list
```

Opcionalmente, puedes filtrar por categoría:

```bash
php app.php list --category="Entretenimiento"
```

### Listar categorías

```bash
php app.php list --list-categories
```

### Actualizar un gasto

```bash
php app.php update --id=1 --description="Cena familiar" --amount=60 --category="Alimentos"
```

### Eliminar un gasto

```bash
php app.php delete --id=1
```

### Resumen de gastos

```bash
php app.php summary --month=8
```
