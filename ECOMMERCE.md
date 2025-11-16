# Ecommerce con Arquitectura Hexagonal - Guía de Uso

## Descripción General
Este proyecto implementa un ecommerce básico (MVP) utilizando **arquitectura hexagonal** con PHP 8.3, MySQL y Docker.

## Estructura Implementada

### 1. **Dominio (Domain Layer)**
Contiene la lógica de negocio pura:

#### Entidades:
- **Product**: Representa un producto con atributos (SKU, nombre, precio, stock, estado activo)
  - Métodos: `hasEnoughStock()`, `decreaseStock()`, `increaseStock()`
- **Order**: Representa una orden con estado (pending, paid, failed, canceled, shipped)
  - Métodos: `markAsPaid()`, `markAsFailed()`, `addItem()`
- **OrderItem**: Representa un artículo dentro de una orden
  - Calcula subtotales automáticamente
- **User**: Entidad existente de gestión de usuarios

#### Repositorios (Puertos):
- `ProductRepositoryInterface`: Contrato para operaciones CRUD de productos
- `OrderRepositoryInterface`: Contrato para operaciones de órdenes
- `UserRepositoryInterface`: Contrato existente para usuarios

### 2. **Aplicación (Application Layer)**
Contiene los casos de uso (business logic orquestación):

- **ListProducts**: Lista productos activos o todos
- **ShowProduct**: Obtiene detalle de un producto
- **CreateProduct**: Crea nuevo producto (admin)
- **CreateOrder**: Crea una orden desde el carrito
- **ListUsers**: Lista usuarios (existente)
- **CreateUser, UpdateUser, DeleteUser**: Gestión de usuarios (existente)

### 3. **Infraestructura (Infrastructure Layer)**

#### Adaptadores de Persistencia:
- **MySQLProductRepository**: Implementa operaciones CRUD de productos en MySQL
- **MySQLOrderRepository**: Implementa operaciones de órdenes y artículos
- **MySQLUserRepository**: Implementa operaciones de usuarios (existente)
- **Database**: Conexión y configuración de PDO

#### Adaptadores Web (Controllers y Vistas):
- **ProductController**: Maneja catálogo y formulario de creación
- **CartController**: Maneja carrito de compras (session-based)
- **OrderController**: Maneja checkout y confirmación de orden
- **AuthController**: Maneja login/logout (existente)
- **UserController**: Maneja creación, edición, borrado de usuarios (existente)

#### Vistas:
- `products_catalog.php`: Listado de productos activos
- `product_detail.php`: Detalle de producto con opción de agregar al carrito
- `product_form.php`: Formulario de creación de producto (admin)
- `cart.php`: Vista del carrito
- `checkout.php`: Resumen de pedido
- `order_success.php`: Confirmación de pedido
- Más vistas de usuarios (existentes)

## Tablas de Base de Datos (init.sql)

```sql
-- Productos
CREATE TABLE `products` (
  id, sku (unique), name, description, price, currency, 
  stock, active, created_at
)

-- Órdenes
CREATE TABLE `orders` (
  id, customer_id (FK users), status, total, currency,
  created_at, paid_at
)

-- Artículos de Orden
CREATE TABLE `order_items` (
  id, order_id (FK orders), product_id (FK products),
  product_name, quantity, price, currency
)
```

## Flujo de Uso (Happy Path)

### 1. **Comprador visualiza catálogo**
```
GET /?shop=catalog
→ ProductController::index()
→ ListProducts use case
→ products_catalog.php (renderiza 8 productos de seed)
```

### 2. **Comprador ve detalle de producto**
```
GET /?shop=product&id=1
→ ProductController::show()
→ ShowProduct use case
→ product_detail.php
```

### 3. **Comprador añade al carrito**
```
POST /?cart=add
  - product_id=1
  - quantity=2
→ CartController::add()
→ Guarda en $_SESSION['cart']
→ Redirige a /?cart=view
```

### 4. **Comprador revisa carrito**
```
GET /?cart=view
→ CartController::view()
→ cart.php (muestra artículos en sesión)
```

### 5. **Comprador procesa checkout (requiere login)**
```
POST /?order=checkout
→ OrderController::checkout()
→ CreateOrder use case (valida stock, calcula total)
→ Persiste Order + OrderItems en BD
→ Limpia $_SESSION['cart']
→ Redirige a /?order=success&id=123
```

### 6. **Comprador ve confirmación**
```
GET /?order=success&id=123
→ OrderController::viewOrder()
→ order_success.php
```

## Seeds de Productos
Se incluyen 8 productos de ejemplo en `init.sql`:
- Laptop HP Pavilion 15 ($899.99)
- Mouse Logitech MX Master 3 ($99.99)
- Teclado Mecánico Corsair K95 ($199.99)
- Monitor LG UltraWide 34" ($599.99)
- Audífonos Sony WH-1000XM5 ($399.99)
- Webcam Logitech C920 Pro ($79.99)
- Escritorio Gaming RGB ($299.99)
- Silla Gaming Ergonómica ($249.99)

## Rutas Principales

### Catálogo y Productos
- `/?shop=catalog` - Listar productos activos
- `/?shop=product&id=N` - Ver detalle de producto
- `/?shop=create` - Formulario crear producto (admin)
- `/?shop=store` - Procesar creación (POST)

