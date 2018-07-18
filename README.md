# (Trabajo Práctico Final – Programación Web / Mobile 2)

# Info

- phpMyAdmin http://localhost/phpmyadmin/

- Apache y MySQL Control Xampp

- Nombre de la base de datos: consorcio

- Script que completa la BD consorcio: scriptDBconInserts.sql

- Editor de texto a utilizar: cualquiera.

- Herramientas de gestión de proyectos: Trello https://trello.com/b/g63JsRvS/consorcio

- En caso de tener un puerto distinto al por defecto localhost. Se debera modificar el archivo pagarExpensa.php 
y cambiar la ruta agregandole el puerto en el array de mercado pago, en "success", "failure" y "pending".

# Tecnicatura en Desarrollo Web / Mobile - Universidad Nacional de La Matanza (2018)

## Grupo de Trabajo:
  * Federico Bevacqua (https://github.com/FedericoBevacqua)

  * Erika Rodriguez (https://github.com/erikaevelyn)

  * Angela Mansilla (https://github.com/DanielaMansilla)

## Profesores:
 * Rusticcini Alejandro

 * Daranno Facundo

 * Jonatan Uran

# Descripción general del sistema:

Se nos solicita realizar una aplicación para la Administración de Consorcios.

Un consorcio consiste en la asociación de individuos (puede incluir también empresas) patrocinado por una empresa administradora, con el fin de proporcionar a sus miembros la administración y adquisición de bienes a través de la autofinanciación.

Nuestro cliente será la empresa administradora de consorcios. Una empresa Administradora de Consorcios generalmente administra más de un Consorcio.

Esta aplicación contará con distintos módulos que nos permitirán la correcta administración de un consorcio. La tarea fundamental de la aplicación que desarrollaremos es administrar los recursos financieros de todos los individuos que confían en la empresa administradora.

Para esto contaremos con propietarios que realizan pagos de expensas, los cuales deben quedar registrados en nuestra aplicación.

El valor de las expensas está descripto en el Reglamento de copropiedad, básicamente lo que éste dice es que los gastos se prorratean de acuerdo al porcentaje de participación que tiene cada unidad (departamentos) sobre el total del inmueble (edificio).

También deben registrarse los gastos mensuales del Consorcio (pintura, electricidad, compra de algún elemento)

Asimismo, debemos tener en cuenta la realización de un módulo de reclamos.

El cliente desea que trabajemos sobre servidores Linux con lenguaje de programación PHP por parte del servidor y bases de datos MySql para almacenar los datos (las claves de los usuarios deben ser almacenadas en SHA1 como mínimo), ya que confía en estas tecnologías.

Respecto al código, como el mismo, por contrato, le pertenece, desea que el desarrollo del mismo se realice sobre un sistema de versionado GIT, donde pueda ver el avance del mismo, y participar en él con nosotros.


# Detalles de la aplicación:

Debe contar con los siguientes módulos, debe contemplar por cada uno de ellos un ABM:

Usuarios: debe permitir la generación de usuarios que utilizarán el sistema. Debe persistir para cada uno de ellos: nombre de usuario, contraseña, dni, correo electrónico, y un rol asociado.

Roles: cada usuario debe tener asignado un rol, deben existir al menos dos, un administrador y un operador. El administrador puede interactuar con absolutamente todos los módulos del sistema. El operador no puede dar de alta nuevos usuarios ni ver reportes.

El administrador puede dar de alta/baja nuevos usuarios y asignarles roles.

La aplicación contará con una pantalla de login, y todos los usuarios tendrán un estado activo/inactivo.

Los operadores podrán ser registrados por un administrador o bien a través de un enlace público (de hacerlo de esta manera deberán ser validados por un administrador).

Consorcios: debe contemplar la administración de distintos consorcios persistiendo para cada uno de ellos: nombre, CUIT, dirección, código postal, teléfono y correo electrónico. El Administrador en cualquier momento podrá observar mediante una aplicación de mapas, en forma gráfica, la ubicación de cada consorcio del sistema, con su consiguiente identificación.

Propietarios: consorcio, nombre, dni, CUIT, piso, departamento, teléfono, correo electrónico, porcentaje de participación de su unidad (departamento).

Cobranzas: Las cobranzas se pueden realizar mediante transferencia bancaria, efectivo o mediante la API de MercadoPagos. Debe quedar registrado el medio que se utilizó.

Reclamos: cada propietario puede hacer reclamos al consorcio. Estos reclamos pueden tener al menos dos estados: activo y resuelto.

Pagos: en este módulo se contemplan los gastos de la administración del consorcio. Debe permitir discriminar por qué motivo se hizo un pago, a quien se lo hizo y la fecha y hora.

Asimismo, esto debe actualizar el gasto total mensual del consorcio que luego será facturado a cada propietario.

El total general se calcula sumando todos los gastos que tiene el consorcio más un 20%. Y lo que se le cobrará a cada propietario dependerá del porcentaje de participación que posee su departamento.

Mensualmente se le enviara a cada integrante de cada consorcio, una minuta detallada de la liquidación mensual integrada por los gastos realizados por la administración y los pagos de cada participante en el consorcio, con un resumen final indicando el estado de la liquidación (ganancia / perdida). En la liquidación debe constar si algún propietario en particular posee deuda y a cuánto asciende.

Estadísticas: deberá informar por cada consorcio, cantidad de unidades, cobranzas realizadas / faltantes, reclamos abiertos/cerrados.


# Detalles técnicos:

* Se utilizará una base de datos MySql para almacenar los datos.

* El sistema deberá estar implementado con Lenguaje de programación PHP desde el lado del Servidor.

* La interfaz deberá ser construida mediante un framework css a elegir entre Bootstrap, W3CSS o Materialize.

* Se deberá Almacenar el versionado del producto en un repositorio GIT.

* Las claves de usuario deben almacenarse con encriptación SHA1 como mínimo en la base de datos.

* El sistema calculara el digito verificador de los CUIL/CUIT ingresados de manera de evitar errores.


# Instrucciones para ejecutar la aplicación:

* Ingresar al directorio donde queres clonar el repositorio. Recomendamos clonarlo en C:\xampp\htdocs .

* Dentro de ese directorio clonar el repositorio consorcio de github https://github.com/DanielaMansilla/consorcio.git .

* Iniciar Apache y MySQL desde XAMPP Control Panel.

* Ingresar a phpMyAdmin (http://localhost/phpmyadmin/) y crear una base de datos llamada: consorcio. Una vez creada, importar en ella el archivo scriptDBconInserts.sql ubicado dentro del repositorio clonado (C:\xampp\htdocs\consorcio).

* Ingresar a http://localhost/consorcio/app/view/ y comenzar a utilizar la aplicación. Podes ingresar los datos brindados debajo (ya se encuentran cargados con los permisos correspondientes).


# Usuarios a utilizar en la aplicación:

## Admin
- E-mail: admin@hotmail.com
- Contraseña: 123456


## Operador
- E-mail: operador@hotmail.com
- Contraseña: 123456

## Propietario 1
- E-mail: propietario@hotmail.com
- Contraseña: 123456

## Propietario 2
- E-mail: propietario2@hotmail.com
- Contraseña: 123456

# MercadoPago:

Iniciar sesión con el siguiente usuario de prueba en MercadoPago.
Luego, al momento de hacer un pago, ingresar alguna de las tarjetas de crédito de prueba que se encuentran más abajo.
Y no olvidarse de ingresar en donde dice Nombre y Apellido en los datos de la tarjeta el valor: APRO

## Usuario de Prueba Comprador: 
- usuario: test_user_48440768@testuser.com
- contraseña: qatest1408

## Usuario de Prueba Vendedor: 
- usuario: test_user_72073954@testuser.com
- contraseña: qatest7878

- Client_id:	7466445635971939
- Client_secret:	b2T9AcENUezVW34XoYyOWe4mO1Ow4M32

## Tarjetas de Crédito de Prueba: (Argentina)

- Visa: 4509 9535 6623 3704
- MasterCard: 5031 7557 3453 0604
- American Express: 3711 803032 57522

## Estados del Pago: (Poner en Nombre y Apellido)

- APRO : Payment approved.
- CONT : Pending payment.
- CALL : Payment declined, call to authorize.
- FUND : Payment declined due to insufficient funds.
- SECU : Payment declined by security code.
- EXPI : Payment declined by expiration date.
- FORM : Payment declined due to error in form.
- OTHE : General decline.

## Cuil y Cuit de Prueba:

  https://www.dateas.com/es/consulta_cuit_cuil?name=Gerardo+Romano&cuit=&tipo=fisicas-juridicas
  https://www.cuitonline.com/search.php?q=valido&f2[]=monotributo%3Ano_inscripto&pn=1&&f6[]=nacionalidad:argentina

# Diagrama de Base de Datos

![Diagrama](diagramaBD.png?raw=true "Diagrama")