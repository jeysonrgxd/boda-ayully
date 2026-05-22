# Estándar de Desarrollo - Tema WordPress "Lizeth Alvam"

Este documento define el estándar de desarrollo utilizado en la creación del tema WordPress personalizado de Lizeth Alvam. Sigue este estándar para crear nuevas plantillas y mantener consistencia en futuros proyectos.

---

## 1. Estructura del Proyecto

```
tema-wordpress/
├── index.php                 # Plantilla por defecto
├── header.php                # Encabezado (usado en todas las páginas)
├── footer.php                # Pie de página (usado en todas las páginas)
├── functions.php             # Configuración y funciones del tema
├── style.css                 # Estilos principales
├── category.php              # Plantilla de categorías
├── single.php                # Plantilla de posts individuales
├── page-*.php                # Plantillas de páginas específicas
├── css/                      # Estilos separados por página/sección
│   ├── home.css
│   ├── blog.css
│   ├── contacto.css
│   ├── single.css
│   └── ...
├── js/                       # Scripts separados por funcionalidad
│   ├── main.js               # Script global
│   ├── blog.js               # Scripts específicos del blog
│   ├── contacto.js           # Scripts específicos de contacto
│   └── ...
├── assets/                   # Imágenes y recursos estáticos
└── screenshot.png            # Captura de pantalla del tema
```

**Notas importantes:**
- Cada página template tiene su propio archivo CSS en la carpeta `/css/`
- Cada página template tiene su propio archivo JS si requiere funcionalidad específica
- Los estilos base se cargan desde `style.css` en el `header.php`
- Los scripts globales (`main.js`) se cargan en todos los templates desde el `footer.php`

---

## 2. Header y Footer

### Estructura Header (`header.php`)

**Características:**
- Define HTML5 doctype y estructura básica
- Carga meta tags (charset, viewport, SEO, Open Graph)
- Incluye fuentes externas (Google Fonts: Montserrat)
- Carga librerías CDN (Bootstrap 5.3, Animate.css, Font Awesome 4.7)
- Define variables JavaScript globales accesibles en todos los scripts
- Implementa header sticky/fijo con hamburger menu para móviles

**Variables globales definidas en header:**
```javascript
let URL_BASE = `<?= get_site_url() ?>`          // URL base del sitio
const IP_CLIENT = `<?= $_SERVER['REMOTE_ADDR'] ?>`  // IP del cliente
const URL_DIRECTORY = `<?= get_template_directory_uri() ?>`  // Ruta del tema
```

**Componentes clave:**
- Logo con dos imágenes (una para scroll, otra para no-scroll)
- Navegación principal usando `wp_nav_menu()` con menu 'principal'
- Checkbox para abrir/cerrar menú móvil
- Classes dinámicas con `body_class()` y `language_attributes()`

### Estructura Footer (`footer.php`)

**Características:**
- Carga el script global `main.js` siempre
- Carga scripts específicos de página de forma condicional
- Integra redes sociales desde ACF (opciones globales)
- Usa `wp_footer()` hook para scripts de WordPress
- Implementa switch statement para mapear iconos de redes sociales

**Carga condicional de scripts:**
```php
<?php if (is_page("blog")) { ?>
    <script src="swiper.js"></script>
    <script src="js/blog.js"></script>
<?php } ?>

<?php if (is_page("contacto")) { ?>
    <script src="js/contacto.js"></script>
<?php } ?>
```

---

## 3. Functions.php - Configuración y Funciones

### Theme Support

```php
add_theme_support('post-thumbnails');  // Imágenes destacadas
add_theme_support('menus');             // Menús personalizados
add_theme_support('title-tag');         // Etiqueta <title> dinámica
add_filter('show_admin_bar', '__return_false');  // Oculta admin bar front-end
```

### ACF - Advanced Custom Fields

**Uso principal:**
- Página de Opciones Global para configuración global del tema
- Grupos de campos para secciones dinámicas (banner, servicios, etc.)
- Sintaxis de obtención: `get_field('nombre_campo')` o `get_field('nombre_campo', 'option')`

**Ejemplo de uso:**
```php
$banner_custom = get_field("banner_principal");
$banner_custom['imagen_banner']  // Acceder a subcampo
```

### API REST Personalizada