### Carrito
- `/?cart=view` - Ver carrito
- `/?cart=add` - Añadir producto (POST)
- `/?cart=remove` - Eliminar del carrito (POST)
- `/?cart=clear` - Vaciar carrito

### Órdenes
- `/?order=checkout` - Procesar pedido (POST)
- `/?order=success&id=N` - Confirmación

### Usuarios (Existentes)
- `/?register` - Crear usuario
- `/?login=form` - Formulario login
- `/?login=do` - Procesar login (POST)
- `/?logout` - Cerrar sesión
- `/?list=listar` - Listar usuarios
- `/?user=edit&id=N` - Editar usuario
- `/?user=update` - Guardar cambios (POST)
- `/?user=delete` - Eliminar usuario (POST)

## Validaciones Implementadas

### En Domain Layer (Entidades):
- ✓ Stock debe ser >= 0
- ✓ Cantidad solicitada no puede exceder stock disponible
- ✓ Estados válidos de orden (pending, paid, failed, canceled, shipped)
- ✓ Precio debe ser > 0

### En Application Layer (Use Cases):
- ✓ Carrito no vacío antes de checkout
- ✓ Producto debe existir
- ✓ Stock suficiente para todos los ítems

### En Infrastructure Layer (Controllers):
- ✓ Usuario debe estar logged in para checkout
- ✓ Campos requeridos en creación de producto
- ✓ Flash messages para errores

## Estado Actual (Iteración 1 - MVP)

### ✅ Completado
- Entidades de dominio (Product, Order, OrderItem)
- Interfaz de repositorios
- Adaptadores MySQL
- Casos de uso principales
- Controladores Web
- Vistas HTML para flujo de compra
- Seeds de 8 productos
- Integración con usuarios existentes

### ⏳ Pendiente (Iteraciones futuras)
- [ ] Pago real (Stripe/PayPal integration)
- [ ] Actualización de stock tras compra
- [ ] Historial de órdenes del usuario
- [ ] Búsqueda y filtrado de productos
- [ ] Imágenes de productos
- [ ] Carritos persistidos en BD
- [ ] Wishlist
- [ ] Reseñas y ratings
- [ ] Descuentos y cupones
- [ ] Notificaciones por email
- [ ] Panel admin completo
- [ ] Tests unitarios e integración
- [ ] API REST JSON
- [ ] Autenticación de dos factores

## Cómo Probar

### 1. Iniciar Docker
```bash
make up
```

### 2. Acceder a la app
```
http://localhost:8081/
```

### 3. Flujo de prueba manual:
a. Haz clic en "Catálogo" o abre `/?shop=catalog`
b. Selecciona un producto y haz clic en "Ver Detalles"
c. Ingresa cantidad y haz clic en "Añadir al Carrito"
d. Ve al carrito con el ícono 🛒
e. Haz clic en "Proceder al Pago"
f. Si no estás logged, serás redirigido a login
g. Tras login, intenta checkout nuevamente
h. Deberías ver confirmación de pedido

## Decisiones de Arquitectura

### 1. Carrito en Sesión (no persistido)
**Razón**: MVP simple. En producción usar tabla `carts` para recuperar compras abandonadas.

### 2. Pago Simulado (sin integración externa)
**Razón**: MVP. Agregar `PaymentGatewayInterface` + `StripeAdapter` cuando sea necesario.

### 3. Sin DTOs específicos
**Razón**: MVP usa arrays simples. Agregar Request/Response DTOs conforme la complejidad aumente.

### 4. Stock no decrementado automáticamente
**Razón**: Permite simular múltiples compras en dev. En producción: agregar Domain Event `OrderPlaced` → listener que decrementa stock.

### 5. Validación mínima
**Razón**: MVP. Próxima iteración: agregar `Validator` (Respect/Validation o similar) en use cases.

## Extensibilidad

### Para agregar eventos de dominio:
```php
// src/Domain/Event/DomainEvent.php
interface DomainEvent { }

class OrderPlaced implements DomainEvent {
    public function __construct(public Order $order) {}
}

// src/Application/EventDispatcher.php (simple)
class EventDispatcher {
    public function dispatch(DomainEvent $event) { /* ... */ }
}

// En CreateOrder use case:
$this->eventDispatcher->dispatch(new OrderPlaced($order));
```

### Para agregar API JSON:
```php
// src/Infrastructure/Framework/Http/Api/ProductApiController.php
class ProductApiController {
    public function list(): void {
        header('Content-Type: application/json');
        echo json_encode($this->listProducts->execute());
    }
}

// En index.php:
if (isset($_GET['api']) && $_GET['api'] === 'products') {
    $apiController->list();
}
```

### Para agregar transacciones:
```php
// src/Infrastructure/Persistence/Transaction.php
interface Transaction {
    public function begin(): void;
    public function commit(): void;
    public function rollback(): void;
}

// En CreateOrder use case:
$tx->begin();
try {
    $order = $this->orderRepository->save($order);
    $this->updateStockRepository->decreaseAll($cartItems);
    $tx->commit();
} catch (\Exception $e) {
    $tx->rollback();
    throw $e;
}
```

## Contacto / Dudas
Revisa `architecture.md` para más contexto sobre hexagonal.
