// resources/js/app.js

// 1. Importa jQuery y Select2
import $ from 'jquery';
import select2 from 'select2';

// 2. Haz que jQuery esté disponible globalmente
window.$ = window.jQuery = $;

// 3. Conecta Select2 manualmente a jQuery
select2($);

// 4. Importa Bootstrap (que ya encontrará $ disponible)
import './bootstrap';

// console.log('--- app.js se ha cargado y Select2 ha sido conectado manualmente ---');