<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Deluxe Store: preparación local

El proyecto utiliza Laravel 12 y MySQL Server. No se debe crear una base SQLite.

Configura localmente las variables `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`,
`DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` en el entorno local. No incluyas
credenciales en el repositorio ni compartas el archivo `.env`.

Requisitos: PHP 8.2 o superior, Composer, MySQL Server y Node.js/npm para los
recursos frontend. Las dependencias y el build no se ejecutaron durante la
reorganización.

Vite utiliza los CSS y JavaScript originales de `assets/` como entradas, sin
modificarlos. Las imágenes para Blade se sirven desde
`public/assets/images/store/`; los HTML estáticos mantienen sus rutas a
`assets/Imagenes/`. Ejecuta `npm run build` únicamente cuando las dependencias
estén instaladas y se autorice preparar el build.

No ejecutes el script `composer run setup` durante esta fase: instala
dependencias y ejecuta migraciones. Las migraciones de dominio y las relaciones
de base de datos siguen pendientes de definición por el equipo. No se ejecutan
migraciones destructivas.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


## Módulo de autenticación

El sistema de autenticación de Deluxe Store permite registrar
usuarios, iniciar y cerrar sesión y gestionar perfiles.

### Roles del sistema

- ADMINISTRADOR: acceso a las funciones administrativas.
- CLIENTE: consulta de productos y realización de pedidos.
- EMPLEADO: gestión de operaciones de la tienda.

### Estructura de usuarios

- usuarios: almacena la información de las cuentas.
- roles: almacena los roles disponibles.
- usuario_rol: relaciona usuarios y roles.

### Controladores

- RegisterController: registro de usuarios.
- LoginController: inicio y cierre de sesión.
- ProfileController: consulta y actualización del perfil.

### Seguridad

- Las contraseñas se almacenan con hash.
- Las rutas privadas requieren autenticación.
- Las rutas administrativas requieren el rol ADMINISTRADOR.
- Los usuarios nuevos reciben el rol CLIENTE.

### Rutas principales

- /registro
- /login
- /perfil
- /admin/inicio
- /logout

