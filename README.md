# (Trabajo Práctico Final – Programación Web 2)


# Info

Se asume...

-phpmyadmin  http://localhost:8080/phpmyadmin/ 

-Apache control xampp 

-Base de datos llamada 'nombre de la base' ya creada.

-Editor de texto cualquiera.

-Herramientas de gestión de proyectos: Trello https://trello.com/b/g63JsRvS/consorcio
Tecnicatura en Desarrollo Web - Universidad Nacional de La Matanza (2018)

Grupo de Trabajo:
  + Erika Rodriguez (https://github.com/erikaevelyn)
  + Federico Bevacqua (https://github.com/FedericoBevacqua)
  + Angela Mansilla (https://github.com/DanielaMansilla)

Profesores:
+ Rusticcini Alejandro
+ Daranno Facundo
+ Jonatan Uran

# Descripción general del sistema:
-----------------------------------------------

Se nos solicita realizar una aplicación para la Administración de Consorcios.

Un consorcio consiste en la asociación de individuos (puede incluir también empresas) patrocinado por
una empresa administradora, con el fin de proporcionar a sus miembros la administración y adquisición
de bienes a través de la autofinanciación.

Nuestro cliente será la empresa administradora de consorcios. Una empresa Administradora de
Consorcios generalmente administra más de un Consorcio.

Esta aplicación contará con distintos módulos que nos permitirán la correcta administración de un
consorcio. La tarea fundamental de la aplicación que desarrollaremos es administrar los recursos
financieros de todos los individuos que confían en la empresa administradora.

Para esto contaremos con propietarios que realizan pagos de expensas, los cuales deben quedar
registrados en nuestra aplicación.

El valor de las expensas está descripto en el Reglamento de copropiedad, básicamente lo que éste dice
es que los gastos se prorratean de acuerdo al porcentaje de participación que tiene cada unidad
(departamentos) sobre el total del inmueble (edificio).

También deben registrarse los gastos mensuales del Consorcio (pintura, electricidad, compra de algún
elemento)-

Asimismo, debemos tener en cuenta la realización de un módulo de reclamos.

El cliente desea que trabajemos sobre servidores Linux con lenguaje de programación PHP por parte del
servidor y bases de datos MySql para almacenar los datos (las claves de los usuarios deben ser
almacenadas en SHA1 como mínimo), ya que confía en estas tecnologías.

Respecto al código, como el mismo, por contrato, le pertenece, desea que el desarrollo del mismo se
realice sobre un sistema de versionado GIT, donde pueda ver el avance del mismo, y participar en él con
nosotros.

# Detalles de la aplicación:
------------------------------
Debe contar con los siguientes módulos, debe contemplar por cada uno de ellos un ABM:

Usuarios: debe permitir la generación de usuarios que utilizarán el sistema. Debe persistir para cada uno
de ellos: nombre de usuario, contraseña, dni, correo electrónico, y un rol asociado.

Roles: cada usuario debe tener asignado un rol, deben existir al menos dos, un administrador y un
operador. El administrador puede interactuar con absolutamente todos los módulos del sistema. El
operador no puede dar de alta nuevos usuarios ni ver reportes.
Se debe tener en cuenta que, si bien inicialmente serán dos tipos de usuarios, a futuro la cantidad de
roles crecerá y debe ser escalable en el sistema.

El administrador puede dar de alta/baja nuevos usuarios y roles.
La aplicación contará con una pantalla de login, y todos los usuarios tendrán un estado activo/inactivo.

Los operadores podrán ser registrados por un administrador o bien a través de un enlace público (de
hacerlo de esta manera deberán ser validados por un administrador).

Consorcios: debe contemplar la administración de distintos consorcios persistiendo para cada uno de
ellos: nombre, CUIT, dirección, código postal, teléfono y correo electrónico. El Administrador en cualquier
momento podrá observar mediante una aplicación de mapas, en forma gráfica, la ubicación de cada
consorcio del sistema, con su consiguiente identificación.

Propietarios: consorcio, consejo, nombre, dni, CUIT, piso, departamento, teléfono, correo electrónico,
porcentaje de participación de su unidad (departamento).

Cobranzas: las mismas pueden ser parciales, esto es, una vez determinado el monto a pagar para un
propietario en particular, éste puede cancelar su deuda en varios pagos. Las cobranzas e pueden
realizar mediante transferencia bancaria, efectivo o mediante la API de MercadoPagos. Debe quedar
registrado el medio que se utilizó.

Reclamos: cada propietario puede hacer reclamos al consorcio. Estos reclamos pueden tener al menos
dos estados: activo y resuelto.

Pagos: en este módulo se contemplan los gastos de la administración del consorcio. Debe permitir
discriminar por qué motivo se hizo un pago, a quien se lo hizo y la fecha y hora.
Asimismo, esto debe actualizar el gasto total mensual del consorcio que luego será facturado a cada
propietario
El total general se calcula sumando todos los gastos que tiene el consorcio más un 20%. Y lo que se le
cobrará a cada propietario dependerá del porcentaje de participación que posee su departamento.

Mensualmente se le enviara a cada integrante de cada consorcio, una minuta detallada de la liquidación
mensual integrada por los gastos realizados por la administración y los pagos de cada participante en el
consorcio, con un resumen final indicando el estado de la liquidación (ganancia / perdida). En la
liquidación debe constar si algún propietario en particular posee deuda y a cuánto asciende.

Estadísticas: deberá informar por cada consorcio, cantidad de unidades, cobranzas realizadas / faltantes,
reclamos abiertos/cerrados.

# Detalles técnicos:
--------------------
° Se utilizará una base de datos MySql para almacenar los datos.

° El sistema deberá estar implementado con Lenguaje de programación PHP desde el lado del
Servidor

° La interfaz deberá ser construida mediante un framework css a elegir entre Bootstrap, W3CSS o
Materialize

°  Se deberá Almacenar el versionado del producto en un repositorio GIT

°  Las claves de usuario deben almacenarse con encriptación SHA1 como mínimo en la base de
datos
° El sistema calculara el digito verificador de los CUIL/CUIT ingresados de manera de evitar errores
