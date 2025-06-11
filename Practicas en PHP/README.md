# 📚 Sistema de Biblioteca - Administración de Libros y Autores

Sistema completo de administración de biblioteca desarrollado con **Laravel 11** (API Backend) y **Vue 3 + Vuetify** (Frontend SPA).

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8.2+**
- **Laravel 11**
- **MySQL**
- **Composer**

### Frontend
- **Vue 3**
- **Vuetify 3**
- **Vue Router**
- **Pinia** (State Management)
- **Axios** (HTTP Client)

## 🏗️ Estructura del Proyecto

\`\`\`
biblioteca-sistema-admin/
├── backend/          # API Laravel
│   ├── app/
│   ├── database/
│   ├── routes/
│   └── ...
├── frontend/         # SPA Vue + Vuetify
│   ├── src/
│   ├── public/
│   └── ...
└── scripts/          # Scripts SQL
\`\`\`

## 📋 Funcionalidades

### ✍️ Gestión de Autores
- ✅ CRUD completo (Crear, Ver, Editar, Eliminar con soft delete)
- ✅ Campos: Nombre, Apellido, País, Fecha de registro, Cantidad de libros
- ✅ Los autores eliminados no aparecen en listas pero sí en detalles de libros
- ✅ Vista de detalles con información completa

### 📚 Gestión de Libros
- ✅ CRUD completo con validación de autores obligatorios
- ✅ Campos: Nombre, Fecha de publicación, Edición, Autores
- ✅ Selección múltiple de autores
- ✅ Vista de detalles mostrando autores (incluso eliminados)

### 🔗 Relaciones
- ✅ Relación many-to-many entre autores y libros
- ✅ Un autor puede tener múltiples libros
- ✅ Un libro puede tener múltiples autores
- ✅ Un autor puede crearse sin libros
- ✅ Un libro DEBE tener al menos un autor

## 🚀 Instalación y Configuración

### 1. Backend (Laravel)

\`\`\`bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
\`\`\`

### 2. Configurar Base de Datos

Editar `.env`:
\`\`\`env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biblioteca_system
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
\`\`\`

### 3. Ejecutar Migraciones

\`\`\`bash
php artisan migrate
\`\`\`

### 4. Ejecutar Seeders (Opcional)

Ejecutar el script SQL desde el proyecto para datos de ejemplo.

### 5. Iniciar Backend

\`\`\`bash
php artisan serve
# Servidor en: http://localhost:8000
\`\`\`

### 6. Frontend (Vue + Vuetify)

\`\`\`bash
cd frontend
npm install
npm run dev
# Servidor en: http://localhost:3000
\`\`\`

## 🎯 Uso del Sistema

1. **Página Principal**: Acceso rápido a autores y libros
2. **Gestión de Autores**: 
   - Lista con acciones (Ver, Editar, Eliminar)
   - Formularios de creación y edición
   - Vista de detalles con libros asociados
3. **Gestión de Libros**:
   - Lista con acciones (Ver, Editar, Eliminar)
   - Formularios con selección múltiple de autores
   - Vista de detalles con autores (incluso eliminados)

## 🔍 Características Especiales

- **API REST**: Backend completamente separado del frontend
- **SPA**: Aplicación de página única con Vue Router
- **Soft Delete**: Los autores eliminados siguen apareciendo en libros
- **Validaciones**: Un libro debe tener al menos un autor
- **Material Design**: Interfaz moderna con Vuetify
- **Responsive**: Funciona en dispositivos móviles y desktop
- **Notificaciones**: Sistema de mensajes de éxito y error

## 📡 Endpoints API

### Autores
- `GET /api/authors` - Listar autores
- `GET /api/authors/{id}` - Ver autor
- `POST /api/authors` - Crear autor
- `PUT /api/authors/{id}` - Actualizar autor
- `DELETE /api/authors/{id}` - Eliminar autor (soft delete)

### Libros
- `GET /api/books` - Listar libros
- `GET /api/books/{id}` - Ver libro
- `POST /api/books` - Crear libro
- `PUT /api/books/{id}` - Actualizar libro
- `DELETE /api/books/{id}` - Eliminar libro
- `GET /api/books-authors` - Autores para selección

## 🎨 Interfaz de Usuario

- **Vuetify Material Design**: Componentes modernos y consistentes
- **Tablas de datos**: Con ordenamiento y acciones
- **Formularios**: Con validación en tiempo real
- **Navegación**: Intuitiva entre secciones
- **Confirmaciones**: Para acciones destructivas
- **Notificaciones**: Feedback visual para el usuario

El sistema está completamente funcional y listo para usar, cumpliendo con todos los requerimientos técnicos especificados usando únicamente las tecnologías permitidas.
