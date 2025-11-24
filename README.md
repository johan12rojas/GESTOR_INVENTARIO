# Sistema de Control de Inventarios

Sistema completo de gestión de inventario desarrollado con arquitectura MVC, backend en PHP y frontend en React.

## Estructura del Proyecto

```
GESTOR_INVENTARIO/
├── backend/                 # Backend PHP con patrón MVC
│   ├── api/                # Endpoints de la API REST
│   ├── config/             # Configuración (Base de datos)
│   ├── controllers/        # Controladores
│   ├── models/             # Modelos de datos
│   ├── utils/              # Utilidades (Response, AuditLogger)
│   └── .htaccess          # Configuración Apache
├── frontend/               # Frontend React
│   ├── src/
│   │   ├── components/    # Componentes React
│   │   ├── services/      # Servicios API
│   │   └── App.jsx        # Componente principal
│   └── public/            # Archivos públicos
└── inventario.sql         # Base de datos MySQL
```

## Requisitos

- XAMPP (PHP 8.0+ y MySQL/MariaDB)
- Node.js 18+ y npm
- Base de datos MySQL con nombre `inventario`

## Instalación

### 1. Base de Datos

1. Inicia XAMPP y asegúrate de que MySQL esté corriendo
2. Importa el archivo `inventario.sql` en phpMyAdmin o ejecuta:
   ```bash
   mysql -u root -p inventario < inventario.sql
   ```

### 2. Backend (PHP)

1. El backend está listo para usar. Asegúrate de que:

   - XAMPP esté corriendo
   - El proyecto esté en `C:\xampp\htdocs\GESTOR_INVENTARIO\`
   - O ajusta la ruta en `backend/config/database.php` si es necesario

2. Verifica la configuración de la base de datos en `backend/config/database.php`:
   ```php
   private $host = 'localhost';
   private $db_name = 'inventario';
   private $username = 'root';
   private $password = '';
   ```

### 3. Frontend (React)

1. Instala las dependencias:

   ```bash
   cd frontend
   npm install
   ```

2. Inicia el servidor de desarrollo:

   ```bash
   npm start
   ```

3. El frontend se abrirá en `http://localhost:3000`

## Uso

### Credenciales de Prueba

El sistema incluye usuarios de prueba:

**Administrador:**

- Email: `admin@admin.com`
- Contraseña: `123456`

**Usuario Gestor de Inventario:**

- Email: `sebas@gmail.com`
- Contraseña: `123456`

### Acceso al Sistema

1. **Inicio de Sesión:**

   - Ve a `http://localhost:3000/login`
   - Ingresa las credenciales de prueba
   - Accede al dashboard principal

2. **Registro de Nuevo Usuario:**
   - Ve a `http://localhost:3000/register`
   - Completa el formulario con nombre, email y contraseña
   - Crea tu cuenta

## Funcionalidades Implementadas

### 📦 Gestión de Productos

- CRUD completo de productos
- Categorización y clasificación
- Control de stock mínimo
- Alertas automáticas de stock bajo
- Importación/Exportación de datos

### 🏢 Gestión de Proveedores

- CRUD de proveedores
- Contadores dinámicos (productos suministrados, pedidos)
- Soft delete para integridad referencial

### 📋 Sistema de Pedidos

- Creación de pedidos con múltiples productos
- Auto-generación de números de pedido
- Estados: Pendiente, Enviado, En Tránsito, Entregado, Cancelado
- Sincronización automática de stock al entregar
- Indicadores de plazo de entrega

### 📊 Movimientos de Inventario

- Registro de entradas y salidas
- Historial completo de movimientos
- Motivos y observaciones

### 🔔 Sistema de Alertas

- Alertas automáticas de stock bajo
- Alertas de pedidos próximos a vencer
- Notificaciones en tiempo real

### 📈 Reportes y Dashboards

