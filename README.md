# Venta_De_Autopartes

Aplicaciones Web

Idea:
Página de compra de autopartes (repuestos de vehículos):
Un sitio donde los usuarios puedan comprar repuestos de autos usados o nuevos.

Frontend:

Cada repuesto en venta tendrá una foto ilustrativa donde se podrá apreciar el estado del producto.
Asímismo, se verá el nombre del repuesto con una breve descripción donde se especificará las características
técnicas: marca, modelo, año(s) del vehículo al que correspondes, código identificatorio, estado (bueno, malo, etc), color, si es izquierdo o derecho (por ejemplo, los espejos lo las puertas) ; precio del mismo en Pesos Argentinos.

El usuario podrá loggearse con un usuario y contraseña.

La página principal mostrará una secuencia de imágenes de productos, al azar, si el usuario no está loggeado;
recomendados si el usuario ya se ha loggeado y ha comprado y/o visualizado productos de la página.

Página web dividida en categorías de acuerdo a las necesidades del usuario:
*Listado de marcas (Ford, Chevrolet)
*Listado de Modelos (entiéndase modelo de la marca, ej Focus, Cruze)
*Listado de años
*Autoparte (repuesto) en cuestión

Backend:
GESTIONES

Gestión de usuarios:

- Sistema de registro e inicio de sesión para usuarios.
- Almacenar la información del usuario, como nombre, dirección de envío, historial de compras, etc.
- Manejar la autenticación y autorización de usuarios para acceder a ciertas funciones y datos

Gestión de productos:

- Crear un base de datos para almacenar la información de los repuestos (nombre, marca, modelo, etc)
- Implementación de un sistema de búsqueda y filtrado para que los usuarios puedan encontrar fácilmente los productos que están buscando.
- Permitir la carga de imágenes para cada prodcuto y almacenarlas adecuadamente en el servidor.

Gestión de Pedidos

- Implementar un sistema de carrito de comprasdonde los usuarios puedan agregar y proceder al pago.
- Registrar los pedidos realizados por los usuarios, incluyendo los productos comprados, la dirección de envío, el método de pago, etc.

Integración de pagos:

- Integrar un sistema de pagos en línea que permita a los usuarios realizar transacciones de forma segura.
- Aceptar múltiples métodos de pago, como tarjetas de crédito, transferencias bancarias, etc.

HERRAMIENTAS:
Gestor de Base de Datos:
PostgreSQL: Sistema de Gestón de Base de Datos relacional de código abierto y objeto relacional, conocido por su robustez, escalabilidad y conformidad con los estándares SQL.

Lenguaje de Programación:
PHP (Hyoertext Preprocessor) es un lenguaje de programación de código abierto que se utiliza para el desarrollo web y se puede integrar fácilmente con HTML.
PHP se utiliza para crear aplicaciones web dinámicas: aquellas quepueden interactuar con base de datos, enviar y recibir cookies, gestionar sesiones de usuarios, entre otras funciones. Es muy popular en la creación de sitios web dinámicos y aplicaciones web y sistemas operativos.

Framework:
Laravel, popular framework de desarrollo web de código abierto basado en PHP.
Algunas características:

1. Viene con un motor de plantillas llamado Blade que permite a los desarrolladores escribir plantillas HTML de una manera más limpia y eficiente.
2. Incluye un sistema de mapeo objeto-relacional llamado Eloquent que simplifica la interacción con la base de datos.
3. Incluye numerosas características de seguridad integradas, como protección contra ataques Cross-Site Request Foregry, filtrado de entrada y protección contra inyecciones SQL, que ayudan a proteger las aplicaciones web contra amenazas comunes.

Arquitectura:
Model View Controller, es un patrón de arquitectura de software ampliamente utilizado en el desarrollo de aplicaciones web y de software en general. Prorciona una estructura organizada para separar la lógica de negocio, la presentación de la infomración y la interacción del usuario en tres componentes distintos: Modelo, Vista, Controlador. Al utilizar el patrón MVC, los desarrolladores pueden trabajar de manera más modular, lo que facilita la reutilización de código y la colaboración en equipos de desarrollo.