**Rutas registradas en `rest_api_init`:**

1. **POST `/wp-json/st/v1/registrar-contacto-home`**
   - Recibe: nombre, correo, telefono
   - Envía email a: lizethalva.m@gmail.com, hola@lizethalvam.com
   - Retorna: JSON con estado de envío

2. **POST `/wp-json/st/v1/registrar-contacto`**
   - Recibe: nombre, correo, asunto, mensaje
   - Envía email a: lizethalva.m@gmail.com, admin@lizethalvam.com
   - Retorna: JSON con estado de envío

**Validación:**
- Usa `isset()` para validar parámetros
- Usa `wp_mail()` para envío
- Retorna respuesta JSON

### Funciones Personalizadas

#### 1. `wpcodex_format_custom_excerpt($text)`
- Trunca el texto a 10 palabras
- Añade "[…]" al final
- Usada en vistas de blog para mostrar resúmenes

#### 2. `truncar_titulo($titulo)`
- Trunca títulos a máximo 8 palabras
- Añade "[...]" si excede el límite
- Aplicada a través del filtro `the_title`
- **Nota:** Se aplica globalmente a todos los títulos

#### 3. `paginated_category($query)`
- Configura 6 posts por página en categorías
- Hook: `pre_get_posts`
- Solo aplica en front-end

---

## 4. Plantillas de Página (Page Templates)

### Estructura General

Todas las plantillas siguen este patrón:

```php
<?php get_header(); ?>

<link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/nombre-pagina.css">

<?php
// Obtener datos de ACF
$datos = get_field("nombre_grupo");

// Queries personalizadas si se necesitan
$args = array('posts_per_page' => 10);
$custom_query = new WP_Query($args);
?>

<!-- Contenido HTML -->

<?php get_footer(); ?>
```

### Plantillas Específicas

#### `page-home.php` (Página Principal)
**Secciones:**
1. Banner principal (imagen + texto + CTA)
2. Quién soy (imagen + texto + enlace)
3. Servicios (ícono + título + descripción x N items)
4. Pilares y Método (4 pilares con ícono + título + texto)
5. Blog (últimas 4 publicaciones)
6. Instagram Feed (shortcode)
7. Zona de Contacto (info + enlace)

**Campos ACF usados:**
- `banner_prinicpal` → imagen_banner, titulo_banner, texto_button_call_to_action
- `quien_soy` → imagen_quien_soy, titulo_quien_soy, texto_quien_soy, button_call_to_action
- `servicios` → servicios_items (repetidor)
- `pilares_y_proceso` → pilares_y_procesos_items (repetidor)
- `contacto` → imagen_fondo, titulo, button_call_to_action
- `blog_entradas` → posts relacionadas

#### `page-blog.php`
**Secciones:**
1. Publicaciones populares (de ACF o categoría 'Populares')
2. Carrusel de últimas publicaciones (Swiper.js)
3. Filtrado por categorías (mediante data-slug)
4. Instagram Feed
5. Zona de Contacto

**Características:**
- Usa múltiples WP_Query para cada categoría
- Implementa Swiper para carrusel
- Categorías dinámicas desde WordPress
- Sistema de filtrado con clases CSS

#### `page-contacto.php`
**Secciones:**
1. Banner (imagen de fondo + texto)
2. Datos de contacto (teléfono, correo, ubicación)
3. Formulario de contacto
4. Redes sociales
5. Instagram Feed

**Características:**
- Usa SweetAlert2 para notificaciones
- Formulario con validación básica
- Integración con API REST personalizada

#### `page-servicios.php`
**Estructura:**
- Mismo patrón de header + contenido + footer
- Típicamente: banner + listado de servicios

#### `page-sobremi.php`
**Estructura:**
- Página de información personal
- Biografía y profesionalidad

#### `page-recursos-gratuitos.php`
**Estructura:**
- Página de recursos descargables
- Típicamente listado de recursos con ACF

#### `page-home2.php`
**Nota:** Variante alternativa de la página de inicio

#### `single.php` (Posts/Blog)
**Características:**
- Banner con imagen ACF personalizada
- Contenido del post (`the_content()`)
- Usa Bootstrap grid para layout
- Estilos en `css/single.css`

#### `category.php`
**Características:**
- Paginación de 6 posts por página (configurado en `functions.php`)
- Listado de posts por categoría
- Links a posts individuales

