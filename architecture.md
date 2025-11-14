# Arquitectura Hexagonal

## Capa: Aplicación

### Notas

1. Contiene los casos de uso (acciones que el sistema puede realizar).
2. Orquesta el flujo entre Dominio e Infraestructura.
3. No tiene lógica del negocio (esa pertenece al Dominio).
4. Llama a los repositorios a través de interfaces (puertos).
5. Prepara la entrada y la salida (DTOs, comandos, respuestas).
6. No depende de frameworks ni de bases de datos.

### Organización dentro de Aplicación

#### Casos de Uso

Aquí van:

- Clases como `CreateUserHandler`, `ListUsersHandler`, `ProcessOrderHandler`.
- Son las encargadas de ejecutar una acción específica.

Coordinan:

- Entidades del dominio
- Repositorios
- Servicios
- Validaciones simples (no de negocio)

Son las clases que se ejecutan cuando el Framework recibe una petición.

---

## Capa: Infraestructura

### Notas

1. Aquí está el mundo exterior, es decir, los adaptadores.
2. Solo reciben la petición.
3. No contienen lógica del negocio.
4. Llaman al caso de uso correspondiente.

### Organización dentro de Infraestructura

#### Adaptador: Framework

Aquí van:

- Controladores HTTP  
- Rutas  
- Middlewares  
- Vistas (HTML, templates, Blade, Twig…)  
- Elementos propios del framework utilizado  

Todo lo que interactúa con el usuario o entra al sistema.

#### Adaptador: Persistence

Aquí van:

- Repositorios concretos
- Conexiones a bases de datos
- Modelos del ORM
- Mapeadores (dominio ↔ persistencia)

Todo lo que se comunica con la base de datos o con APIs externas.
