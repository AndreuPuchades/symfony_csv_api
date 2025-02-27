# 🚀 Symfony CSV Importer API

Este proyecto es un microservicio en Symfony diseñado para cargar grandes volúmenes de datos de suscriptores desde un archivo CSV y consultarlos mediante una API REST.

---

## 📍 **Objetivos del Proyecto**

✔️ Carga eficiente de archivos CSV con cientos de miles de registros.  
✔️ Optimización de la inserción en base de datos para evitar bloqueos y mejorar la velocidad.  
✔️ API REST para consultar y filtrar suscriptores almacenados.  
✔️ Comparación de métodos de inserción de CSV en la base de datos.

---

## ⚙️ **Tecnologías Utilizadas**

- **Framework**: Symfony 6.x
- **Base de Datos**: MySQL
- **ORM**: Doctrine
- **Librerías**: `league/csv` para el procesamiento eficiente de CSV.
- **Herramientas**: Docker para contenedores, Postman para pruebas de API.

---

## 🛠 **Instalación y Configuración**

### 🔹 **Requisitos Previos**

🔹 PHP 8.x  
🔹 Composer  
🔹 Docker y Docker Compose  
🔹 Symfony CLI

---

### 🔹 **Clonar el Repositorio**

```bash
git clone https://github.com/tu-usuario/symfony-csv-api.git
cd symfony-csv-api
```

---

### 🔹 **Instalar Dependencias**

```bash
composer install
```

---

### 🔹 **Configurar Variables de Entorno**

Edita el archivo `.env` para configurar la conexión a la base de datos:

```dotenv
DATABASE_URL="mysql://root:root@127.0.0.1:3306/symfony_csv_api"
```

---

### 🔹 **Levantar la Base de Datos con Docker**

Si usas Docker para manejar la base de datos:

```bash
docker compose up -d
```

---

### 🔹 **Ejecutar Migraciones de Base de Datos**

```bash
php bin/console doctrine:migrations:migrate
```

---

### 🔹 **Arrancar el Servidor de Symfony**

Puedes iniciar el servidor con el siguiente comando:

```bash
symfony server:start
```

Si prefieres usar PHP directamente:

---

## 📂 **Carga de CSV y Pruebas de Rendimiento**

### 🔹 Método 1: Inserción Directa

**Comando**:

```bash
php bin/console app:process-csv subscribers.csv
```

**Descripción**:  
🔹 Usa Doctrine para persistir cada registro.  
🔹 Optimización con lotes de 500 registros para mejorar la eficiencia.  
🔹 Tiempo de carga: ⚡ **≈ 64 segundos por 100,000 registros**.

---

### 🔹 Método 2: Inserción con ninguna optimización

**Comando**:

```bash
php bin/console app:process-csv-fast subscribers.csv
```

**Descripción**:  
🔹 Inserta múltiples registros en una única consulta SQL (`INSERT INTO ... VALUES (...)`).  
🔹 Optimización con lotes de 500 registros para mejorar la eficiencia.  
🔹 Tiempo de carga: ⚡ **≈ 61 segundos por 100,000 registros**.


---

## 🌐 **Consulta de Datos vía API**

### 📌 **Obtener Suscriptores con Filtros**

**Endpoint**:

```http
GET /api/subscribers?nombre=Juan&edad=30
```

**Ejemplo de Respuesta**:

```json
[
  {
    "id": 1,
    "nombre": "Juan Pérez",
    "email": "juan@example.com",
    "edad": 30,
    "direccion": "Calle Mayor 10, Madrid"
  }
]
```

---

## 🚀 **Optimización del Código**

✔️ **Uso de Batching**: Se agrupan inserciones en lotes de 500 registros.  
✔️ **Flush y Clear en Doctrine**: Evita consumo excesivo de memoria.  
✔️ **Uso de Transacciones**: Asegura atomicidad en la inserción.  

---

## 🐳 **Ejecución con Docker**

1️⃣ **Construir la imagen**:

```bash
docker-compose build
```

2️⃣ **Levantar los contenedores**:

```bash
docker compose up -d
```

3️⃣ **Ejecutar la carga de CSV en Docker**:

```bash
docker-compose exec php php bin/console app:process-csv subscribers.csv
```

4️⃣ **Acceder a Symfony desde el contenedor**:

```bash
docker-compose exec php symfony server:start
```

---

## 👨‍💻 **Contacto y Contribución**

📧 **Email**: puchadesandreupascual@gmail.com  
🔗 **Repositorio**: [GitHub](https://github.com/tu-usuario/symfony-csv-api)
