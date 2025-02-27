# MyNetflix

## M12 Síntesi - Activitat 9

### Objetivo
Crear un sitio web de una plataforma de vídeo por streaming con:

- **Parte pública**: Muestra los contenidos más destacados de la plataforma.
- **Entorno privado**: Gestión del catálogo y estadísticas de uso para administradores.
- **Interacción del usuario**: Los usuarios logueados podrán dar "likes" a los contenidos, buscar y filtrar películas.

---

## Estructura del Proyecto

### 1. Parte Pública
- **TOP 5** películas más populares (una única fila).
- **Catálogo** de películas en formato grid, ordenado por popularidad.
- **Login** para acceder al entorno privado.
- **Registro** de nuevos usuarios (requiere validación del administrador).

### 2. Parte Privada

#### 2.1. Administrador
- **Usuarios**:
  - Validar nuevas solicitudes de registro.
  - Activar o desactivar usuarios registrados.
- **Películas**:
  - Visualizar catálogo en una tabla ordenable (nombre o número de likes).
  - Agregar, eliminar y modificar películas.
  - Buscador rápido de películas.

#### 2.2. Cliente
- **Interacción con películas**:
  - Dar o quitar "like" a una película.
  - Filtrar entre películas con "like" y sin "like".
  - Búsqueda avanzada con múltiples filtros.

---

## Requisitos Técnicos
- **Diseño Responsive**: Mobile First (prototipo adaptable a múltiples dispositivos).
- **Base de Datos**: Gestión de usuarios y películas.
- **Conexión Segura**: PDO (escape de información, Statements, BindParams...).
- **Control de Transacciones**: Eliminación de películas y gestión de "likes".
- **Uso de AJAX**:
  - Creación de nuevos usuarios.
  - Filtros avanzados en la búsqueda de películas.
  - Gestión de "likes" en tiempo real.
- **Subida de Archivos**: Posters (carátulas) almacenados en el servidor.
- **Repositorio GitHub**:
  - Proyecto estructurado con README, roadmap, issues y uso adecuado de ramas.

---

## Evaluación de la Actividad

| Criterio | Puntuación |
|----------|------------|
| Diseño y prototipos responsivos (TOP 5 fijo) | 15% |
| Base de datos adecuada (usuarios y películas) | 10% |
| Conexión segura (escape de información, validaciones...) | 10% |
| Control de transacciones (eliminación de películas y "likes") | 10% |
| Uso de AJAX (usuarios, filtros, "likes") | 30% |
| Gestión de posters (subida de archivos al servidor) | 15% |
| Uso de GitHub (proyecto, README, roadmap, issues y ramas) | 10% |

---