---

## 5. CSS - Estructura y Convenciones

### Nomenclatura de Clases (BEM Modificado)

Se utiliza una variación de BEM con namespace del tema:

```css
/* Bloque principal */
.lizethweb__nombre-bloque { }

/* Elemento dentro del bloque */
.lizethweb__nombre-bloque-elemento { }

/* Sub-elemento */
.lizethweb__nombre-bloque-sub-elemento { }

/* Modificador */
.lizethweb__nombre-bloque--modificador { }

/* Variantes específicas */
.lizethweb__elemento { }
```

### Estructura de Carpetas CSS

```
css/
├── home.css                 # Estilos página principal
├── blog.css                 # Estilos página blog
├── contacto.css             # Estilos página contacto
├── single.css               # Estilos posts individuales
├── category.css             # Estilos categorías
├── sobremi.css              # Estilos sobre mí
├── recursos-gratuitos.css   # Estilos recursos
└── [otros].css              # Otros estilos específicos
```

### Convenciones de Estilo

**Colores:**
- Usa variables CSS globales definidas en `style.css`
- Ej: `var(--primero)`, `var(--color-base)`

**Grid/Layout:**
- Bootstrap 5.3 para layouts responsivos
- Clases: `.container`, `.row`, `.col-*`, `.col-lg-*`, `.col-md-*`
- Clases personalizadas: `.contenedor` (wrapper personalizado)

**Animaciones:**
- Usa Animate.css para animaciones
- Clases: `.animate__animated`, `.animate__fadeIn`, `.animate__zoomIn`, etc.
- Delays: `.animate__delay-1s`, `.animate__delay-2s`

**Responsividad:**
- Mobile-first approach
- Breakpoints principales: 767px (tablet), 1050px (desktop)
- Media queries: `@media(max-width: 767px) { }`

---

## 6. JavaScript - Estructura y Funcionalidades

### Main.js - Funcionalidad Global

**Funcionalidades:**
1. **Menu Hamburger Móvil**
   - Checkboxes para toggle de menu
   - Transform translateX para animación
   - Llamada de función: `handleChangeInputCheckbox(event)`

2. **Header Sticky/Scroll**
   - Detecta scroll con `window.addEventListener("scroll")`
   - Añade clase `.scroll` al header cuando `scrollTop > 0`
   - Cambia estilos del header dinámicamente

3. **Formulario Principal (Home)**
   - Submit con `e.preventDefault()`
   - Envía a API REST personalizada
   - Deshabilita botón durante envío
   - Muestra feedback visual

**Patrón de Fetch API:**
```javascript
fetch(`${URL_BASE}/wp-json/st/v1/ruta`, {
    method: 'POST',
    body: formData
})
    .then(res => res.json())
    .then(resp => { /* manejo de respuesta */ })
```

### blog.js - Funcionalidad del Blog

**Características:**
- Inicializa Swiper para carrusel
- Filtrado de categorías (basado en data-slug)
- Event listeners para cambio de categoría

### contacto.js - Funcionalidad de Contacto

**Características:**
- Envía formulario a API REST personalizada
- Integración con SweetAlert2 para notificaciones
- Deshabilita botón durante envío
- Reset de formulario tras envío exitoso

**SweetAlert2 Uso:**
```javascript
Swal.fire({
    icon: 'success',
    title: 'Registro enviado',
    confirmButtonColor: '#164386',
    confirmButtonText: 'Ok'
})
```

### Carga Condicional de Scripts

En `footer.php`:
```php
<?php if (is_page("blog")) { ?>
    <!-- Carga scripts del blog -->
<?php } ?>
```

---

## 7. ACF - Configuración de Campos

### Opciones Globales

Configuradas en `functions.php`:
```php
if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}
```

**Campos de opciones principales:**
- `icono_web` - Logo/icono del sitio
- `icono_footer` - Icono en footer
- `redes_sociales` - Grupo repetidor con datos de redes
- `pie_de_pagina` - Texto del pie

### Grupos de Campos por Página

**Estructura típica:**
```php
$datos = get_field('nombre_grupo_acf');
// Acceso a subcampos
$datos['nombre_subcampo']
```