- Dashboard con métricas clave
- Gráficos de costos y ventas
- Distribución por proveedores
- Productos más vendidos (rotación)
- Filtros por período (Semana, Mes, Trimestre, Año)

### 👤 Gestión de Usuarios

- Sistema de roles y permisos
- Perfil de usuario con avatar
- Auditoría de acciones

### 🔍 Auditoría

- Log completo de acciones
- Trazabilidad de cambios
- Exportación de logs

## Endpoints de la API

**Base URL:** `http://localhost/GESTOR_INVENTARIO/backend/api`

### Autenticación

- `POST /api/auth/register` - Registrar nuevo usuario
- `POST /api/auth/login` - Iniciar sesión
- `POST /api/auth/logout` - Cerrar sesión
- `GET /api/auth/check` - Verificar sesión actual

### Productos

- `GET /api/products` - Listar productos
- `POST /api/products` - Crear producto
- `PUT /api/products/{id}` - Actualizar producto
- `DELETE /api/products/{id}` - Eliminar producto (soft delete)
- `GET /api/products/export` - Exportar productos
- `POST /api/products/import` - Importar productos

### Proveedores

- `GET /api/suppliers` - Listar proveedores
- `POST /api/suppliers` - Crear proveedor
- `PUT /api/suppliers/{id}` - Actualizar proveedor
- `DELETE /api/suppliers/{id}` - Eliminar proveedor

### Pedidos

- `GET /api/orders` - Listar pedidos
- `POST /api/orders` - Crear pedido
- `PATCH /api/orders/{id}/status` - Actualizar estado
- `DELETE /api/orders/{id}` - Eliminar pedido

### Movimientos

- `GET /api/movements` - Listar movimientos
- `POST /api/movements` - Registrar movimiento
- `DELETE /api/movements/{id}` - Eliminar movimiento

### Alertas

- `GET /api/alerts` - Listar alertas
- `PATCH /api/alerts/{id}/read` - Marcar como leída
- `DELETE /api/alerts/{id}` - Eliminar alerta

### Usuarios

- `GET /api/users` - Listar usuarios
- `POST /api/users` - Crear usuario
- `PUT /api/users/{id}` - Actualizar usuario
- `DELETE /api/users/{id}` - Eliminar usuario

### Auditoría

- `GET /api/audits` - Listar logs de auditoría
- `GET /api/audits/export` - Exportar logs

## Tecnologías Utilizadas

### Backend

- **PHP 8.0+** - Lenguaje de programación
- **MySQL 8.0** - Base de datos relacional
- **Arquitectura MVC** - Patrón de diseño
- **PDO** - Acceso a base de datos
- **Transacciones ACID** - Integridad de datos

### Frontend

- **React 18** - Biblioteca de UI
- **React Router DOM** - Enrutamiento SPA
- **Hooks** - Gestión de estado
- **Fetch API** - Comunicación con backend
- **CSS Modules** - Estilos modulares

### Infraestructura

- **Apache 2.4** - Servidor web
- **Node.js 18+** - Entorno de ejecución
- **npm** - Gestor de paquetes

## Características Técnicas

- **Autenticación:** Sesiones PHP con tokens
- **Seguridad:** Hashing de contraseñas con bcrypt
- **Validación:** Frontend y backend
- **CORS:** Configurado para desarrollo local
- **Soft Deletes:** Preservación de integridad referencial
- **Responsive Design:** Compatible con móviles y tablets
- **Optimización:** Consultas SQL optimizadas con subconsultas

## Notas de Desarrollo

- El backend utiliza sesiones PHP para la autenticación
- Las contraseñas se almacenan con hash usando `password_hash()`
- El frontend se comunica con el backend mediante fetch API
- CORS está configurado para permitir peticiones desde `localhost:3000`
- Los reportes calculan métricas en tiempo real desde la base de datos
- Sistema de alertas automático basado en reglas de negocio

## Soporte

Para reportar problemas o sugerencias, contacta al equipo de desarrollo.
