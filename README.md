# RD Laravel Starter Kit

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4e56a6?style=for-the-badge&logo=livewire&logoColor=white)
![Flux UI](https://img.shields.io/badge/Flux_UI-000000?style=for-the-badge&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

Un boilerplate rico en funciones, limpio y moderno para aplicaciones Laravel. Diseñado para ayudarte a comenzar tu próximo proyecto de software, SaaS o portal de clientes con una base sólida ya establecida de antemano.

## ✨ Características

Este kit de inicio viene preconfigurado con las siguientes funcionalidades principales:

- **Autenticación y Seguridad:** Desarrollado con Laravel Fortify. Incluye inicio de sesión, registro, restablecimiento de contraseñas y autenticación de dos factores (2FA).
- **Roles y Permisos:** Control de acceso basado en roles (RBAC) integrado usando `spatie/laravel-permission`. Administra fácilmente los accesos y capacidades de los usuarios.
- **Sistema de Clientes y Portal:** Una arquitectura dedicada para gestionar "Clientes" y "Solicitudes de Clientes", perfecto para CRMs o mesas de ayuda (helpdesks).
- **Componentes de UI Modernos:** Estilos hermosos, accesibles y responsivos manejados por **[Flux UI](https://fluxui.dev/)** (Basado en Tailwind CSS).
- **Gestión de Medios:** Preinstalado con `spatie/laravel-medialibrary` para el manejo de subida de archivos sin problemas.
- **Arquitectura TALL Stack:** Utiliza Tailwind CSS, Alpine.js, Laravel y Livewire (específicamente Livewire Volt) para componentes frontend reactivos.

## 🚀 Empezando

Sigue estos pasos para levantar el proyecto localmente y empezar a correrlo.

### Prerrequisitos

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / PostgreSQL / SQLite

### Instalación

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/richarddev7/rd-template.git tu-nombre-de-proyecto
   cd tu-nombre-de-proyecto
   ```

2. **Ejecuta el script de configuración:**
   Hemos incluido un script de configuración conveniente en `composer.json`. Solo ejecuta:
   ```bash
   composer setup
   ```
   *Este comando instalará las dependencias (composer y npm), copiará el archivo `.env`, generará la key de la aplicación y ejecutará las migraciones.*

3. **Configura el Entorno:**
   Actualiza las credenciales de tu base de datos en el archivo `.env` recién creado:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_tu_base_de_datos
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *Si estás utilizando SQLite, asegúrate de que exista `database/database.sqlite` y que esté configurado `DB_CONNECTION=sqlite`.*

4. **Llena la Base de Datos (Opcional pero recomendado):**
   Si deseas popular tu aplicación con roles por defecto, permisos y un usuario administrador.
   ```bash
   php artisan db:seed
   ```

5. **Inicia el Servidor de Desarrollo:**
   Puedes ejecutar el servidor, la escucha de colas (queue listeners) y la compilación de Vite simultáneamente utilizando nuestro script de desarrollo personalizado:
   ```bash
   composer dev
   ```

   Tu aplicación ahora debería estar accesible en `http://localhost:8000`.

## 🛠 Tecnologías (Tech Stack)

- **Framework:** [Laravel 12.x](https://laravel.com/)
- **Lógica Frontend:** [Livewire Volt](https://livewire.laravel.com/docs/volt)
- **Kit de UI:** [Flux UI](https://fluxui.dev/) & Tailwind CSS
- **Autenticación:** [Laravel Fortify](https://laravel.com/docs/11.x/fortify)
- **Autorización:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- **Gestión de Archivos:** [Spatie MediaLibrary](https://spatie.be/docs/laravel-medialibrary)

## 🎨 Directrices de UI

Nos adherimos estrictamente a la [Documentación de Flux UI](https://fluxui.dev/) como nuestra fuente principal y única para el diseño de interfaces. Al construir nuevos componentes o páginas, por favor usa la sintáxis y los tokens de diseño predefinidos en la instalación de Flux para mantener una apariencia (Look & Feel) consistente en toda la aplicación.

## 📄 Licencia

El framework Laravel es software de código abierto con licencia bajo la [licencia MIT](https://opensource.org/licenses/MIT). Este kit de inicio también se proporciona bajo la Licencia MIT.