**Uso en Loop (have_rows):**
```php
<?php if (have_rows('nombre_grupo')) { ?>
    <?php while (have_rows('nombre_grupo')) { the_row(); ?>
        <!-- Acceso con get_sub_field() -->
        <?= get_sub_field('subcampo'); ?>
    <?php } ?>
<?php } ?>
```

**Uso de repetidores:**
```php
<?php
if (have_rows('repetidor_nombre')) {
    $items = get_field('repetidor_nombre');
    foreach ($items as $item) {
        $item['nombre_campo'];  // Acceso al campo
    }
}
?>
```

---

## 8. Convenciones de Código PHP

### Generales

- **Sintaxis corta de echo:** `<?= $variable ?>` (usada en todo el proyecto)
- **Condiciones:** Usar `if/else` o ternarios simples
- **Validación:** Siempre validar con `isset()` antes de usar variables
- **Seguridad:** Usar `wp_mail()` para envío de emails, `get_template_directory_uri()` para rutas

### Comentarios

- Comentarios en español
- Uso mínimo de comentarios, solo en lógica compleja
- Descriptivos y concisos

### Hooks de WordPress

**Used in this theme:**
- `add_theme_support()` - Activar características del tema
- `add_filter()` - Modificar comportamientos existentes
- `add_action()` - Ejecutar acciones en puntos específicos
- `rest_api_init` - Registrar rutas API REST personalizada
- `pre_get_posts` - Modificar queries de posts
- `the_title` - Filtro de títulos

---

## 9. Seguridad y Validación

### Validación de Entrada

```php
// Validar parámetros de request
$variable = isset($request['clave']) ? $request['clave'] : '';

// Sanitizar (si es necesario)
$clean_var = sanitize_text_field($variable);
```

### Escape de Salida

- `<?php echo esc_url($url); ?>` - URLs
- `<?php echo esc_html($text); ?>` - Texto HTML
- `<?php echo esc_attr($attr); ?>` - Atributos HTML

---

## 10. Recursos Externos Usados

### CDN/Librerías

1. **Google Fonts**
   - Montserrat: weights 300-900
   - URL: `fonts.googleapis.com`

2. **Bootstrap 5.3.0-alpha2**
   - Para grid y componentes responsive
   - CDN: `cdn.jsdelivr.net`

3. **Animate.css 4.1.1**
   - Animaciones CSS predefinidas
   - CDN: `cdnjs.cloudflare.com`

4. **Font Awesome 4.7**
   - Iconos
   - CDN: `cdnjs.cloudflare.com`

5. **Swiper 10**
   - Carruseles y sliders
   - Usado en página blog
   - CDN: `cdn.jsdelivr.net`

6. **SweetAlert2 11.7.3**
   - Modales y notificaciones mejoradas
   - Usado en página contacto
   - CDN: `cdn.jsdelivr.net`

7. **Instagram Feed Plugin**
   - Shortcode: `[instagram-feed feed=1]`
   - Mostrar feed de Instagram dinámicamente

---

## 11. Patrones de Desarrollo Clave

### Patrón 1: Query de Posts Personalizada

```php
$args = array(
    'posts_per_page' => 10,
    'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
    'order' => 'DESC',
    'category_name' => 'nombre-categoria'
);

$custom_query = new WP_Query($args);

if ($custom_query->have_posts()) {
    while ($custom_query->have_posts()) {
        $custom_query->the_post();
        // Contenido
    }
    wp_reset_postdata();
}
```

### Patrón 2: Obtención de Datos ACF

```php
// Campo simple
$valor = get_field('nombre_campo');

// Campo de opciones global
$valor = get_field('nombre_campo', 'option');

// Grupo de campos
$grupo = get_field('nombre_grupo');
$subcampo = $grupo['nombre_subcampo'];

// Repetidor
if (have_rows('repetidor')) {
    $items = get_field('repetidor');
    foreach ($items as $item) {
        // $item['subcampo']
    }
}
```

### Patrón 3: Formulario con API REST

```javascript
// En JS
const formData = new FormData(form);
fetch(`${URL_BASE}/wp-json/st/v1/ruta`, {
    method: 'POST',
    body: formData
})
    .then(res => res.json())
    .then(resp => { /* manejar */ });

// En PHP (functions.php)
function registrar_contacto($request) {
    $campo = isset($request['nombre_campo']) ? $request['nombre_campo'] : '';
    $sendmail = wp_mail($email, $subject, $msg);
    echo json_encode(["estatus" => $sendmail]);
}
```

### Patrón 4: Carga Condicional de Recursos

```php
<!-- En header o footer -->
<?php if (is_page("nombre-pagina")) { ?>
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/pagina.css">
<?php } ?>
```

---

## 12. Convenciones de Nombres

### Archivos

- Nombres en minúsculas con guiones: `page-home.php`, `blog.css`, `main.js`
- Prefijo `page-` para templates de página
- Archivos específicos en carpetas temáticas: `css/home.css`, `js/blog.js`

### Funciones

- Formato snake_case: `registrar_contacto()`, `paginated_category()`
- Prefijo descriptivo: `wpcodex_format_custom_excerpt()`, `truncar_titulo()`

### Variables

- Snake_case en PHP: `$custom_query`, `$banner_custom`
- CamelCase en JavaScript: `menuPrincipal`, `handleChangeInputCheckbox`
- UPPER_CASE para constantes: `URL_BASE`, `IP_CLIENT`

### Clases CSS

- Namespace `lizethweb__` o `bariloche__` (prefijo del tema)
- BEM modificado: `.lizethweb__elemento-nombre`
- Clases de estado: `.scroll`, `.show`, `.active`

---

## 13. Checklist para Nueva Plantilla

Al crear una nueva página template, seguir:

- [ ] Crear archivo `page-nombre.php`
- [ ] Llamar `get_header()` al inicio
- [ ] Llamar `get_footer()` al final
- [ ] Crear `css/nombre.css` con estilos específicos
- [ ] Si necesita JS, crear `js/nombre.js`
- [ ] Añadir carga condicional de CSS en template: `<link rel="stylesheet" href="...">`
- [ ] Añadir carga condicional de JS en `footer.php`
- [ ] Usar nombres de clases con prefijo `lizethweb__`
- [ ] Estructurar en secciones semánticas con `<section>`
- [ ] Incluir contenedor con clase `.contenedor`
- [ ] Usar Bootstrap grid: `.row`, `.col-lg-*`, `.col-md-*`
- [ ] Si usa datos ACF, obtenerlos al inicio del template
- [ ] Si usa posts, implementar WP_Query personalizado
- [ ] Documentar campos ACF requeridos
- [ ] Probar responsividad (mobile, tablet, desktop)

---

## 14. Notas Importantes

1. **ACF es obligatorio**: El tema depende completamente de ACF para contenido dinámico
2. **El filtro `the_title`**: Se aplica globalmente. Tener cuidado si se modifica
3. **Rutas API**: Usar siempre `${URL_BASE}` definido en header para compatibilidad
4. **Redes sociales**: Se obtienen de opciones globales ACF con switch statement en footer
5. **Email**: Configurado en `functions.php` con direcciones hardcodeadas
6. **SEO**: Usa Open Graph meta tags en header
7. **Performance**: Incluir solo JS/CSS necesarios por página (carga condicional)

---

## 15. Ejemplo Completo de Nueva Página

```php
<?php get_header(); ?>

<link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/nueva-pagina.css">

<?php
// Obtener datos
$banner = get_field("banner");
$contenido = get_field("contenido");

// Query si es necesaria
$args = array('posts_per_page' => 6);
$query = new WP_Query($args);
?>

<section class="lizethweb__nueva-pagina-banner" style="background-image: url(<?= $banner['imagen'] ?>);">
    <div class="lizethweb__nueva-pagina-banner-contenedor contenedor">
        <h1><?= $banner['titulo'] ?></h1>
    </div>
</section>

<section class="lizethweb__nueva-pagina-contenido">
    <div class="lizethweb__nueva-pagina-contenido-contenedor contenedor">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <h2><?= $contenido['titulo'] ?></h2>
                <p><?= $contenido['texto'] ?></p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
```

```css
/* css/nueva-pagina.css */
.lizethweb__nueva-pagina-banner {
    background-size: cover;
    background-position: center;
    padding: 60px 0;
}

.lizethweb__nueva-pagina-banner-contenedor h1 {
    color: white;
    text-align: center;
}
```

---

**Última actualización:** Análisis completo del tema
**Versión:** 1.0
